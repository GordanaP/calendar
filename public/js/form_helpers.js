/**
 * Remove the error upon triggering an event on a given element.
 */
function clearErrorOnTriggeringAnEvent() {
    $("input, textarea").on('keydown', function () {
         clearError($(this).attr('name'));
    });

    $("select").on('change', function () {
         clearError($(this).attr('name'));
    });

    $("input[type=radio]").on('click', function() {
         clearError($(this).attr('name'));
    });

    $("input[type=checkbox]").on('click', function() {
        var name = $(this).attr('name').slice(0,-2);
        clearError($(this).attr('name'));
    });
}

/**
 * Remove the error.
 *
 * @param  string error
 */
function clearError(error) {
    errorEl(error).empty().hide();
}

/**
 * Display errors.
 *
 * @param  array errors
 */
function displayErrors(errors) {
    for (error in errors) {
        var errorMessage = errors[error][0];
        errorEl(error).show().text(errorMessage);
    }
}

/**
 * Html element containing the given error.
 *
 * @param  string error
 * @return JQuery\Jquery Object
 */
function errorEl(error) {
    return $('.'+error);
}