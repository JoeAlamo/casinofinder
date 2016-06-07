/**
 * Created by Joe Alamo on 07/06/2016.
 */

$(document).ready(function() {
    var map = $('#map'),
        latitude = map.attr('data-latitude'),
        longitude = map.attr('data-longitude');

    googleMap.initMap(map.attr('id'));
    googleMap.showLocation(new google.maps.LatLng(latitude, longitude))
});