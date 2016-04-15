/*============================
 *             HOME
 * ============================*/
// Legal popup:
// Show legal page only first time when user visit the site
jQuery(document).ready(function($) {
    if (localStorage.getItem('mjex.ageRestricted') == null || localStorage.getItem('mjex.ageRestricted') == 'no') {
        $('#legal-page').show();
    } else {
        $('#legal-page').hide();
    }

    $('#legal-page .btn').click(function() {
        if ($(this).hasClass('yes')) {
            $('#legal-page').hide();
            localStorage.setItem('mjex.ageRestricted', 'yes');

            if ($('#legal-page input:checked').length > 0) {
                window.location.href = '/login';
            }
        } else {
            window.location.href = 'about:blank';
            localStorage.setItem('mjex.ageRestricted', 'no');
        }
    });

    /////////// Map


});

var SellerMap = (function() {
    var map;
    var markers = [];

    map = new google.maps.Map(document.getElementById('sellermap'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    getStores();

    $('.map-wrapper .my-location').click(function(event) {
        showMyLocation();
    });

    //////////

    function showMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
            map.setCenter(new google.maps.LatLng(position.coords.latitude,position.coords.longitude));
        }
    }

    function addMarker(location, title, seller_id) {
        console.log(location)
        if (title == undefined) {
            title = '';
        }
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: title
        });
        markers.push(marker);
        marker.addListener('click', function() {
            window.open('/cart?seller_id=' + seller_id);
        });

        var bounds = new google.maps.LatLngBounds();
        var myLatLng = new google.maps.LatLng(location.lat, location.lng);
        bounds.extend(myLatLng);
        map.fitBounds(bounds);

        google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
            if (this.getZoom()) {
                this.setZoom(8);
            }
        });
    }

    function getStores() {
        $.ajax({
                url: '/sellermap/stores',
            })
            .done(function(stores) {
                for (var i in stores) {
                    addMarker({ lat: parseFloat(stores[i].lat), lng: parseFloat(stores[i].lng) }, stores[i].title, stores[i].seller_id);
                }
            })
            .fail(function(res) {
                console.log("error", res);
            });
    }
})();
