/**
 * Created by Joe Alamo on 28/05/2016.
 */

$(document).ready(function() {

    var autoComplete,
        formComponents = {
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

    // Configure the auto-complete and bind listener
    function initAutocomplete() {
        autoComplete = new google.maps.places.Autocomplete(
            document.getElementById('address_autocomplete'),
            {types: []}
        );

        // Upon selecting address, populate form fields
        autoComplete.addListener('place_changed', fillInAddress);
    }

    // If we are being returned to the page due to errors etc., make the form usable!
    function detectExistingInput() {
        var latitudeInput = $(formComponents.latitude.id),
            longitudeInput = $(formComponents.longitude.id);

        if (!latitudeInput.val().length && !longitudeInput.val().length) {
            return;
        }

        $.each(formComponents, function(index, formComponent) {
            $(formComponent.id).prop("disabled", false);
        });

        googleMap.showLocation(new google.maps.LatLng(latitudeInput.val(), longitudeInput.val()));
    }

    // Upon selecting an address, autofill the form and display location on map
    function fillInAddress() {
        var place = autoComplete.getPlace(),
            form = $('#admin-casino-form');

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

        // Trigger validation of address, city, postal_code
        form.formValidation('revalidateField', 'address')
            .formValidation('revalidateField', 'city')
            .formValidation('revalidateField', 'postal_code');


        // Show location on map
        googleMap.showLocation(place.geometry.location);
    }

    googleMap.initMap('map');
    initAutocomplete();
    detectExistingInput();
});
