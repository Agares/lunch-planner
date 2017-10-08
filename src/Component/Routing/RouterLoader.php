<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

final class RouterLoader
{
	/**
	 * @var array
	 */
	private $routes;

	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}

	public function load(): Dispatcher
	{
		return \FastRoute\simpleDispatcher(
			function (RouteCollector $collector) {
				$this->createRoutes($collector);
			}
		);
	}

	private function createRoutes(RouteCollector $collector): void
	{
		foreach ($this->routes as $route) {
			$collector->addRoute(
				$route['method'],
				$route['path'],
				$route['handler']
			);
		}
	}
}