jQuery(document).ready(function($) {
    (function() {
        function initSearchMap(lat, lng) {
            var defaultLocation;
            if (lat && lng) {
                // lat lng have real value
                defaultLocation = { lat: lat, lng: lng }
            } else {
                defaultLocation = { lat: 36.228300, lng: -119.494996 };
            }
            var $latInput = $('[name=lat]');
            var $lngInput = $('[name=lng]');
            if ($latInput.val()) { defaultLocation.lat = $latInput.val(); }
            if ($lngInput.val()) { defaultLocation.lng = $lngInput.val(); }
            var map = new GMaps({
                el: '#map',
                lat: defaultLocation.lat,
                lng: defaultLocation.lng,
                zoom: 5
            });
            var marker = map.addMarker({
                lat: defaultLocation.lat,
                lng: defaultLocation.lng,
                draggable: true,
                dragend: function() {
                    var lat = this.getPosition().lat(),
                        lng = this.getPosition().lng();
                    $latInput.val(lat);
                    $lngInput.val(lng);
                }
            });
        }

        $('#chooseLocationModal').on('shown.bs.modal', function(e) {
            // check for Geolocation support
            if (navigator.geolocation) {
                console.log('Geolocation is supported!');
                var startPos;
                var geoSuccess = function(position) {
                    startPos = position;
                    console.log(startPos.coords.latitude, startPos.coords.longitude);
                    initSearchMap(startPos.coords.latitude, startPos.coords.longitude);
                };
                navigator.geolocation.getCurrentPosition(geoSuccess);
            } else {
                console.log('Geolocation is not supported for this Browser/OS version yet.');
                initSearchMap();
            }
        })
    })();
});
