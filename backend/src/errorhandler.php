<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Hole\Exception\InputException;
use Hole\Exception\ExceptionResponseDto;

$app->error(function (\Exception $oExp, $code) {

    $httpCode = 500;

    if ($oExp instanceof InputException) {
        return new JsonResponse(
            new ExceptionResponseDto(get_class($oExp), $oExp->getFieldErrors()),
            $httpCode
        );
    }

    return new JsonResponse(
        new ExceptionResponseDto(get_class($oExp), array($oExp->getMessage())),
        $httpCode
    );
});