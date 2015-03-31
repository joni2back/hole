(function() {
    angular.module('HoleApp').controller('HoleAppCtrl', ['$scope', '$http', function($scope, $http) {

        $scope.lat = -32.9526905;
        $scope.lng = -60.6982761;
        $scope.map = null;
        $scope.geocoder = new google.maps.Geocoder();
        $scope.defaultPos = new google.maps.LatLng($scope.lat, $scope.lng);
        $scope.mapOptions = {
            zoom: 13,
            center: $scope.defaultPos,
            mapTypeId: google.maps.MapTypeId.TERRAIN,
            streetViewControl: false
        }
        $scope.markers = [];
        $scope.reportForm = {
            address: null,
            zone: null,
            size: null,
            detail: null,
            lat: null,
            lng: null
        };

        $scope.holeSizes = [
            {label: "Chico", value: 1},
            {label: "Mediano", value: 2},
            {label: "Grande", value: 3},
            {label: "Enorme", value: 4}
        ];

        $scope.infoWindow = {
            object: null,
            data: null
        }

        $scope.init = function() {
            $scope.map = new google.maps.Map(document.getElementById('map-canvas'), $scope.mapOptions);
            $scope.bindEvents();
            $scope.parseAjax().success(function() {

            });

            $scope.infoWindow.object = new google.maps.InfoWindow({
                content: document.getElementById('info-window')
            });

        };

        $scope.bindEvents = function() {
            google.maps.event.addListener($scope.map, "rightclick", function(event) {
                var lat = event.latLng.lat();
                var lng = event.latLng.lng();
            });
        };

        $scope._parseMarkerByAddress = function(response, status) {
            try {
                response[0].geometry.location && $scope.addMarker(response[0].geometry.location);
            } catch(error) {
            }
        };

        $scope.addMarkerByInput = function() {
            $scope.reportForm.address && $scope.addMarkerByAddress($scope.reportForm.address);
            $scope.reportForm.address = '';
        };

        $scope.addMarkerByAddress = function(addressString) {
            var data = {address: addressString + ", Rosario"};
            $scope.geocoder.geocode(data, $scope._parseMarkerByAddress.bind($scope));
        };

        $scope.addMarker = function(pos, data) {
            var marker = new google.maps.Marker({
                position: pos,
                map: $scope.map,
                data: data
            });
  
            google.maps.event.addListener(marker, 'click', function() {
                $scope.infoWindow.data = data;
                $scope.$apply();
                $scope.infoWindow.object.open($scope.map, marker);
            }); 

            $scope.markers.push(marker);
        };

        $scope.parseAjax = function() {
            var self = $scope;
            return $http.get('backend/web/list').success(function(data) {
                data && data.length && data.forEach(function(marker) {
                    marker.lat = parseFloat(marker.lat);
                    marker.lng = parseFloat(marker.lng);
                    self.addMarker(marker, marker);
                });
            });
        };

        $scope.getPosByGeolocation = function(success, error) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    typeof success === 'function' && success(pos, position);
                }, function() {
                    typeof error === 'function' && error();
                });
            }
        };

        $scope.getAddressByGeolocation = function(success, error) {
            $scope.getPosByGeolocation(function(pos) {
                $scope.getAddressByPos(pos, success, error);
            });
        };

        $scope.getAddressByPos = function(pos, success, error) {
            $scope.geocoder.geocode({'latLng': pos}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        typeof success === 'function' && success(results[0].formatted_address, results, pos);
                    } else {
                        typeof error === 'function' && error();
                    }
                } else {
                    typeof error === 'function' && error();
                }
            });
        };

        $scope.touchUseMyActualGeo = function() {
            $scope.reportForm.address = 'Obteniendo....';
            $scope.getAddressByGeolocation(function(addressString, results, pos) {
                $scope.reportForm.address = addressString.split(',')[0];
                $scope.reportForm.lat = pos.k;
                $scope.reportForm.lng = pos.D;
                $scope.$apply();
            });
        };

        $scope.report = function(success, error) {
            return $http.post('api/report', $scope.reportForm).success(function(data) {
                $scope.closeModalReport();
            });
        };

        $scope.reportGeo = function() {
            $scope.getPosByGeolocation(function(pos) {
                console.info(pos);
                $scope.addMarker(pos);
            });
        };        

        $scope.openModalReport = function() {
            $('#report').modal('show');
        };

        $scope.closeModalReport = function() {
            $('#report').modal('hide');
        };

        google.maps.event.addDomListener(window, 'load', $scope.init);

    }]);
})();