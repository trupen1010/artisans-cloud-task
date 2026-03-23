/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.uiColor = '#D8E4F9';
    config.versionCheck = false;

    config.extraPlugins = 'wordcount';
    config.wordcount = {
        showWordCount: true,
        showCharCount: true,
        maxWordCount: 7000,
        maxCharCount: 20000
    };

    config.toolbar = [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', 'RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'] },
        { name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'links', items: ['Link', 'Unlink'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        //'/',
        { name: 'insert', items: ['Image', 'Table', 'SpecialChar', 'HorizontalRule'] },
        { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
        { name: 'tools', items: ['Preview', 'Maximize'] }
    ];
};
