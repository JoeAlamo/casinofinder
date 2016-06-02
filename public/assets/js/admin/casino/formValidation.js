/**
 * Created by Joe Alamo on 02/06/2016.
 */

$(document).ready(function () {

    $('#admin-casino-form').formValidation({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        live: 'enabled',
        excluded: [':hidden', ':not(:visible)'],
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a name for the casino'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The name of the casino can\'t exceed 255 characters'
                    }
                }
            },
            description: {
                validators: {
                    stringLength: {
                        max: 255,
                        message: 'The description can\'t exceed 255 characters'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'Please enter an address line'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The address can\'t exceed 255 characters'
                    }
                }
            },
            city: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the city'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The city can\'t exceed 255 characters'
                    }
                }
            },
            postal_code: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a postal code'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The postal code can\'t exceed 255 characters'
                    }
                }
            }
        }
    });
});