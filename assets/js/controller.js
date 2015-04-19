(function() {
    angular.module('HoleApp').controller('HoleAppCtrl', ['$scope', '$http', '$mapStyles', function($scope, $http, $mapStyles) {
        $scope.lat = -32.9526905;
        $scope.lng = -60.6982761;
        $scope.map = null;
        $scope.geocoder = new google.maps.Geocoder();
        $scope.defaultPos = new google.maps.LatLng($scope.lat, $scope.lng);
        $scope.requesting = false;
        $scope.reportStatus = 'main';
        $scope.markers = [];
        $scope.mapOptions = {
            zoom: 14,
            maxZoom: 19,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: $scope.defaultPos,
            draggableCursor: 'crosshair',
            styles: $mapStyles,
            streetViewControl: false,
            mapTypeControl: false,
            zoomControl: false,
            disableDefaultUI: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.TOP_RIGHT
            }
        };
        $scope.templates = {
            list: 'assets/templates/list.html',
            map: 'assets/templates/map.html'
        };
        $scope.template = $scope.templates.map;
        $scope.reportForm = {
            address: '',
            zone: '',
            size: '',
            title: '',
            content: '',
            lat: '',
            lng: '',
            uploadFileList: []
        };
        $scope.holeSizes = [
            {label: "Chico", value: 1},
            {label: "Mediano", value: 2},
            {label: "Grande", value: 3},
            {label: "Enorme", value: 4}
        ];

        $scope.fresh = true;

        $scope.findHoleByValue = function(id) {
            var result;
            angular.forEach($scope.holeSizes, function(obj) {
                if (obj.value == id) {
                    result = obj;
                }
            });
            return result;
        };

        $scope.infoWindowReport = {};
        $scope.infoWindow = {
            object: null,
            data: null
        };

        $scope.initMaps = function(appendMarkers) {
            var mapCanvas = document.getElementById('map-canvas');

            if (mapCanvas) {
                $scope.map = new google.maps.Map(
                    mapCanvas, $scope.mapOptions
                );

                appendMarkers && $scope.appendMarkersToMap();

                $scope.infoWindow.object = new google.maps.InfoWindow({
                    content: document.getElementById('info-window')
                });

                $scope.infoWindowReport = new google.maps.InfoWindow({
                    content: document.getElementById("info-window-report")
                });
                $scope.bindEvents();
                $scope.fresh = false;
            }
        };

        $scope.init = function() {
            $scope.template === $scope.templates.map && $scope.fresh && $scope.initMaps();
            $scope.getServerMarkers().success(function() {
                $scope.appendMarkersToMap();
            });
        };

        $scope.bindEvents = function() {
            google.maps.event.addListener($scope.map, "click", function(event) {
                var pos = event.latLng;

                $scope.infoWindowReport.setPosition(pos);
                $scope.infoWindowReport.open($scope.map);
                $scope.infoWindow.object.close();

                $scope.contextMenuAddress = '...';
                $scope.getAddressByPos(pos, function(addressString, results) {
                    $scope.reportForm.address = addressString.split(',')[0];
                    $scope.contextMenuAddress = addressString.split(',')[0];
                    $scope.parseValuesByMapsResult(results, pos);
                    $scope.$apply();
                });
                $scope.$apply();
            });
        };


        //$scope.addMarkerByInput = function() {
        //    $scope.reportForm.address && $scope.addMarkerByAddress($scope.reportForm.address);
        //    $scope.reportForm.address = '';
        //};
        //
        //$scope.addMarkerByAddress = function(addressString) {
        //    var data = {address: addressString + ", Rosario"};
        //    var internalCallback = function(response, status) {
        //        try {
        //            response[0].geometry.location && $scope.addMarker(response[0].geometry.location);
        //        } catch(e) {
        //        }
        //    };
        //    $scope.geocoder.geocode(data, internalCallback);
        //};

        $scope.getPosByAddress = function(addressString, success, error) {
            var data = {address: addressString + ", Rosario"};
            var internalCallback = function(response, status) {
                try {
                    var pos = response[0].geometry.location;
                    pos && success(response, pos);
                    return;
                } catch(e) {}
                typeof error === 'function' && error();
            };
            $scope.geocoder.geocode(data, internalCallback);
        };

        //$scope.addMarker = function(pos, data) {
        //    var marker = new google.maps.Marker({
        //        position: pos,
        //        map: $scope.map,
        //        data: data,
        //        icon: 'assets/img/pin.svg'
        //    });
        //
        //    google.maps.event.addListener(marker, 'click', function() {
        //        $scope.infoWindow.data = data;
        //        $scope.$apply();
        //        $scope.infoWindow.object.open($scope.map, marker);
        //        $scope.infoWindowReport.close();
        //    });
        //
        //    $scope.markers.push(marker);
        //};

        //$scope.parseAjax = function() {
        //    $scope.requesting = true;
        //    return $http.get('backend/web/list').success(function(response) {
        //        response && response.length && response.forEach(function(marker) {
        //            marker.lat = parseFloat(marker.lat);
        //            marker.lng = parseFloat(marker.lng);
        //            $scope.map && $scope.addMarker(marker, marker);
        //        });
        //        $scope.requesting = false;
        //    });
        //};

        $scope.addMarkerIntoMap = function(pos, data) {
            var marker = new google.maps.Marker({
                position: pos,
                map: $scope.map,
                data: data,
                icon: 'assets/img/pin.svg'
            });

            google.maps.event.addListener(marker, 'click', function() {
                $scope.infoWindow.data = data;
                $scope.$apply();
                $scope.infoWindow.object.open($scope.map, marker);
                $scope.infoWindowReport.close();
            });

            return marker;
        };

        $scope.appendMarkersToMap = function() {
            angular.forEach($scope.markers, function(marker) {
                $scope.addMarkerIntoMap(marker, marker);
            });
        };

        $scope.getServerMarkers = function() {
            $scope.requesting = true;
            $scope.markers = [];
            return $http.get('backend/web/list').success(function(response) {
                response && response.length && angular.forEach(response, function(marker) {
                    marker.lat = parseFloat(marker.lat);
                    marker.lng = parseFloat(marker.lng);
                    $scope.markers.push(marker);
                });
                $scope.requesting = false;
            });
        };

        $scope.getPosByGeolocation = function(success, error) {
            if (window.navigator.geolocation) {
                window.navigator.geolocation.getCurrentPosition(function(position) {
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

        $scope.isPosFromRosario = function(pos) {
            return (pos.k+"").match('^\-(32|33)') && (pos.D+"").match('^\-(60)');
        };

        $scope.parseValuesByMapsResult = function(results, pos) {
            $scope.reportForm.visibleAddress = results[0].formatted_address.split(',')[0];
            $scope.reportForm.zone = results[0].address_components[2].long_name;
            if ($scope.isPosFromRosario(pos)) {
                $scope.reportForm.lat = pos.k;
                $scope.reportForm.lng = pos.D;
            } else {
                $scope.reportForm.lat = '';
                $scope.reportForm.lng = '';
            }
            $scope.$apply();
        };

        $scope.touchBindAddressInput = function() {
            $scope.getPosByAddress($scope.reportForm.address, function(results, pos) {
                $scope.parseValuesByMapsResult(results, pos);
            }, function(e) {
            });
        };

        $scope.touchUseMyActualGeo = function() {
            $scope.reportForm.address = 'Obteniendo....';
            $scope.reportStatus = 'requesting';
            $scope.getAddressByGeolocation(function(addressString, results, pos) {
                $scope.reportForm.address = addressString.split(',')[0];
                $scope.parseValuesByMapsResult(results, pos);
                $scope.reportStatus = 'main';
                $scope.$apply();
            });
        };

        $scope.showInputExceptionError = function(reponse) {
            if (reponse && reponse.type && reponse.type.match('InputException$')) {
                $('input, select').removeClass('validation-error');
                angular.forEach(reponse.errors, function(field) {
                    var $el = $('input, select').filter('[ng-file$="' +field.fieldName+ '"], [ng-model$="' +field.fieldName+ '"]');
                    $el.parents('.form-group').find('.input-error').html(field.message);
                    $el.addClass('validation-error');
                });
            } else if (reponse && reponse.type && reponse.type.match('Exception')) {
                window.alert(reponse.errors[0]);
            }
        };

        $scope.removeReport = function(id) {
            $scope.requesting = true;
            var theData = {
                id: id
            };

            return $http.post('backend/web/delete', theData).success(function(response) {
                $scope.requesting = false;
            });
        };

        $scope.onReportSuccess = function(response) {
            response && $scope.init();
            $scope.infoWindowReport.close();
            $scope.infoWindow.object.close();
            $scope.reportForm = {};
        };

        $scope.report = function() {
            $('.input-error').html('');
            var form = new FormData();

            angular.forEach($scope.reportForm, function(value, key) {
                form.append(key, value);
            });

            angular.forEach($scope.reportForm.uploadFileList, function(value) {
                form.append('uploadFileList', value);
            });

            $scope.requesting = true;
            $scope.reportStatus = 'requesting';
            return $http.post('backend/web/report', form, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            }).success(function(response) {
                $scope.requesting = false;
                if (response && response.success) {
                    $scope.reportStatus = 'done';
                    $scope.onReportSuccess(response);
                } else {
                    $scope.reportStatus = 'fail';
                }
            }).error(function(response) {
                $scope.showInputExceptionError(response);
                $scope.reportStatus = 'fail';
                $scope.requesting = false;
            });
        };

        //$scope.reportGeo = function() {
        //    $scope.getPosByGeolocation(function(pos) {
        //        $scope.addMarker(pos);
        //    });
        //};

        $scope.openModalReport = function(resetValues) {
            $scope.reportStatus = 'main';
            $('#report').modal('show');
            if (resetValues) {
                $scope.reportForm.size = $scope.holeSizes[0].value;
                $scope.infoWindowReport.close();
                $scope.infoWindow.object.close();
            }
        };

        $scope.closeModalReport = function() {
            $('#report').modal('hide');
        };

        google.maps.event.addDomListener(window, 'load', $scope.init);
        scope = $scope;//only for dev
    }]);
})();