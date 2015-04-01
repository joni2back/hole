<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Hole\\', __DIR__ . '/../src/');

$app = new Silex\Application();

require_once __DIR__.'/../resources/config/prod.php';
require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/errorhandler.php';
require_once __DIR__.'/../src/controllers.php';

$app->run();
