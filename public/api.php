<?php

define('APP_NAME', 'api');

require_once __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'base.php';

$app->config([
    'name'      => APP_NAME,
    'namespace' => APP_NAME,
])->run();
