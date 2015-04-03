<!DOCTYPE html>
<html ng-app="HoleApp">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title></title>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/controller.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css?v=1">

  </head>
  <body ng-controller="HoleAppCtrl">

  <div class="main" id="map-canvas"></div>
  <div class="report-nav">
      <button class="btn btn-material" ng-click="openModalReport()">
        <i class="glyphicon glyphicon-plus"></i>
      </button>
  </div>
  <div class="title-nav">
    <h2>mapa de rosario <i class="glyphicon glyphicon-chevron-up"></i></h2>
  </div>

  <div ng-include="'assets/templates/report-form.html'"></div>
  <div class="hide">
      <div id="info-window">
        <h4>{{ infoWindow.data.title }}</h4>
        <p>{{ infoWindow.data.content }}</p>
        <p>{{ infoWindow.data.address }} ({{ infoWindow.data.zone }})</p>
        <p>Tamaño: {{ findHoleByValue(infoWindow.data.size).label }}</p>
        <div ng-show="infoWindow.data.photo">
            <img ng-src="{{ infoWindow.data.photo ? 'backend/web/uploads/' + infoWindow.data.photo : '' }}" alt=""/>
        </div>
      </div>
  </div>

  </body>
</html>