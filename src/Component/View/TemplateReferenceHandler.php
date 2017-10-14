<?php

declare(strict_types=1);

namespace Lunch\Component\View;

interface TemplateReferenceHandler
{
	public function resolve(TemplateReference $templateReference): string;
	public function handledType(): string;
}