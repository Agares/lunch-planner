<?php

declare(strict_types=1);

namespace Lunch\Http\View;

use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class Homepage implements View
{
	/**
	 * @var View
	 */
	private $form;

	public function __construct(View $form)
	{
		$this->form = $form;
	}

	public function getViewData(): array
	{
		return [];
	}

	public function getTemplate(): TemplateReference
	{
		return new FilesystemTemplateReference('home');
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [
			'form' => $this->form
		];
	}
}