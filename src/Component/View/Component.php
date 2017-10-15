<?php

declare(strict_types=1);

namespace Lunch\Component\View;

use Lunch\Component\Http\DefaultEndpointReferenceResolver;
use Lunch\Component\Http\EndpointReference;

final class Component implements \Lunch\Component\Kernel\Component
{
	public function services(): array
	{
		return [
			\Mustache_Engine::class                            => [],

			Renderer::class                            => [
				'parameters' => [
					TemplateReferenceResolver::class,
					\Mustache_Engine::class,
					ReferenceResolver::class
				]
			],
			ReferenceResolver::class                   => [
				'methodCalls' => [
					['registerResolver', [DefaultEndpointReferenceResolver::class, 'literal:'.EndpointReference::class ]]
				]
			],
			TemplateReferenceResolver::class           => [
				'methodCalls' => [
					['registerHandler', [FilesystemTemplateReferenceResolver::class]]
				]
			],
			FilesystemTemplateReferenceResolver::class => []
		];
	}

	public function dependencies(): array
	{
		return [
			\Lunch\Component\Http\Component::class
		];
	}
}