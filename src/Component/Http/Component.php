<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

use Lunch\Component\Routing\RouteReferenceResolver;

final class Component implements \Lunch\Component\Kernel\Component
{
	public function services(): array
	{
		return [
			ResponseFactory::class                  => [
				'parameters' => [
					DefaultEndpointReferenceResolver::class
				]
			],
			DefaultEndpointReferenceResolver::class => [
				'methodCalls' => [
					// todo reverse this dependency (i.e. router itself should register the resolver)
					['registerResolver', [RouteReferenceResolver::class]],
				],
			],
		];
	}

	public function dependencies(): array
	{
		return [

		];
	}
}