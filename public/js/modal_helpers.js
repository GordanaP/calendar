/**
 * Reset the modal content upon close.
 *
 * @param  array errors
 */
$.fn.clearContentOnClose = function(errors)
{
    $(this).on("hidden.bs.modal", function() {

        $(this).clearFormContent()

        $(this).clearAllErrors(errors)

        // Remove timepicker
        // $(this).clearTimepicker(timepickerField)
    });
}

/**
 * Remove all errors.
 *
 * @param  array errors
 */
$.fn.clearAllErrors = function(errors) {
     $.each(errors, function (index, error) {
        clearError(error);
    });
}

/**
 * Clear the form content.
 */
$.fn.clearFormContent = function()
{
    $(this).find('form').trigger('reset');
}

/**
 * Clear the timepicker.
 *
 * @param  string timepickerField
 */
$.fn.clearTimepicker = function(timepickerField)
{
    $(this).find(timepickerField).timepicker('remove');
}

/**
 * The modal autofocus field.
 *
 * @param string elementId
 */
$.fn.autofocus = function(elementId) {
    $(this).on('shown.bs.modal', function () {
        $(this).find(elementId).focus();
    })
}

/**
 * Close the modal.
 */
$.fn.close = function() {
    $(this).modal('hide');
}

/**
 * Open the modal.
 */
$.fn.open = function() {
    $(this).modal('show');
}
