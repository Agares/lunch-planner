<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

final class InLayoutTemplateRenderer implements TemplateRenderer
{
	/**
	 * @var TemplateRenderer
	 */
	private $templateRenderer;

	public function __construct(TemplateRenderer $templateRenderer)
	{
		$this->templateRenderer = $templateRenderer;
	}

	public function render(string $templateName, $context = []): string
	{
		$content = $this->templateRenderer->render($templateName, $context);

		return $this->templateRenderer->render('layout', ['content' => $content]);
	}
}