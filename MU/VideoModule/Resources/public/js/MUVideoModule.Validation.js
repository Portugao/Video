'use strict';

function mUVideoValidateNoSpace(val) {
    var valStr;
    valStr = new String(val);

    return (valStr.indexOf(' ') === -1);
}

function mUVideoValidateUploadExtension(val, elem) {
    var fileExtension, allowedExtensions;
    if (val === '') {
        return true;
    }

    fileExtension = '.' + val.substr(val.lastIndexOf('.') + 1);
    allowedExtensions = jQuery('#' + elem.attr('id') + 'FileExtensions').text();
    allowedExtensions = '(.' + allowedExtensions.replace(/, /g, '|.').replace(/,/g, '|.') + ')$';
    allowedExtensions = new RegExp(allowedExtensions, 'i');

    return allowedExtensions.test(val);
}

/**
 * Runs special validation rules.
 */
function mUVideoExecuteCustomValidationConstraints(objectType, currentEntityId) {
    jQuery('.validate-upload').each(function () {
        if (!mUVideoValidateUploadExtension(jQuery(this).val(), jQuery(this))) {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity(Translator.__('Please select a valid file extension.'));
        } else {
            document.getElementById(jQuery(this).attr('id')).setCustomValidity('');
        }
    });
}
