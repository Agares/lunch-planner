<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

final class Component implements \Lunch\Component\Kernel\Component
{
	public function services(): array
	{
		return [
			RouteReferenceResolver::class => [
				'parameters' => [
					UrlGenerator::class,
				],
			],
			UrlGenerator::class           => [
				'parameters' => [
					'routes',
				],
			],
		];
	}

	public function dependencies(): array
	{
		return [
			\Lunch\Component\Http\Component::class
		];
	}
}