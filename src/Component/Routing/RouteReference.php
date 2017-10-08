<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

use Lunch\Component\Http\EndpointReference;

final class RouteReference implements EndpointReference
{
	/**
	 * @var string
	 */
	private $routeName;

	/**
	 * @var array
	 */
	private $arguments;

	public function __construct(string $routeName, array $arguments = [])
	{
		$this->routeName = $routeName;
		$this->arguments = $arguments;
	}

	public function routeName(): string
	{
		return $this->routeName;
	}

	public function arguments(): array
	{
		return $this->arguments;
	}
}