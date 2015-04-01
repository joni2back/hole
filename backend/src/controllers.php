<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Hole\Exception\InputException;
use PHPImageWorkshop\ImageWorkshop;

$app->before(function (Request $request) {
    if (! $request->files) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->match('/', function () use ($app) {
    return new JsonResponse();
})->bind('homepage');

$app->match('/list', function () use ($app) {
    $data = $app['db']->fetchAll('SELECT * FROM holes ');
    return new JsonResponse($data);
});

$app->post('/report', function (Request $request) use ($app) {

    $oExp = new InputException();

    $lat = $request->request->get('lat');
    $lng = $request->request->get('lng');
    $title = $request->request->get('title');
    $address = $request->request->get('address');
    $zone = $request->request->get('zone');
    $size = $request->request->get('size');

    !($lat || $lng) && $oExp->addFieldError('lat', 'No se pudo determinar la ubicacion en el mapa');
    !$title && $oExp->addFieldError('title');
    !$address && $oExp->addFieldError('address');
    !$zone && $oExp->addFieldError('zone');
    !$size && $oExp->addFieldError('size');

    //$oExp->throwOnError();

    $oUploadedFile = $request->files->get('file');
    $filename = '';
    if ($oUploadedFile) {
        $image = ImageWorkshop::initFromPath($oUploadedFile->getRealPath());
        $image->resizeInPixel(320, null, true);
        $filename = md5(microtime()) . '.jpg';
        $image->save(UPLOADS_DIR, $filename);
    }

    $oExp->throwOnError();

    $response = $app['db']->insert('holes', array(
        'lat' => $lat,
        'lng' => $lng,
        'title' => $title,
        'address' => $address,
        'zone' => $zone,
        'size' => $size,
        'photo' => $filename
    ));
    return new JsonResponse($response);
});

