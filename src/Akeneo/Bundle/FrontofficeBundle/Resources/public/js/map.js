var map;

function initMap() {

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: 47.218505, lng: -1.544658},
        scrollwheel: false
    });

    loadMap();
}

function loadMap(latitude, longitude, from) {
    var url = generateUrl(from);
    if (typeof latitude !== 'undefined' && typeof  longitude !== 'undefined') {
        var mapCenter = new google.maps.LatLng(latitude, longitude);
        map.panTo(mapCenter);
        map.setZoom(8);
    }
    deleteMarkers();

    $.getJSON(url)
        .then(function (data) {
            return $.Deferred(function (defer) {
                $.get('/bundles/akeneofrontoffice/templates/marker.mustache')
                    .then(function (template) {
                        defer.resolve(template, data);
                    }, defer.reject);
            }).promise();
        })
        .then(function(template, events) {
            events.forEach(function(event) {
                var marker = new google.maps.Marker({
                    position: {
                        lat: event.place.location.latitude,
                        lng: event.place.location.longitude,
                    },
                    icon: '/bundles/akeneofrontoffice/images/marker-' + event.user.group + '.png',
                    map: map
                });
                markers.push(marker);
                marker.addListener('click', function (e) {
                    new google.maps.InfoWindow({
                        content: Mustache.render(template, $.extend(event, {
                            "gravatar": md5(event.user.email.trim())
                        }))
                    }).open(map, marker);
                });
            });
        });
}

function deleteMarkers() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }

    markers = [];
}

function generateUrl(from) {
    var url = '/app_dev.php/api/events';
    if (typeof from !== 'undefined') {
        url += '?from=' + from;
        url += '&to=' + from + '+1 day';
    }

    return url;
}

var map;
var markers = [];
google.maps.event.addDomListener(window, 'load', initMap);

$("#create_event_btn").click(function (event) {
    event.preventDefault();
    $(window).scrollTo($("#add_event_form"), 1000);
});

$('#form_filter').submit(function (event) {
    event.preventDefault();
    latitude = $('#filter_latitude').val();
    longitude = $('#filter_longitude').val();
    date = $('#filter_date').val();

    loadMap(latitude, longitude, date);
});
