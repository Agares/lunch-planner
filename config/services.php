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
			\Lunch\Infrastructure\UUIDFactory::class,
		],
	],
	\Lunch\Http\ShowLunch::class                      => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
			\Lunch\Infrastructure\TemplateRenderer::class,
			\Lunch\Infrastructure\Http\UrlGenerator::class,
			\Lunch\Infrastructure\CQRS\QueryBus::class
		],
	],
	\Lunch\Http\AddParticipant::class => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
			\Lunch\Infrastructure\Http\UrlGenerator::class,
			\Lunch\Infrastructure\CQRS\CommandBus::class
		]
	],
	\Lunch\Http\AddPotentialPlace::class => [
		'parameters' => [
			\Lunch\Infrastructure\Http\ResponseFactory::class,
			\Lunch\Infrastructure\Http\UrlGenerator::class,
			\Lunch\Infrastructure\CQRS\CommandBus::class
		]
	],
	\Lunch\Infrastructure\CQRS\CommandBus::class      => [
		'methodCalls' => [
			['registerHandler', [\Lunch\Application\CreateLunchHandler::class]],
			['registerHandler', [\Lunch\Application\AddParticipantHandler::class]],
			['registerHandler', [\Lunch\Application\AddPotentialPlaceHandler::class]],
		],
	],
	\Lunch\Application\CreateLunchHandler::class      => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\AddParticipantHandler::class      => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\AddPotentialPlaceHandler::class      => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\Repository::class              => [
		'className' => \Lunch\Infrastructure\PDORepository::class,
	],
	\Lunch\Infrastructure\PDORepository::class        => [
		'parameters' => [
			\PDO::class,
		],
	],
	\Lunch\Infrastructure\UUIDFactory::class          => [],
	\PDO::class                                       => [
		'create' => function () {
			$pdo = new \PDO(
				sprintf('pgsql:host=db;dbname=%s', getenv('POSTGRES_DB')),
				getenv('POSTGRES_USER'),
				getenv('POSTGRES_PASSWORD')
			);
			$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

			return $pdo;
		},
	],
	\Lunch\Infrastructure\CQRS\QueryBus::class        => [
		'methodCalls' => [
			['registerHandler', [\Lunch\Application\ReadLunchMatrixHandler::class]]
		]
	],
	\Lunch\Application\ReadLunchMatrixHandler::class => [
		'parameters' => [
			\PDO::class
		]
	]
];