<!DOCTYPE html>
<html ng-app="HoleApp">
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title></title>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/controller.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css?v=1">

  </head>
  <body ng-controller="HoleAppCtrl">

  <div class="main" id="map-canvas"></div>
  <div class="report-nav">
      <button class="btn btn-lg btn-material" ng-click="openModalReport()">
        <i class="glyphicon glyphicon-plus"></i>
      </button>
  </div>
  <div class="title-nav">
    <img sxrc="http://www.monumentoalabandera.gob.ar/images/logo_muni2012.png" alt=""/>
  </div>

  <div ng-include="'assets/templates/report-form.html'"></div>
  <div ng-include="'assets/templates/infowindow.html'"></div>
  <div ng-include="'assets/templates/infowindow-report.html'"></div>

  </body>
</html>