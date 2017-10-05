<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\CQRS;

final class QueryHandlerNotFound extends \RuntimeException
{
	public function __construct(string $className)
	{
		parent::__construct(sprintf('Handler for query of type "%s" not found', $className));
	}
}