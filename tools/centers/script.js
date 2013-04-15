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
                latlng = new google.maps.LatLng(p.lat(), p.lng());
                zoom = 6;
                map.panTo(latlng);
                map.setZoom(6)
            }
				});
		});
		$('#save').click(function() {
				var op = $('#country option:selected')[0];
				var country_id = $(op).val();
				var center = map.getCenter();
				var zoom = map.getZoom();

				$.post(base_url + '/ajax.php',
						{
								country : country_id, 
								latitude : center.lat(),
								longitude: center.lng(),
                                zoom: zoom
						},
						function(data) {
							if(data.success) {
                                var selected = $($('#country option:selected')[0]);
                                selected.next('option').attr('selected', 'selected');
                                selected.remove();
                                $('#country').trigger('change');
                            }
						}
				);
		});
});