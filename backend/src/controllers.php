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
    $oUploadedFile = $request->files->get('uploadFileList');

    !$title && $oIExp->addFieldError('title');
    !$address && $oIExp->addFieldError('address');
    !$zone && $oIExp->addFieldError('zone');
    !$size && $oIExp->addFieldError('size');

    $filename = null;
    if ($oUploadedFile && ($lat && $lng)) {
        try {
            $image = ImageWorkshop::initFromPath($oUploadedFile->getRealPath());
            $image->resizeInPixel(320, null, true);
            $filename = md5(microtime()) . '.jpg';
            $image->save(UPLOADS_DIR, $filename);
        } catch (\Exception $oExp) {
            $errorMsg = 'Ocurrio un problema al subir la foto, intente nuevamente';
            $oIExp->addFieldError('uploadFileList', $errorMsg, null, $oExp);
        }
    }

    $oIExp->throwOnError();
    if (! ($lat || $lng)) {
        throw new \Exception(
            'La direccion indicada no pertenece al departamento de Rosario '.
            'o no se pudo determinar su ubicacion en el mapa, por favor verifique.'
        );
    }

    $response = $app['db']->insert('holes', array(
        'lat' => $lat,
        'lng' => $lng,
        'title' => $title,
        'content' => '',
        'address' => $address,
        'zone' => $zone,
        'size' => $size,
        'photo' => $filename,
        'public' => true,
        'ip' => $request->getClientIp()
    ));
    return new JsonResponse($response);
});

