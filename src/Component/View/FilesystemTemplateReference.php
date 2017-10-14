<?php

declare(strict_types=1);

namespace Lunch\Component\View;

final class FilesystemTemplateReference implements TemplateReference
{
	/**
	 * @var string
	 */
	private $templateName;

	public function __construct(string $templateName)
	{
		$this->templateName = $templateName;
	}

	public function templateName(): string
	{
		return $this->templateName;
	}
}