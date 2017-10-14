<?php

declare(strict_types=1);

namespace Lunch\Component\View;

interface View
{
	public function getViewData(): array;
	public function getTemplate(): TemplateReference;

	/**
	 * @return View[]
	 */
	public function getChildren(): array;
}