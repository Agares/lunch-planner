<?php

declare(strict_types = 1);

namespace Lunch\Infrastructure;

interface TemplateRenderer
{
	public function render(string $templateName, $context = []): string;
}