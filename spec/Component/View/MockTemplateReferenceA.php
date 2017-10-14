<?php

declare(strict_types=1);

namespace spec\Lunch\Component\View;

use Lunch\Component\View\TemplateReference;

final class MockTemplateReferenceA implements TemplateReference
{
	/**
	 * @var string
	 */
	private $handle;

	public function __construct(string $handle = 'A')
	{
		$this->handle = $handle;
	}

	public function handle()
	{
		return $this->handle;
	}
}