<?php

// fixme refactor this file

header('Content-Type: text/html;charset=utf-8');

require_once __DIR__.'/../vendor/autoload.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$containerLoader = new \Lunch\Component\Kernel\ContainerLoader();

$componentLoader = new \Lunch\Component\Kernel\ComponentLoader($containerLoader);
$componentLoader->addComponent(new \Lunch\AppComponent());
$container = $componentLoader->loadServices();

$routerLoader = new \Lunch\Component\Routing\RouterLoader($container->get('routes'));
$fastRouteDispatcher = $routerLoader->load();

$dispatcher = new \Lunch\Component\Routing\Dispatcher($fastRouteDispatcher, $container);
$dispatcher->dispatch($request);