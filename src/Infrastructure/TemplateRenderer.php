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
		$layoutTemplate = $this->readTemplate('layout');
		$contentTemplate = $this->readTemplate($templateName);

		$content = $this->mustacheEngine->render($contentTemplate, $context);

		return $this->mustacheEngine->render($layoutTemplate, ['content' => $content]);
	}

	/**
	 * @param string $templateName
	 *
	 * @return bool|string
	 */
	protected function readTemplate(string $templateName)
	{
		return file_get_contents(__DIR__.sprintf('/../../templates/%s.mustache', $templateName));
	}
}