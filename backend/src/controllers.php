<?php
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


$app->match('/', function () use ($app) {
    return new Response('hola');
})->bind('homepage');

$app->match('/list', function () use ($app) {
    $data = $app['db']->fetchAll('SELECT * FROM holes WHERE public > 0');

    return new Response(json_encode($data));
})->bind('doctrine');