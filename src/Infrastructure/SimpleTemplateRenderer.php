<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

final class SimpleTemplateRenderer implements TemplateRenderer
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
		$template = $this->readTemplate($templateName);

		return $this->mustacheEngine->render($template, $context);
	}

	/**
	 * @param string $templateName
	 *
	 * @return bool|string
	 */
	private function readTemplate(string $templateName)
	{
		// todo create TemplateLoader interface and FilesystemTemplateLoader class
		return file_get_contents(__DIR__.sprintf('/../../templates/%s.mustache', $templateName));
	}
}