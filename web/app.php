<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

umask(0000);

define('DEV_SERVER', 'server5.cunningsoft.de');

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

if (php_uname('n') != DEV_SERVER) {
    $loader = new ApcClassLoader('familytree', $loader);
    $loader->register(true);
}

require_once __DIR__.'/../app/AppKernel.php';
if (php_uname('n') != DEV_SERVER) {
    require_once __DIR__.'/../app/AppCache.php';
}

if (php_uname('n') != DEV_SERVER) {
    $kernel = new AppKernel('prod', false);
} else {
    $kernel = new AppKernel('dev', true);
}
$kernel->loadClassCache();

if (php_uname('n') != DEV_SERVER) {
    $kernel = new AppCache($kernel);
}
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
