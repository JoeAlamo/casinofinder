/**
 * Created by Joe Alamo on 28/05/2016.
 */

$(document).ready(function() {

    var autoComplete, map, marker;
    var formComponents = {
        name: {
            id: '#address',
            addressComponent: false
        },
        locality: {
            id: '#city',
            addressComponent: true
        },
        postal_code: {
            id: '#postal_code',
            addressComponent: true
        },
        place_id: {
            id: '#google_maps_place_id',
            addressComponent: false
        },
        latitude: {
            id: '#latitude',
            addressComponent: false
        },
        longitude: {
            id: '#longitude',
            addressComponent: false
        }
    };

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 54.9778, lng: -1.6129},
            zoom: 6,
            mapTypeControl: false,
            panControl: false,
            zoomControl: false,
            streetViewControl: false
        });

        marker = new google.maps.Marker({
            position: {lat: 54.9778, lng: -1.6129}
        });
    }

    function initAutocomplete() {
        autoComplete = new google.maps.places.Autocomplete(document.getElementById('address_autocomplete'));

        // Upon selecting address, populate form fields
        autoComplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        var place = autoComplete.getPlace();

        // We want to fill in the street address, city, postal code, place ID, lat and long

        // Reset values first
        $.each(formComponents, function(index, formComponent) {
            $(formComponent.id).prop("disabled", false).val('');
        });

        // Manually retrieve place name, ID, lat + long and fill
        $(formComponents.name.id).val(place.name);
        $(formComponents.place_id.id).val(place.place_id);
        $(formComponents.latitude.id).val(place.geometry.location.lat());
        $(formComponents.longitude.id).val(place.geometry.location.lng());

        // Reduce formComponents to array of keys representing address components
        var ourAddressComponents = Object.keys(formComponents).filter(function(formComponent) {
            return formComponents[formComponent].addressComponent;
        });

        // Filter returned address components to keep ones that we need for the form
        var matchingAddressComponents = place.address_components.filter(function(address_component) {
            for (var i = 0; i < ourAddressComponents.length; i++) {
                if (address_component.types[0] === ourAddressComponents[i]) {
                    // Tag the corresponding form component
                    address_component.matchingFormComponent = formComponents[ourAddressComponents[i]];
                    break;
                }
            }

            return address_component.hasOwnProperty('matchingFormComponent');
        });

        // Fill in rest of components
        $.each(matchingAddressComponents, function (index, matchingAddressComponent) {
            $(matchingAddressComponent.matchingFormComponent.id).val(matchingAddressComponent.long_name);
        });


        // Show location on map
        map.panTo(place.geometry.location);
        map.setZoom(17);

        marker.setPosition(place.geometry.location);
        marker.setMap(map);
    }

    initMap();
    initAutocomplete();
});
