<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\Http;

use FastRoute\RouteParser\Std;
use Lunch\Infrastructure\Http\RouteNotFound;

final class UrlGenerator
{
	/**
	 * @var array
	 */
	private $routes;

	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}

	// todo support named parameters
	public function generate(string $routeName, array $params = array()): string
	{
		// this code is adapted from https://github.com/nikic/FastRoute/issues/66

		if(!isset($this->routes[$routeName])) {
			throw new RouteNotFound($routeName);
		}

		// fixme inject the parser
		$routeParser = new Std();
		/** @var array[] $routeFragments */
		$routeFragments = $routeParser->parse($this->routes[$routeName]['path']);

		// One route pattern can correspond to multiple routes if it has optional parts
		foreach ($routeFragments as $route) {
			$url = '';
			$paramIdx = 0;
			foreach ($route as $part) {
				// Fixed segment in the route
				if (is_string($part)) {
					$url .= $part;
					continue;
				}

				// Placeholder in the route
				if ($paramIdx === count($params)) {
					throw new \LogicException('Not enough parameters given');
				}
				$url .= $params[$paramIdx++];
			}

			// If number of params in route matches with number of params given, use that route.
			// Otherwise try to find a route that has more params
			if ($paramIdx === count($params)) {
				return $url;
			}
		}

		throw new \LogicException('Too many parameters given');
	}
}