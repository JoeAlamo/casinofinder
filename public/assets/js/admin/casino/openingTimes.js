/**
 * Created by Joe Alamo on 30/05/2016.
 */

$(document).ready(function() {
    var openingTimes = {},
        openingTimesCount = 0,
        openingTimesListDiv = $('#opening-times-list'),
        openingTimesTemplate = $('#opening-time-template');

    function initOpeningTimes() {
        // Add any existing opening times to the array as jQuery objects
        openingTimesListDiv.find('.opening-time').each(function(index, openingTime) {
            openingTimes[$(openingTime).attr('data-key')] = openingTime;
            openingTimesCount++;
        });
    }
    
    function addOpeningTime() {
        var newOpeningTime = $(openingTimesTemplate.html());
        if (openingTimesCount > 0) {
            newOpeningTime.find('.opening-time').attr('data-key', openingTimesCount);
            var fieldsNeedingUpdated = ['day', 'open_time', 'close_time'];
            for (var i = 0; i < fieldsNeedingUpdated.length; i++) {
                var fieldName = fieldsNeedingUpdated[i];
                newOpeningTime.find('select[name="opening_time[0][' + fieldName + ']"]').attr({
                    name: 'opening_time[' + openingTimesCount + '][' + fieldName + ']',
                    id: 'opening_time[' + openingTimesCount + '][' + fieldName + ']'
                });
            }
        }

        newOpeningTime.appendTo(openingTimesListDiv);
        openingTimes[openingTimesCount] = newOpeningTime;
        openingTimesCount++;
    }

    function removeOpeningTime(e) {
        var openingTimeDiv = $(e.currentTarget).parents('.opening-time');
        delete openingTimes[openingTimeDiv.attr('data-key')];
        openingTimesCount--;
        openingTimeDiv.parent().remove();
    }

    $('button#opening-time-add').click(addOpeningTime);

    openingTimesListDiv.on('click', '.opening-time button.opening-time-remove', removeOpeningTime);

    initOpeningTimes();
});