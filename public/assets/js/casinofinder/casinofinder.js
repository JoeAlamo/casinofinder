/**
 * Created by Joe Alamo on 13/06/2016.
 */

$(document).ready(function() {
    /*********************
     * VARIABLES
     ********************/
    var infoWindow = new google.maps.InfoWindow,
        markers = {},
        map,
        viewCasinoModal = $('#view-casino-modal'),
        viewCasinoModalBody = viewCasinoModal.find('.modal-body'),
        viewCasinoModalTitle = viewCasinoModal.find('#view-casino-modal-label'),
        autoComplete,
        usersLatLng;

    /*********************
     * FUNCTIONS
     ********************/

    /*********************
     * LOADING CASINOS
     ********************/

    // Iterate through casinos returned, and call createCasinoMarker on each
    function retrieveCasinosSuccess(data) {
        $.each(data, function(id, casino) {
            // Create marker for each casino
            var marker = createCasinoMarker(id, casino);
            // Attach event listener to marker to open infowindow upon click
            attachClickEventToMarker(marker);
        });
    }

    // Log error
    function retrieveCasinosError(data) {
        console.log(data);
    }

    // Create the actual marker object and display it on the map
    function createCasinoMarker(id, casino) {
        var marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(
                casino.casino_location.latitude,
                casino.casino_location.longitude
            )
        });
        marker.casino = casino; // Augment marker object with casino

        return markers[id] = marker;
    }

    // Attach click event to the marker so that it builds and opens infowindow upon being clicked
    function attachClickEventToMarker(marker) {
        google.maps.event.addListener(marker, 'click', function() {
            // Focus and zoom to marker
            map.panTo(marker.getPosition());
            map.setZoom(12);

            // Build infowindow content
            var content = [
                '<h4>' + marker.casino.name + '</h4>'
            ];

            if (typeof marker.casino.distance !== 'undefined') {
                content.push('<p class="text-center">' + marker.casino.distance + ' miles away</p>');
            }

            content.push(
                '<button role="button" id="viewCasinoButton" class="btn btn-primary btn-block" data-toggle="modal" data-target="#view-casino-modal">View</button>'
            );

            infoWindow.setContent(content.join(""));

            // Open infowindow
            infoWindow.open(marker.getMap(), marker);
        });
    }

    /*********************
     * INFO MODALS
     ********************/

    // When "View" is clicked in info window, display modal with more information about that casino
    viewCasinoModal.on('show.bs.modal', function(e) {
        // Build content. .anchor is the marker which initiated the infowindow
        buildModalContent(infoWindow.anchor.casino);
    });

    function buildModalContent(casino) {
        if (typeof casino === "undefined") {
            viewCasinoModalTitle.html('');
            viewCasinoModalBody.html('<p>An error occurred. Please try again</p>');

            return;
        }

        // Set title
        if (typeof casino.distance === 'undefined') {
            viewCasinoModalTitle.text(casino.name);
        } else {
            viewCasinoModalTitle.text(casino.name + ' - ' + casino.distance + ' miles away');
        }
        // Build body
        var bodyContent = [
            '<div class="row">',
                '<div class="col-md-4">',
                    '<h4 class="margin-top-sm">Description</h4>',
                    '<p>' + (casino.description == "" ? 'No description' : casino.description) + '</p>',
                    '<h4 class="margin-top-sm">Location</h4>',
                    '<p>' + casino.casino_location.address + ', ' + casino.casino_location.city + ', ' + casino.casino_location.postal_code + '</p>',
                '</div>',
                '<div class="col-md-8">',
                    '<h4 class="margin-top-sm">Opening Times</h4>',
                    '<div class="row">',
                        '<div class="col-xs-4"><strong>Day</strong></div>',
                        '<div class="col-xs-4"><strong>Opening Time</strong></div>',
                        '<div class="col-xs-4"><strong>Closing Time</strong></div>',
                    '</div>'
        ];


        $.each(casino.formatted_casino_opening_times, function(index, openingTime) {
            var openingTimeRow = [
                '<div class="row">',
                    '<div class="col-xs-4">' + openingTime.day_string + '</div>',
                    '<div class="col-xs-4">' + openingTime.open_time + '</div>',
                    '<div class="col-xs-4">' + openingTime.close_time + '</div>',
                '</div>'
            ];

            bodyContent = bodyContent.concat(openingTimeRow);
        });

        bodyContent.push('</div></div>');

        viewCasinoModalBody.html(bodyContent.join(""));
    }

    /*********************
     * FIND NEAREST CASINO
     ********************/

    function findNearestCasino(LatLng) {
        $.ajax({
            type: 'GET',
            url: '/casinoFinder/findNearestCasino',
            data: {
                latitude: LatLng.lat(),
                longitude: LatLng.lng()
            },
            success: function(data) {
                if (data.found) {
                    showCasino(data.id, data.distance);
                } else {
                    showNoCasino();
                }
            },
            error: showNoCasino
        });
    }

    function showCasino(casinoId, distance) {
        var casinoFindFailAlert = $('#casino-find-fail');

        if (casinoFindFailAlert.is(':visible')) {
            casinoFindFailAlert.slideUp(200);
        }

        markers[casinoId].casino.distance = distance;

        google.maps.event.trigger(markers[casinoId], 'click');
    }
    
    function showNoCasino() {
        var casinoFindFailAlert = $('#casino-find-fail');

        if (!casinoFindFailAlert.is(':visible')) {
            casinoFindFailAlert.hide().removeClass('hidden').delay(200).slideDown(800, function () {
                fallbackToAutoComplete();
                $(this).delay(5000).slideUp(800);
            });
        }
    }

    /*********************
     * GEOLOCATION CALLBACKS
     ********************/

    function geolocationSuccess(position) {
        usersLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        findNearestCasino(usersLatLng);
    }

    function geolocationFail(error) {
        console.log(error);
        fallbackToAutoComplete();
    }

    /*********************
     * AUTOCOMPLETE FALLBACK
     ********************/

    function fallbackToAutoComplete() {
        initAutoComplete();
        displayAutoComplete();
    }

    function initAutoComplete() {
        if (typeof autoComplete === "undefined") {
            autoComplete = new google.maps.places.Autocomplete(
                document.getElementById('users_address'),
                {types: ['address']}
            );

            // Upon selecting address, find nearest casino
            autoComplete.addListener('place_changed', autoCompleteCallback);
        }
    }

    function displayAutoComplete() {
        var autoCompleteInput = $('#users_address_container');

        if (!autoCompleteInput.is(':visible')) {
            autoCompleteInput.hide().removeClass('hidden').delay(1000).slideDown(800);
        }
    }

    function autoCompleteCallback() {
        usersLatLng = autoComplete.getPlace().geometry.location;
        findNearestCasino(usersLatLng);
    }

    /*********************
     * EXECUTION
     ********************/

    // Init map
    map = googleMap.initMap('map');

    // Retrieve casinos, create markers + listeners
    $.ajax({
        type: 'GET',
        url: '/casinoFinder/getAllCasinos',
        success: retrieveCasinosSuccess,
        error: retrieveCasinosError
    });

    /**
     * Request users location asynchronously.
     * If no geolocation API or error, init and display address autocomplete.
     * Otherwise, nearest casino to location will be searched and then displayed
     */
    if (("geolocation" in navigator)) {
        navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationFail);
    } else {
        fallbackToAutoComplete();
    }

});