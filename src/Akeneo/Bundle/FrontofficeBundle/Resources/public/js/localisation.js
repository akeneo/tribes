function initAutocomplete(element) {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    element.data('autocomplete', new google.maps.places.Autocomplete(element[0], {types: ['geocode']}));

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    element.data('autocomplete').addListener('place_changed', function() {
        // Get the place details from the autocomplete object.
        var place = element.data('autocomplete').getPlace();
        var location = place.geometry.location;

        $(element.data('longitude-selector')).val(location.lng());
        $(element.data('latitude-selector')).val(location.lat());
    });
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate(element) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            element.data('autocomplete').setBounds(circle.getBounds());
        });
    }
}

$(function () {
    $(".geolocate").each(function() {
        initAutocomplete($(this));
    });

    $(".geolocate").focus(function() {
        geolocate($(this));
    });
});

