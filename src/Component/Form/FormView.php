<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class FormView implements View
{
	/**
	 * @var array
	 */
	private $viewData;

	/**
	 * @var TemplateReference
	 */
	private $template;

	public function __construct(array $viewData, TemplateReference $template)
	{
		$this->viewData = $viewData;
		$this->template = $template;
	}

	public function getViewData(): array
	{
		return $this->viewData;
	}

	public function getTemplate(): TemplateReference
	{
		return $this->template;
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [];
	}
}