<?php

declare(strict_types=1);

namespace Lunch\Component\View;

final class FilesystemTemplateReferenceResolver implements TemplateReferenceHandler
{
	public function resolve(TemplateReference $templateReference): string
	{
		assert($templateReference instanceof FilesystemTemplateReference);

		// todo make the path configurable
		return file_get_contents(
			__DIR__ . sprintf('/../../../templates/%s.mustache', $templateReference->templateName())
		);
	}

	public function handledType(): string
	{
		return FilesystemTemplateReference::class;
	}
}