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

  <div class="container">
      <h2>angular-stackoverflow</h2>
      <hr />
      <div class="well">
        <div class="row">
            
            <div class="col-md-2">
                <div ng-include="'assets/templates/report-form.html'"></div>
            </div>
            <div class="col-md-10">
                <div class="col-md-12" id="map-canvas"></div>
            </div>

        </div>
      </div>
  </div>

  </body>
</html>