<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

final class TemplateRenderer
{
	/**
	 * @var \Mustache_Engine
	 */
	private $mustacheEngine;

	public function __construct(\Mustache_Engine $mustacheEngine)
	{
		$this->mustacheEngine = $mustacheEngine;
	}

	public function render(string $templateName, $context = []): string
	{
		$template = file_get_contents(__DIR__.sprintf('/../../templates/%s.mustache', $templateName));

		return $this->mustacheEngine->render($template, $context);
	}
}