<?php

declare(strict_types=1);

namespace Lunch\Component\Kernel;

final class ServiceAlreadyDefined extends \RuntimeException
{
	public function __construct(string $serviceName)
	{
		parent::__construct(sprintf('Service "%s" has been defined before', $serviceName));
	}
}