<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

final class ResolverNotFound extends \RuntimeException
{
	public function __construct(string $referenceClassName)
	{
		parent::__construct(sprintf('No resolver found for reference of type "%s"', $referenceClassName));
	}
}