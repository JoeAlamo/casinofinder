/**
 * Created by Joe Alamo on 03/06/2016.
 */

$(document).ready(function() {
    var deleteCasinoButton,
        form = $('#delete-casino-form'),
        formSubmitButton = form.find('#delete-casino-submit'),
        modal = $('#delete-casino-modal'),
        modalBody = modal.find('.modal-body'),
        casinoCount = $('.casino-panel').length,
        noCasinoAlert = $('#no-casino-alert');

    if (casinoCount == 0) {
        noCasinoAlert.removeClass('hidden');
    }

    function deleteCasinoSuccess(data) {
        // Disable submit to prevent duplicates
        formSubmitButton.prop('disabled', true);
        // Delete the related casino panel
        deleteCasinoButton.parents('.panel').remove();
        casinoCount--;
        if (casinoCount == 0) {
            noCasinoAlert.removeClass('hidden');
        }
        // Inform of success then close modal
        var successMsg = $('<p class="alert alert-success"><strong>' + data + '</strong></p>');
        modalBody.append(successMsg);
        setTimeout(function() {
            successMsg.hide('fast', function () {
                successMsg.remove();
                modal.modal('hide');
            })
        }, 2000);
    }

    function deleteCasinoFail(data) {
        // Inform of error
        var errorMsg = $('<p class="alert alert-danger"><strong>An error occurred whilst attempting to delete the casino. Try again shortly.</strong></p>');
        modalBody.append(errorMsg);
        setTimeout(function() {
            errorMsg.hide('fast', function () {
                errorMsg.remove();
            })
        }, 5000);
    }


    modal.on('show.bs.modal', function(e) {
        deleteCasinoButton = $(e.relatedTarget);

        // Set correct delete casino URL
        form.attr('action', deleteCasinoButton.attr('data-url'));

        // Make sure button is usable
        formSubmitButton.prop('disabled', false);
    });

    form.submit(function(e) {
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: deleteCasinoSuccess,
            error: deleteCasinoFail
        });

        e.preventDefault();
    });

});