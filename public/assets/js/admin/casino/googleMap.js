/**
 * Created by Joe Alamo on 07/06/2016.
 */

var googleMap = googleMap || {};

googleMap = (function () {
    // Private variables
    var map,
        marker,
        mapId;

    // Methods
    
    var initMap = function(mapElementId) {
        mapId = mapElementId;

        map = new google.maps.Map(document.getElementById(mapElementId), {
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
    };

    var showLocation = function(LatLng) {
        map.panTo(LatLng);
        map.setZoom(17);

        marker.setPosition(LatLng);
        marker.setMap(map);
    };

    // Return publicly accessible variables or methods
    return {
        initMap: initMap,
        showLocation: showLocation
    }
})();
