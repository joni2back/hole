(function() {
    angular.module('HoleApp').controller('HoleAppCtrl', ['$scope', '$http', function($scope, $http) {


        $scope.lat = -32.9526905;
        $scope.lng = -60.6982761;
        $scope.map = null;
        $scope.geocoder = new google.maps.Geocoder();
        $scope.defaultPos = new google.maps.LatLng($scope.lat, $scope.lng);
        $scope.mapOptions = {
            zoom: 13,
            center: $scope.defaultPos
        }
        $scope.markers = [];
        $scope.reportForm = {
            address: null,
            zone: null,
            size: null,
            detail: null
        };

        $scope.holeSizes = [
            {
                label: "Chico",
                value: 1
            },
            {
                label: "Mediano",
                value: 2
            },
            {
                label: "Grande",
                value: 3
            },
            {
                label: "Enorme",
                value: 4
            },
        ]

        $scope.init = function() {
            $scope.map = new google.maps.Map(document.getElementById('map-canvas'), $scope.mapOptions);
            $scope.mapReport = new google.maps.Map(document.getElementById('map-canvas-report'), $scope.mapOptions);
            $scope.bindEvents();
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

        $scope.addMarkerByAddress = function(address) {
            var request = {};
            request.address =  address + ", Rosario";
            $scope.geocoder.geocode(request, $scope._parseMarkerByAddress.bind($scope));
        };

        $scope.addMarker = function(location) {
            //new google.maps.LatLng(lat, lng)
            var marker = new google.maps.Marker({
                position: location,
                map: $scope.map,
                title: 'test'
            });
            $scope.markers.push(marker);
        };

        $scope.parseAjax = function() {
            var self = $scope;
            return $http.get('list.json').success(function(data) {
                data && data.length && data.forEach(function(marker) {
                    self.addMarker(marker);
                });
            });
        };

        $scope.getLocationByGeolocation = function(success, error) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    typeof success === 'function' && success(pos, position);
                }, function() {
                    typeof error === 'function' && error();
                });
            }
        };

        $scope.report = function(success, error) {
            $scope.addMarkerByInput();
            return $http.get('report').success(function(data) {
            });
        };

        google.maps.event.addDomListener(window, 'load', $scope.init);

    }]);
})();