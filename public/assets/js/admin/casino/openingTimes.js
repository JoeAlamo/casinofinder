/**
 * Created by Joe Alamo on 30/05/2016.
 */

$(document).ready(function() {
    function addOpeningTime() {
        $('#opening-times-list').append($('#opening-time-template').html());
    }

    function removeOpeningTime(e) {
        var openingTimeDiv = $(e.currentTarget).parents('.opening-time');
        openingTimeDiv.remove();
    }

    $('button#opening-time-add').click(addOpeningTime);

    $('#opening-times-list').on('click', '.opening-time button.opening-time-remove', removeOpeningTime);
});