<?php

require_once __DIR__ . '/../class-loader.php';
require_once '../vendor/autoload.php';

use App\Util\Config;

/**
 * Sets up Slim app from config file
 */
$configFile = __DIR__ . '/../config/local.ini';
error_reporting(constant(Config::getKey($configFile,'app.error_reporting')));
ini_set('display_errors', Config::getKey($configFile,'app.display_errors'));
ini_set('display_startup_errors', Config::getKey($configFile,'app.display_startup_errors'));

$logFile = Config::getKey($configFile,'log.file_path') .
    Config::getKey($configFile,'log.file_prefix') .
    '-slim-' . date('Y-m-d') .
    Config::getKey($configFile,'log.file_suffix');

if(is_readable($logFile)) {
    $logger = new \Flynsarmy\SlimMonolog\Log\MonologWriter(array(
        'handlers' => array(
            new \Monolog\Handler\StreamHandler($logFile)
        )
    ));
} else {
    $logger = null;
}

$app = new \Slim\Slim(array(
    'debug' => Config::getKey($configFile,'app.debug'),
    'mode' => Config::getKey($configFile,'app.mode'),
    'log.level' => constant('\Slim\Log::' . Config::getKey($configFile,'log.level')),
    'log.writer' => $logger,
));

/**
 * Route definitions
 */
\Slim\Route::setDefaultConditions(array(
    //'id' => '^[1-9][0-9]*$'
));

// Get
$app->get('/:resource(/(:id)(/))', function($resource, $id = null, $extData = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->get($id, $extData);
    }
});

// Post
$app->post('/:resource(/)', function($resource) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->post();
    }
});

// Put
$app->put('/:resource/:id(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->put($id);
    }
});

// Delete
$app->delete('/:resource/:id(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->delete($id);
    }
});

// Options
$app->options('/:resource(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->options();
    }
});

// Patch
$app->patch('/:resource(/)', function($resource, $id = null) {
    $resource = \App\Resource::load($resource);
    if ($resource === null) {
        \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
    } else {
        $resource->patch();
    }
});

// Not found
$app->notFound(function() {
    \App\Resource::response(\App\Resource::STATUS_NOT_FOUND);
});

/**
 * Slim app start
 */
$app->run();
