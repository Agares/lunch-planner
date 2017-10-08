<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\SapiEmitter;

final class Dispatcher
{
	/**
	 * @var \FastRoute\Dispatcher
	 */
	private $fastRouteDispatcher;

	/**
	 * @var ContainerInterface
	 */
	private $container;

	public function __construct(\FastRoute\Dispatcher $fastRouteDispatcher, ContainerInterface $container)
	{
		$this->fastRouteDispatcher = $fastRouteDispatcher;
		$this->container = $container;
	}

	public function dispatch(ServerRequestInterface $request): void
	{
		[$status, $handlerClass, $arguments] = $this->fastRouteDispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

		switch ($status) {
			case \FastRoute\Dispatcher::NOT_FOUND:
				$this->handleNotFound();
				break;
			case \FastRoute\Dispatcher::FOUND:
				$this->executeHandler($request, $handlerClass, $arguments);

				break;
			case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
				$this->handleMethodNotAllowed();
				break;
		}
	}

	private function handleNotFound(): void
	{
		http_response_code(404);
		echo 'Not found';
	}

	private function executeHandler(ServerRequestInterface $request, string $handlerClass, array $arguments): void
	{
		$handler = $this->container->get($handlerClass);

		// fixme REFACTOR THIS
		if (count($arguments) !== 0) {
			$handlerReflection = new \ReflectionClass($handler);
			$handleMethodReflection = $handlerReflection->getMethod('handle');

			$handleParameters = [];
			$handleParameterReflections = $handleMethodReflection->getParameters();
			foreach ($handleParameterReflections as $parameterReflection) {
				if (((string)$parameterReflection->getType()) === ServerRequestInterface::class) {
					$handleParameters[] = $request;
				} else {
					$handleParameters[] = $arguments[$parameterReflection->getName()];
				}
			}

			$response = $handleMethodReflection->invokeArgs($handler, $handleParameters);
		} else {
			$response = $handler->handle($request);
		}

		if (!($response instanceof ResponseInterface)) {
			throw new \RuntimeException(
				sprintf(
					'Response must be a PSR-7 response (was "%s")',
					is_object($response) ? get_class($response) : gettype($response)
				)
			);
		}

		$responseEmitter = new SapiEmitter();
		$responseEmitter->emit($response);
	}

	private function handleMethodNotAllowed(): void
	{
		http_response_code(401);
		echo 'Method not allowed';
	}
}