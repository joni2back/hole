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

    $oIExp = new InputException();

    $lat = $request->request->get('lat');
    $lng = $request->request->get('lng');
    $title = $request->request->get('title');
    $address = $request->request->get('address');
    $zone = $request->request->get('zone');
    $size = $request->request->get('size');

    !($lat || $lng) && $oIExp->addFieldError('lat', 'No se pudo determinar la ubicacion en el mapa');
    !$title && $oIExp->addFieldError('title');
    !$address && $oIExp->addFieldError('address');
    !$zone && $oIExp->addFieldError('zone');
    !$size && $oIExp->addFieldError('size');
    $oIExp->throwOnError();
    $oUploadedFile = $request->files->get('file');
    $filename = null;
    if ($oUploadedFile) {
        try {
            $image = ImageWorkshop::initFromPath($oUploadedFile->getRealPath());
            $image->resizeInPixel(320, null, true);
            $filename = md5(microtime()) . '.jpg';
            $image->save(UPLOADS_DIR, $filename);
        } catch (\Exception $oExp) {
            $oIExp->addFieldError('size');
        }
    }

    $oIExp->throwOnError();

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

