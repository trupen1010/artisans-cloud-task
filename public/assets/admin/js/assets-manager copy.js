$(document).ready(function() {
    // Allowed file types and size limits
    const fileTypeMaxSize = {
        'image/jpg': 5,
        'image/jpeg': 5,
        'image/png': 5,
        'image/gif': 5,
        'image/svg+xml': 1,
        'image/webp': 5,
        'application/msword': 20,
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 20,
        'application/vnd.ms-excel': 3,
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 3,
        'text/csv': 3,
        'application/vnd.ms-powerpoint': 20,
        'application/vnd.openxmlformats-officedocument.presentationml.presentation': 20,
        'application/pdf': 20,
        'video/mp4': 100,
        'audio/mpeg': 100,
        'text/plain': 1,
    };

    //let uploadFileBtn = $(".upload-files");
    let validFiles = false;
    let validDirectory = false;
    let originalButtonText = uploadFileBtn.html();
    let filesInProcess = 0;

    const inputMultipleElements = document.querySelectorAll("input.filepond");

    // Register the necessary plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType
    );

    // Loop through all input elements
    inputMultipleElements.forEach(function(inputElement) {
        pond = FilePond.create(inputElement, {
            maxFiles: maxFileUploadLimit,
            allowFileSizeValidation: true,
            instantUpload: true,
            allowProcess: true,
            allowReorder: true,
            dropValidation: true,
            allowMultiple: true,
            labelIdle: labelIdle,
            fileValidateTypeLabelExpectedTypes: 'Supported formats: {allButLastType} or {lastType}',
            acceptedFileTypes: Object.keys(fileTypeMaxSize).map(ext => ext),
            onaddfile: (error, file) => {
                if (!error) {
                    filesInProcess++;
                    uploadFileBtn.prop('disabled', true);
                }
            }, onprocessfile: (error, file) => {
                if (filesInProcess > 0) {
                    filesInProcess--;
                }
                if (error) {
                    validFiles = false;
                    $('.file-error').text('The file type or size is not allowed. Please upload a valid file.').show();
                } else {
                    validFiles = validateAllFiles();
                    $('.file-error').text("").hide();
                }
                if (filesInProcess === 0) {
                    toggleUploadButton();
                }
            }, server: {
                process: {
                    url: tmpUploadURL,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': _token
                    },
                    withCredentials: false,
                    onload: (response) => {
                        const { filename } = JSON.parse(response);
                        return filename;
                    },
                    onerror: (response) => {
                        let errorResponse = JSON.parse(response);
                        return errorResponse.message;
                    }
                }, revert: (filename, load) => {
                    ajaxCall(tmpRemoveURL, 'DELETE', { filename })
                    .then((response) => {
                        load();
                    })
                    .catch((error) => {
                        console.error('File revert error:', error);
                    });
                    validFiles = validateAllFiles();
                    toggleUploadButton();
                }
            }, beforeAddFile: (file) => {
                const fileName = file.filename;
                const fileType = file.fileType;
                const maxSize = fileTypeMaxSize[fileType];

                if ((file.fileSize / 1024 / 1024).toFixed(2) >= maxSize) {
                    show_notify(`The file size of ${fileName} exceeds the limit of ${maxSize} MB.`, 'fail');
                    return false;
                }
                return true;
            }
        });

        // File Handling Events
        pond.on('removefile', () => {
            validFiles = validateAllFiles();
            if (validFiles) {
                $('.file-error').text("").hide();
            }
            toggleUploadButton();
        });

        pond.on('warning', (error) => {
            validFiles = false;
            toggleUploadButton();
            if (error.body === "Max files") {
                $('.file-error').text('Maximum upload limit is '+maxFileUploadLimit+' files.').show();
            } else {
                $('.file-error').text(error.body).show();
            }
        });

        pond.on('error', (error) => {
            validFiles = false;
            toggleUploadButton();
            $('.file-error').text(error.body).show();
        });
    });

    // Validate all files
    function validateAllFiles() {
        let allValid = true;
        const pondFiles = pond.getFiles();

        if (pondFiles.length === 0) {
            return false;
        }

        pondFiles.forEach(function(fileItem) {
            if (fileItem.status !== FilePond.FileStatus.PROCESSING_COMPLETE) {
                allValid = false;
            }
        });

        return allValid;
    }

    // Form Submit Event
    $(document).on("submit", formID, function(evt) {
        evt.preventDefault();

        if (typeof uploadDir === 'undefined') {
            if (validation()) {
                return;
            }
        }

        let formData = $(this).serializeArray();

        formData = formData.filter(function(item) {
            return item.name !== 'file';
        });

        const files = pond.getFiles();

        const fileInfoArray = files.map(fileItem => {
            const file = fileItem.file;
            const filename = file.name;
            const fileExtension = filename.split('.').pop();
            const filenameWithoutExtension = filename.replace(`.${fileExtension}`, '');

            return {
                original_name: filename,
                name: fileItem.serverId,
                size: file.size,
                extension: fileExtension,
            };
        });

        formData.push({name: 'files', value: JSON.stringify(fileInfoArray)});

        if (typeof uploadDir !== 'undefined') {
            formData.push({name: 'directory', value: uploadDir});
        }

        /* console.log(formData, uploadURL, callbackURL, formID);
        return false; */        

        if (fileInfoArray.length > 0) {
            try {
                ajaxCall(uploadURL, 'POST', formData).then(function (response) {
                    show_notify(response.message, response.status);
                    if (response.status === 'success') {
                        setTimeout(function () {
                            uploadFileBtn.prop('disabled', false).html(originalButtonText);
                            window.location.href = callbackURL;
                        }, 2000);
                    }
                }).catch(function (error) {
                    show_notify(error.message, 'fail');
                    hide_loader();
                    uploadFileBtn.prop('disabled', false).html(originalButtonText);
                });
            } catch (error) {
                show_notify("An error occurred during the upload of files.", 'fail');
            }
        } else {
            $('.file-error').text('Please upload at least one file.').show();
        }
    });

    if (typeof uploadDir === 'undefined') {
        // Directory dropdown event handler
        $(document).on("change", "#directory", function() {
            const otherDiv = $('.other-text-div');
            if ($(this).val() === 'other') {
                validDirectory = false;
                otherDiv.fadeIn();
            } else if ($(this).val()) {
                validDirectory = true;
                otherDiv.fadeOut();
            } else {
                validDirectory = false;
                otherDiv.fadeOut();
            }
            toggleUploadButton();
        });

        // 'Other' input field handler
        $(document).on("input", "#other", function() {
            validDirectory = $(this).val() !== '';
            toggleUploadButton();
        });

        // Validation function
        function validation() {
            let directoryDropdownValue = $('.directory').find(":selected").val(),
                otherValue = $('.other').val(),
                error_flag = false;

            if (!directoryDropdownValue) {
                validDirectory = false;
                $('.directory-error').fadeIn();
                error_flag = true;
            } else {
                validDirectory = true;
                $('.directory-error').fadeOut();
            }

            if (directoryDropdownValue === 'other' && !otherValue) {
                validDirectory = false;
                $('.other-error').fadeIn();
                error_flag = true;
            } else {
                $('.other-error').fadeOut();
            }
            toggleUploadButton();

            return error_flag;
        }
    }

    // Toggle upload button
    function toggleUploadButton() {
        validFiles = validateAllFiles();

        if (typeof uploadDir !== 'undefined') {
            validDirectory = true;
        }

        if (validFiles && validDirectory && filesInProcess === 0) {
            uploadFileBtn.prop('disabled', false);
        } else {
            uploadFileBtn.prop('disabled', true);
        }
    }
});