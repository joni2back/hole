<!DOCTYPE html>
<html ng-app="HoleApp">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title></title>
    <style>
      #map-canvas {
        height: 600px;
      }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="main.js"></script>
    <script src="controller.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

  </head>
  <body ng-controller="HoleAppCtrl">

  <div class="container">
      <div class="row">
          
          <div class="col-md-2">
              <input ng-model="address" ng-enter="addMarkerByInput()">
              {{ address }}
          </div>
          <div class="col-md-10">
              <div class="col-md-12" id="map-canvas"></div>
          </div>

      </div>
  </div>

  </body>
</html>

aHR0cDovL3d3dy5idWVub3NhaXJlc2JhY2hlLmNvbS8K