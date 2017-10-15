<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

final class RouteNotFound extends \RuntimeException
{
	public function __construct(string $name)
	{
		parent::__construct(sprintf('Route named "%s" does not exist', $name));
	}
}