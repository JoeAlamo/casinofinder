/**
 * Created by Joe Alamo on 30/05/2016.
 */

$(document).ready(function() {
    var TIME_PATTERN = /^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/,
        opening_time_dayValidators = {
            icon: false,
            row: '.col-xs-12.col-sm-3',
            validators: {
                regexp: {
                    regexp: /^[0-6]$/,
                    message: 'Invalid day'
                }
            }
        },
        opening_time_open_timeValidators = {
            icon: false,
            row: '.col-xs-12.col-sm-3',
            validators: {
                regexp: {
                    regexp: TIME_PATTERN,
                    message: 'Invalid time'
                },
                callback: {
                    message: 'The open time must be earlier than the close time',
                    callback: function(value, validator, $field) {
                        var key = $field.parents('.opening-time').attr('data-key'),
                            closeTimeField = $field.parents('.opening-time').find('[name="opening_time[' + key + '][close_time]"]'),
                            closeTime = closeTimeField.val(),
                            openHour = parseInt(value.split(':')[0], 10),
                            openMinutes = parseInt(value.split(':')[1], 10),
                            openSeconds = parseInt(value.split(':')[2], 10),
                            closeHour = parseInt(closeTime.split(':')[0], 10),
                            closeMinutes = parseInt(closeTime.split(':')[1], 10),
                            closeSeconds = parseInt(closeTime.split(':')[2], 10),
                            valid = false;

                        if (openHour < closeHour) {
                            valid = true;
                        } else if (openHour == closeHour && openMinutes < closeMinutes) {
                            valid = true;
                        } else if (openHour == closeHour && openMinutes == closeMinutes && openSeconds < closeSeconds) {
                            valid = true;
                        }

                        if (valid) {
                            // Means that close time is also valid!! Lets make formValidation aware of that
                            validator.updateStatus(closeTimeField.attr('name'), validator.STATUS_VALID, 'callback');
                        }

                        return valid;
                    }
                }
            }
        },
        opening_time_close_timeValidators = {
            icon: false,
            row: '.col-xs-12.col-sm-3',
            validators: {
                regexp: {
                    regexp: TIME_PATTERN,
                    message: 'Invalid time'
                },
                callback: {
                    message: 'The close time must be later than the open time',
                    callback: function(value, validator, $field) {
                        var key = $field.parents('.opening-time').attr('data-key'),
                            openTimeField = $field.parents('.opening-time').find('[name="opening_time[' + key + '][open_time]"]'),
                            openTime = openTimeField.val(),
                            closeHour = parseInt(value.split(':')[0], 10),
                            closeMinutes = parseInt(value.split(':')[1], 10),
                            closeSeconds = parseInt(value.split(':')[2], 10),
                            openHour = parseInt(openTime.split(':')[0], 10),
                            openMinutes = parseInt(openTime.split(':')[1], 10),
                            openSeconds = parseInt(openTime.split(':')[2], 10),
                            valid = false;

                        if (closeHour > openHour) {
                            valid = true;
                        } else if (closeHour == openHour && closeMinutes > openMinutes) {
                            valid = true;
                        } else if (closeHour == openHour && closeMinutes == openMinutes && closeSeconds > openSeconds) {
                            valid = true;
                        }

                        if (valid) {
                            // Means that open time is also valid!! Lets make formValidation aware of that
                            validator.updateStatus(openTimeField.attr('name'), validator.STATUS_VALID, 'callback');
                        }

                        return valid;
                    }
                }
            }
        };

    var openingTimes = {},
        openingTimesCount = 0,
        openingTimesListDiv = $('#opening-times-list'),
        openingTimesTemplate = $('#opening-time-template'),
        form = $('#admin-casino-form');

    function initOpeningTimes() {
        // Add any existing opening times to the array as jQuery objects and enable validators
        openingTimesListDiv.find('.opening-time').each(function(index, openingTime) {
            openingTimes[$(openingTime).attr('data-key')] = openingTime;
            form.formValidation('addField', 'opening_time[' + openingTimesCount + '][day]', opening_time_dayValidators)
                .formValidation('addField', 'opening_time[' + openingTimesCount + '][open_time]', opening_time_open_timeValidators)
                .formValidation('addField', 'opening_time[' + openingTimesCount + '][close_time]', opening_time_close_timeValidators);
            openingTimesCount++;
        });
    }
    
    function addOpeningTime() {
        var newOpeningTime = $(openingTimesTemplate.html());
        // Update the field's keys for data-key, name and id (opening_time[KEY][day] for example)
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
        form.formValidation('addField', 'opening_time[' + openingTimesCount + '][day]', opening_time_dayValidators)
            .formValidation('addField', 'opening_time[' + openingTimesCount + '][open_time]', opening_time_open_timeValidators)
            .formValidation('addField', 'opening_time[' + openingTimesCount + '][close_time]', opening_time_close_timeValidators);
        openingTimes[openingTimesCount] = newOpeningTime;
        openingTimesCount++;
    }

    function removeOpeningTime(e) {
        var openingTimeDiv = $(e.currentTarget).parents('.opening-time'),
            key = openingTimeDiv.attr('data-key');
        form.formValidation('removeField', openingTimeDiv.find('[name="opening_time[' + key + '][day]"]'))
            .formValidation('removeField', openingTimeDiv.find('[name="opening_time[' + key + '][open_time]"]'))
            .formValidation('removeField', openingTimeDiv.find('[name="opening_time[' + key + '][close_time]"]'));
        delete openingTimes[key];
        openingTimesCount--;
        openingTimeDiv.parent().remove();
    }

    $('button#opening-time-add').click(addOpeningTime);

    openingTimesListDiv.on('click', '.opening-time button.opening-time-remove', removeOpeningTime);

    initOpeningTimes();
});