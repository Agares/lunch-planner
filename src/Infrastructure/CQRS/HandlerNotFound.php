<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\CQRS;

final class HandlerNotFound extends \RuntimeException
{
	public function __construct(string $className)
	{
		parent::__construct(sprintf('Handler for command of type "%s" not found', $className));
	}
}