<?php

declare(strict_types=1);

namespace Lunch\Http\View;

use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class Layout implements View
{
	/**
	 * @var View
	 */
	private $contentView;

	public function __construct(View $contentView)
	{
		$this->contentView = $contentView;
	}

	public function getViewData(): array
	{
		return [];
	}

	public function getTemplate(): TemplateReference
	{
		return new FilesystemTemplateReference('layout');
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [
			'content' => $this->contentView
		];
	}
}