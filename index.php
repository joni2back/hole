<!DOCTYPE html>
<html ng-app="HoleApp">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes" >
    <meta charset="utf-8">
    <title>Mapa de baches de Rosario</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&language=es"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/styles.map.js"></script>
    <script src="assets/js/controller.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css?v=<?php echo microtime();?>">
</head>

<body ng-controller="HoleAppCtrl">

    <div class="title-nav">
        <div class="clearfix">
            <div class="col-xs-7">
                <div class="pull-left">
                    <img src="assets/img/logo-mr.svg" alt="" class="logo" />
                </div>
                <div class="pull-left p5">
                    <button class="btn btn-info" ng-click="template=templates.map">
                        <i class="glyphicon glyphicon-map-marker"></i> <span class="hidden-xs">MAPA</span>
                    </button>
                    <button class="btn btn-info" ng-click="template=templates.list">
                        <i class="glyphicon glyphicon-th-list"></i> <span class="hidden-xs">LISTA</span>
                    </button>
                </div>
            </div>
            <div class="col-xs-5 text-right">
                <h4>Mapa de baches <span class="hidden-xs">de Rosario</span></h4>
            </div>
        </div>
    </div>

    <div ng-include="template"></div>

</body>

</html>