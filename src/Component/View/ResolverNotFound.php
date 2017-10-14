<?php

declare(strict_types=1);

namespace Lunch\Component\View;

final class ResolverNotFound extends \RuntimeException
{
	public function __construct(string $className)
	{
		parent::__construct(sprintf('No resolver found for reference of type "%s"', $className));
	}
}