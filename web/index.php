<?php

$loader = require_once __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Hole\\', __DIR__ . '/../src/');
$loader->add('PHPImageWorkshop\\', __DIR__ . '/../vendor/sybio-image-workshop/src/');

$app = new Silex\Application();

define('DS', DIRECTORY_SEPARATOR);
define('WEB_DIR', __DIR__);
define('UPLOADS_DIR', WEB_DIR . DS . 'uploads');

require_once __DIR__.'/../resources/config/prod.php';
require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/errorhandler.php';
require_once __DIR__.'/../src/controllers.php';

$app->run();
