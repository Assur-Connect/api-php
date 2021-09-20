<?php

try {
    require '../initialization.php';

    $api->setLanguage('fr');

    $descriptionResponseResource = $api->besafeDescription->call();

    var_dump($descriptionResponseResource);
} catch (\AssurConnect\Api\Exceptions\ApiException $e) {
    echo htmlspecialchars($e->getMessage()) . PHP_EOL;
}
