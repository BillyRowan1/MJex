var SellerMap = (function() {
    var map;
    var markers = [];

    map = new google.maps.Map(document.getElementById('sellermap'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 12
    });
    getStores();

    var geocoder = new google.maps.Geocoder();

    try {
        if (undefined != currentUserAddress) {
            geocodeAddress(currentUserAddress, function (pos) {
                if(pos) map.setCenter(pos);
            });
        }
    } catch (e) {
        console.log(e, 'User is not login to grab location');

        // check for Geolocation support
        if (navigator.geolocation) {
            console.log('Geolocation is supported!');
            var startPos;
            var geoSuccess = function(position) {
                startPos = position;
                map.setCenter(new google.maps.LatLng(startPos.coords.latitude,startPos.coords.longitude));
            };
            navigator.geolocation.getCurrentPosition(geoSuccess);
        } else {
            console.log('Geolocation is not supported for this Browser/OS version yet.');
        }
    }

    function geocodeAddress(address, callback) {
        if (address == undefined) address = 'US';

        geocoder.geocode({ 'address': address }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                callback(results[0].geometry.location);
            } else {
                console.log('Geocode was not successful for the following reason: ' + status);
                callback(false);
            }
        });
    }

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


    //////////

    function showMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        function showPosition(position) {
            map.setCenter(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
        }
    }

    function addMarker(location, title, seller_id, icon) {
        if (title == undefined) {
            title = '';
        }

        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title: title,
            icon: icon
        });
        markers.push(marker);
        marker.addListener('click', function() {
            window.open('/cart?seller_id=' + seller_id);
        });

        // var bounds = new google.maps.LatLngBounds();
        // var myLatLng = new google.maps.LatLng(location.lat, location.lng);
        // bounds.extend(myLatLng);
        // map.fitBounds(bounds);

        // google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
        //     if (this.getZoom()) {
        //         this.setZoom(12);
        //     }
        // });
    }

    function getStores() {
        $.ajax({
                url: '/sellermap/stores',
            })
            .done(function(stores) {
                for (var i in stores) {
                    if(stores[i].lat) {
                        addMarker({ lat: parseFloat(stores[i].lat), lng: parseFloat(stores[i].lng) }, stores[i].title, stores[i].seller_id, stores[i].icon);
                    }else{
                        geocodeAddress(stores[i].address, function (pos) {
                            if(pos) {
                                addMarker({ lat: pos.lat(), lng: pos.lng() }, stores[i].title, stores[i].seller_id, stores[i].icon);
                            }
                        });
                    }
                }
            })
            .fail(function(res) {
                console.log("error", res);
            });
    }
})();
