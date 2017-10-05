<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\Http;

final class RouteNotFound extends \RuntimeException
{
	public function __construct(string $name)
	{
		parent::__construct(sprintf('Route named "%s" does not exist', $name));
	}
}