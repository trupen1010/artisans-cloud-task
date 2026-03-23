$(document).ready(function () {
    // Allowed file types and size limits in MB
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
        'video/mp4': 1048576,
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
    inputMultipleElements.forEach(function (inputElement) {
        pond = FilePond.create(inputElement, {
            maxFiles: maxFileUploadLimit,
            maxParallelUploads: maxFileUploadLimit,
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
                    if (validFiles) {
                        $('.file-error').text("").hide();
                    }
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

                    if (typeof uploadDir === 'undefined') {
                        validFiles = validateAllFiles();
                        toggleUploadButton();
                    } else {
                        uploadFileBtn.prop('disabled', false);
                    }
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
            },/*  files: [
                UploadedFiles
            ], */
        });

        // File Handling Events
        pond.on('removefile', () => {
            valid = validateAllFiles();
            if (validFiles) {
                $('.file-error').text("").hide();
            }
            toggleUploadButton();

            if (typeof uploadDir !== 'undefined' && pond.getFiles().length === 0) {
                uploadFileBtn.prop('disabled', false);
            }
        });
        pond.on('warning', (error) => {
            validFiles = false;
            toggleUploadButton();
            if (error.body === "Max files") {
                $('.file-error').text('Maximum upload limit is ' + maxFileUploadLimit + ' files.').show();
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

        pondFiles.forEach(function (fileItem) {
            if (fileItem.status !== FilePond.FileStatus.PROCESSING_COMPLETE) {
                allValid = false;
            }
        });
        return allValid;
    }


    if (typeof uploadDir === 'undefined') {
        // Directory dropdown event handler
        $(document).on("change", "#directory", function () {
            const otherDiv = $('.other-directory-text-div');
            if ($(this).val() === 'other_directory') {
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
        $(document).on("input", "#other_directory", function () {
            validDirectory = $(this).val() !== '';
            toggleUploadButton();
        });

        // Validation function
        function validation() {
            let directoryDropdownValue = $('.directory').find(":selected").val(),
                otherValue = $('.other_directory').val(),
                error_flag = false;

            if (!directoryDropdownValue) {
                validDirectory = false;
                $('.directory-error').fadeIn();
                error_flag = true;
            } else {
                validDirectory = true;
                $('.directory-error').fadeOut();
            }

            if (directoryDropdownValue === 'other_directory' && !otherValue) {
                validDirectory = false;
                $('.other-directory-error').fadeIn();
                error_flag = true;
            } else {
                $('.other-directory-error').fadeOut();
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

    // Form Submit Event
    $(document).on("submit", formID, function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
        evt.stopImmediatePropagation();

        //show_loader();

        const files = pond.getFiles();

        const fileInfoArray = files.map(fileItem => {
            const file = fileItem.file;
            const filename = file.name;
            const fileExtension = filename.split('.').pop();

            return {
                original_name: filename,
                name: fileItem.serverId,
                size: file.size,
                extension: fileExtension,
            };
        });

        let formData = $(this).serializeArray();
        formData = formData.filter(function (item) {
            return item.name !== 'file';
        });
        const fileData = files.length > 0 ? JSON.stringify(fileInfoArray) : '';
        formData.push({ name: 'files', value: fileData });

        if (typeof uploadDir === 'undefined') {
            if (fileInfoArray.length > 0) {

                if (validation()) {
                    return;
                }

                try {
                    show_loader();

                    ajaxCall(uploadURL, 'POST', formData).then(function (response) {
                        show_notify(response.message, response.status);
                        if (response.status === 'success') {
                            setTimeout(function () {
                                hide_loader();
                                uploadFileBtn.prop('disabled', false).html(originalButtonText);
                                window.location.href = callbackURL;
                            }, 2000);
                        }
                    }).catch(function (error) {
                        hide_loader();
                        show_notify(error.message, 'fail');
                        uploadFileBtn.prop('disabled', false).html(originalButtonText);
                    });
                } catch (error) {
                    hide_loader();
                    show_notify("An error occurred during the upload of files.", 'fail');
                }

            } else {
                uploadFileBtn.prop('disabled', true);
                $('.file-error').text('Please upload at least one file.').show();
            }
        } else {
            try {
                show_loader();

                ajaxCall(formSubmitUrl, 'POST', formData).then(function (response) {
                    hide_loader();
                    $(".validation-error").fadeOut().remove();

                    if (response.status === 'success') {
                        uploadFileBtn.prop('disabled', false).html(originalButtonText);

                        if (typeof callbackURL === 'undefined') {
                            location.replace(response.response.redirect_url);
                        } else {
                            window.location.href = callbackURL;
                        }
                    }
                }).catch(function (error) {
                    hide_loader();
                    $(".validation-error").fadeOut().remove();
                    Object.entries(error.responseJSON.errors).forEach(([key, val]) => {
                        const $input = key.includes('.')
                            ? $(`[name="${key.split('.')[0]}[]"]`).eq(key.split('.')[1])
                            : $(`#${key.replace(/\./g, '_')}`);

                        if ($input.length) {
                            $input.parent().append(`<p class="text-danger fw-bold validation-error mb-0" style="display: none">${val[0]}</p>`);
                        }
                    });
                    $('.validation-error').fadeIn();

                    uploadFileBtn.prop('disabled', false).html(originalButtonText);
                });
            } catch (error) {
                hide_loader();
                show_notify("An error occurred during the upload of files.", 'fail');
            }
        }
    });
});
