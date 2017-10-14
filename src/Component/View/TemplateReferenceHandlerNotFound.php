<?php

declare(strict_types=1);

namespace Lunch\Component\View;

final class TemplateReferenceHandlerNotFound extends \RuntimeException
{
	public function __construct(string $className)
	{
		parent::__construct(sprintf('Template reference resolver for reference of type "%s" could not be found.', $className));
	}
}