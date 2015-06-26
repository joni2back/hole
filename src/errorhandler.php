<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Hole\Exception\InputException;
use Hole\Exception\ExceptionResponseDto;
use Symfony\Component\Debug\ExceptionHandler;

class AnyHandler {
    public static function getRequestFromException(\Exception $oExp) {
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
    }
}

class FatalHandler extends ExceptionHandler {
    public function handle(\Exception $oExp) {
        $response = AnyHandler::getRequestFromException($oExp);
        $response->send();
        exit;
    }
}

$app->error(function (\Exception $oExp) {
    return AnyHandler::getRequestFromException($oExp);
});
FatalHandler::register(false);