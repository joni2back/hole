<!DOCTYPE html>
<html ng-app="HoleApp">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes" >
    <meta charset="utf-8">
    <title>HoleApp</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/styles.map.js"></script>
    <script src="assets/js/controller.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo microtime();?>">
</head>

<body ng-controller="HoleAppCtrl">

    <div class="main" id="map-canvas"></div>

    <div class="report-nav">
        <button class="btn btn-lg btn-material btn-danger" ng-click="openModalReport()">
            <i class="glyphicon glyphicon-plus"></i>
        </button>
    </div>

    <div class="title-nav">
        <img src="assets/img/logo.png" alt="" />
    </div>

    <div ng-include="'assets/templates/report-form.html'"></div>

    <div class="hide">
        <div id="info-window">
            <h4>{{ infoWindow.data.title }}</h4>
            <p>{{ infoWindow.data.content }}</p>
            <p>Direccion: {{ infoWindow.data.address }}</p>
            <p>Barrio / Zona: {{ infoWindow.data.zone }}</p>
            <p>Tamaño: {{ findHoleByValue(infoWindow.data.size).label }}</p>
            <div ng-show="infoWindow.data.photo">
                <img ng-src="{{ infoWindow.data.photo ? 'backend/web/uploads/' + infoWindow.data.photo : '' }}" alt="" />
            </div>
        </div>
        <div id="info-window-report">
            <a href="" ng-click="openModalReport()" tabindex="-1">Reportar aca ({{ contextMenuAddress }})</a>
        </div>
    </div>

</body>

</html>