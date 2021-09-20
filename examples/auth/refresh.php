<?php

try {
    require '../initialization.php';

    $clientRefreshRequestResource = new \AssurConnect\Api\Resources\Request\Auth\ClientRefreshResource($clientRequestResource, $token);

    $refreshedTokenResource = $api->authRefresh->call($clientRefreshRequestResource);
    $api->setToken($refreshedTokenResource);

    var_dump($refreshedTokenResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}
