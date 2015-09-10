function initMap() {

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: {lat: 47.218505, lng: -1.544658},
        scrollwheel: false
    });

    $.getJSON('/app_dev.php/api/events')
        .then(function(data) {
            return $.Deferred(function( defer ) {
                $.get('/bundles/akeneofrontoffice/templates/marker.mustache')
                    .then(function(template) {
                        defer.resolve(template, data);
                    }, defer.reject );
            }).promise();
        })
        .then(function(template, events) {
            events.forEach(function(event) {
                var marker = new google.maps.Marker({
                    position: {
                        lat: event.place.location.latitude,
                        lng: event.place.location.longitude
                    },
                    map: map
                });

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

google.maps.event.addDomListener(window, 'load', initMap);