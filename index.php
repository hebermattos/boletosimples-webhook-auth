<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->post('/webhook-auth', function () use ($app) {

    $authData = $app->request->getJsonRawBody();

    if (IsNullOrEmptyString($authData->Body)) {
        throw new Exception('Body not informed');
    }

    if (IsNullOrEmptyString($authData->Secret)) {
        throw new Exception('Secret not informed');
    }

    return hash_hmac('sha1', $authData->Body, $authData->Secret);
});

$app->get('/healthcheck', function () {
    echo 'ok';
});

$app->get('/', function () {
    echo 'webhook-auth';
});

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
});

$app->handle();

function IsNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}

?>