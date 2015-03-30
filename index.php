<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>

    var App = function() {
        var self = this;

        this.lat = -32.9526905;
        this.lng = -60.6982761;
        this.map = null;
        this.geocoder = new google.maps.Geocoder();
        this.defaultPos = new google.maps.LatLng(this.lat, this.lng);

        this.mapOptions = {
            zoom: 12,
            center: this.defaultPos
        }

        this.init = function() {
            this.map = new google.maps.Map(document.getElementById('map-canvas'), this.mapOptions);
            console.info('initin', this);
        };

        this.markers = [];

        this.addAddressToMap = function(response, status) {
            if (! response) {
                return;
            }
            var marker = new google.maps.Marker({
                position: response[0].geometry.location,
                map: this.map,
                title: 'hola'
            });
            //marker.setMap(this.map);
        };

        this.add = function(address) {
            var request = {};
            request.address =  address + ", Rosario";
            this.geocoder.geocode(request, this.addAddressToMap.bind(this));
        };
         
    };

    var app = new App();

    google.maps.event.addDomListener(window, 'load', app.init.bind(app));

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>
