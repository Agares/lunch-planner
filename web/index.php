<?php

// fixme refactor this file

header('Content-Type: text/html;charset=utf-8');

require_once __DIR__.'/../vendor/autoload.php';

$routes = require __DIR__.'/../config/routes.php';
$services = require __DIR__.'/../config/services.php';

$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);

$serviceDefinitions = [
	'routes' => $routes
];

foreach($services as $serviceName => $serviceConfiguration) {
	if(isset($serviceConfiguration['create'])) {
		$definition = \DI\factory($serviceConfiguration['create']);
	} else {
		$definition = \DI\object($serviceConfiguration['className'] ?? $serviceName);
	}

	if(isset($serviceConfiguration['parameters'])) {
		$constructorParameters = array_map('\DI\get', $serviceConfiguration['parameters']);
		$definition->constructor(...$constructorParameters);
	}

	if(isset($serviceConfiguration['methodCalls'])) {
		foreach($serviceConfiguration['methodCalls'] as $methodCall) {
			$definition->method($methodCall[0], ...array_map('\DI\get', $methodCall[1] ?? []));
		}
	}

	$serviceDefinitions[$serviceName] = $definition;
}

$containerBuilder->addDefinitions($serviceDefinitions);
$container = $containerBuilder->build();

$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $collector) use($container) {
	$routes = $container->get('routes');

	foreach($routes as $route) {
		$collector->addRoute(
			$route['method'],
			$route['path'],
			function (\Psr\Http\Message\RequestInterface $request, array $arguments = [])
			use ($container, $route) {
				$handler = $container->get($route['handler']);

				// fixme REALLY REFACTOR THIS
				if(count($arguments) !== 0) {
					$handlerReflection = new ReflectionClass($handler);
					$handleMethodReflection = $handlerReflection->getMethod('handle');

					$handleParameters = [];
					$handleParameterReflections = $handleMethodReflection->getParameters();
					foreach ($handleParameterReflections as $parameterReflection) {
						if(((string)$parameterReflection->getType()) === \Psr\Http\Message\RequestInterface::class) {
							$handleParameters[] = $request;
						} else {
							$handleParameters[] = $arguments[$parameterReflection->getName()];
						}
					}

					return $handleMethodReflection->invokeArgs($handler, $handleParameters);
				}

				return $handler->handle($request);
			}
		);
	}
});

$r = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($r[0]) {
	case \FastRoute\Dispatcher::NOT_FOUND:
		http_response_code(404);
		echo 'Not found';
		break;
	case \FastRoute\Dispatcher::FOUND:
		$response = $r[1]($request, $r[2]);

		if(!($response instanceof \Psr\Http\Message\ResponseInterface)) {
			throw new \RuntimeException(
				sprintf(
					'Response must be a PSR-7 response (was "%s")',
					is_object($response) ? get_class($response) : gettype($response)
				)
			);
		}

		$responseEmitter = new \Zend\Diactoros\Response\SapiEmitter();
		$responseEmitter->emit($response);

		break;
	case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		http_response_code(401);
		echo 'Method not allowed';
		break;
}