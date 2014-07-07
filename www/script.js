var map = null;
var base_url = 'http://countries.localhost';

function initialize() {
    var mapOptions = {
            zoom: 4,
            center: new google.maps.LatLng(45.363882, 25.044922),
            mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    var crosshairShape = {coords:[0,0,0,0],type:'rect'};
    var marker = new google.maps.Marker({
            map: map,
            icon: base_url + '/cross-hair.gif',
            shape: crosshairShape
    });
    marker.bindTo('position', map, 'center');
    google.maps.event.addListener(map, 'center_changed', writeMapStatus);
}
google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function() {
        $('#country').change(function() {
                var op = $('#country option:selected')[0];
                var name = $(op).text();
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: name }, function (results) {
                        if (results.length > 0) {
                var p = results[0].geometry.location;
                var latlng = new google.maps.LatLng(p.lat(), p.lng());
                zoom = 6;
                map.panTo(latlng);
                map.setZoom(6)
            }
                });
        });
        $('#save').click(function() {
                var op = $('#country option:selected')[0];
                var country_id = $(op).val();
                var center = map.getBounds().getCenter();
                var zoom = map.getZoom();
                save(country_id, center.lat(), center.lng(), zoom, function(data) {
                    var selected = $($('#country option:selected')[0]);
                    selected.next('option').attr('selected', 'selected');
                    selected.remove();
                    $('#country').trigger('change');
                });
        });
        $('#valid').change(function() {
            var op = $('option:selected', this)[0];
            var country_id = $(op).val();            
            $.post(base_url + '/ajax.php',
                {
                    action: 'get_country',
                    country : country_id
                },
                function(data) {
                    if(data.success) {
                        var lat = data.country.latitude;
                        var lng = data.country.longitude;
                        var zoom = data.country.zoom;
                        var latlng = new google.maps.LatLng(lat, lng);
                        map.panTo(latlng);
                        map.setZoom(6)
                    }
                }
            );
        });
});


function save(id, latitude, longitude, zoom, callback) {
    $.post(base_url + '/ajax.php',
            {
                action: 'save',
                country : id, 
                latitude : latitude, longitude: longitude, zoom: zoom
            },
            function(data) {
                if(data.success && callback) {
                    callback(data); 
                }
            }
    );
}

function writeMapStatus() {
        var c = map.getBounds().getCenter();
        var z = map.getZoom();
        $('#coordinates').html(c.lat() + ', ' + c.lng() + ', z=' + z);
}
