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
    <link rel="stylesheet" href="assets/css/main.css">

  </head>
  <body ng-controller="HoleAppCtrl">

  <div class="main" id="map-canvas"></div>
  <div class="report-nav">
      <button class="btn btn-lg btn-danger" ng-click="openModalReport()">Reportar</button>
  </div>
  <div class="title-nav">
    <h2>test</h2>
  </div>

  <div ng-include="'assets/templates/report-form.html'"></div>
  <div class="hide">
      <div id="info-window">
        <h4>{{ infoWindow.data.title }}</h4>
        <p>{{ infoWindow.data.content }}</p>
        <img ng-show="infoWindow.data.photo" ng-src="{{ 'backend/web/uploads/' + infoWindow.data.photo }}" alt=""/>
      </div>
  </div>

  </body>
</html>