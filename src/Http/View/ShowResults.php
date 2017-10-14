<?php

declare(strict_types=1);

namespace Lunch\Http\View;

use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class ShowResults implements View
{
	/**
	 * @var array
	 */
	private $results;

	public function __construct(array $results)
	{
		$this->results = $results;
	}

	public function getViewData(): array
	{
		return [
			'results' => $this->results
		];
	}

	public function getTemplate(): TemplateReference
	{
		return new FilesystemTemplateReference('results');
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [];
	}
}