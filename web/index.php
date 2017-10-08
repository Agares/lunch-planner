<?php

// fixme refactor this file

header('Content-Type: text/html;charset=utf-8');

require_once __DIR__.'/../vendor/autoload.php';

$services = require __DIR__.'/../config/services.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$containerLoader = new \Lunch\Infrastructure\DI\ContainerLoader();
$container = $containerLoader->load($services);

$routerLoader = new \Lunch\Component\Routing\RouterLoader($container->get('routes'));
$fastRouteDispatcher = $routerLoader->load();

$dispatcher = new \Lunch\Component\Routing\Dispatcher($fastRouteDispatcher, $container);
$dispatcher->dispatch($request);