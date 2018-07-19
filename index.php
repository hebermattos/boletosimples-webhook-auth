<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->post('/webhook-auth', function () use ($app) {

    $authData = $app->request->getJsonRawBody();

    return hash_hmac('sha1', $authData->Body, $authData->Secret);
});

$app->get('/healthcheck', function () {
    echo 'ok';
});

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
});

$app->handle();