<?php

declare(strict_types=1);

return [
	\Lunch\Infrastructure\TemplateRenderer::class     => [
		'parameters' => [
			\Mustache_Engine::class,
		],
	],
	\Mustache_Engine::class                           => [],
	\Lunch\Infrastructure\Http\ResponseFactory::class => [],
	\Lunch\Infrastructure\Http\UrlGenerator::class    => [
		'parameters' => [
			'routes',
		],
	],
	\Lunch\Http\Homepage::class                       => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
			\Lunch\Infrastructure\Http\UrlGenerator::class,
			\Lunch\Infrastructure\TemplateRenderer::class,
		],
	],
	\Lunch\Http\CreateLunch::class                    => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
			\Lunch\Infrastructure\Http\UrlGenerator::class,
			\Lunch\Infrastructure\CQRS\CommandBus::class,
			\Lunch\Infrastructure\UUIDFactory::class
		],
	],
	\Lunch\Http\ShowLunch::class                      => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
		],
	],
	\Lunch\Infrastructure\CQRS\CommandBus::class      => [
		'methodCalls' => [
			['registerHandler', [\Lunch\Application\CreateLunchHandler::class]],
		],
	],
	\Lunch\Application\CreateLunchHandler::class      => [
		'parameters' => [
			\Lunch\Application\Repository::class
		],
	],
	\Lunch\Application\Repository::class              => [
		'className' => \Lunch\Infrastructure\InFileRepository::class,
	],
	\Lunch\Infrastructure\UUIDFactory::class          => [],
];