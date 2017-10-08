<?php

declare(strict_types=1);

return [
	'routes'                                                      => [
		'literal' => require __DIR__.'/routes.php',
	],
	\Lunch\Infrastructure\InLayoutTemplateRenderer::class         => [
		'parameters' => [
			\Lunch\Infrastructure\SimpleTemplateRenderer::class,
		],
	],
	\Mustache_Engine::class                                       => [],
	\Lunch\Component\Http\ResponseFactory::class                  => [
		'parameters' => [
			\Lunch\Component\Http\DefaultEndpointReferenceResolver::class
		]
	],
	\Lunch\Component\Routing\UrlGenerator::class                  => [
		'parameters' => [
			'routes',
		],
	],
	\Lunch\Http\Homepage::class                                   => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\CreateLunch::class                                => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\ShowLunch::class                                  => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\AddParticipant::class                      => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\AddPotentialPlace::class                   => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\Vote::class                                => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\RemoveVote::class                          => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Http\ShowResults::class                         => [
		'parameters' => [
			\Psr\Container\ContainerInterface::class
		],
	],
	\Lunch\Infrastructure\CQRS\CommandBus::class           => [
		'methodCalls' => [
			['registerHandler', [\Lunch\Application\CreateLunchHandler::class]],
			['registerHandler', [\Lunch\Application\AddParticipantHandler::class]],
			['registerHandler', [\Lunch\Application\AddPotentialPlaceHandler::class]],
			['registerHandler', [\Lunch\Application\VoteHandler::class]],
			['registerHandler', [\Lunch\Application\RemoveVoteHandler::class]],
		],
	],
	\Lunch\Application\CreateLunchHandler::class           => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\AddParticipantHandler::class        => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\AddPotentialPlaceHandler::class     => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\VoteHandler::class                  => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\RemoveVoteHandler::class            => [
		'parameters' => [
			\Lunch\Application\Repository::class,
		],
	],
	\Lunch\Application\Repository::class                   => [
		'className' => \Lunch\Infrastructure\PDORepository::class,
	],
	\Lunch\Infrastructure\PDORepository::class             => [
		'parameters' => [
			\PDO::class,
		],
	],
	\Lunch\Infrastructure\UUIDFactory::class               => [],
	\PDO::class                                            => [
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
	\Lunch\Infrastructure\CQRS\QueryBus::class                    => [
		'methodCalls' => [
			['registerHandler', [\Lunch\Application\ReadLunchMatrixHandler::class]],
			['registerHandler', [\Lunch\Application\ReadResultsHandler::class]],
		],
	],
	\Lunch\Application\ReadLunchMatrixHandler::class              => [
		'parameters' => [
			\PDO::class,
		],
	],
	\Lunch\Application\ReadResultsHandler::class                  => [
		'parameters' => [
			\PDO::class,
		],
	],
	\Lunch\Component\Form\Renderer::class                         => [
		'parameters' => [
			\Lunch\Infrastructure\SimpleTemplateRenderer::class,
			\Lunch\Component\Http\DefaultEndpointReferenceResolver::class
		],
	],
	\Lunch\Component\Form\Renderer::class.'+Standalone'           => [
		'className'  => \Lunch\Component\Form\Renderer::class,
		'parameters' => [
			\Lunch\Infrastructure\InLayoutTemplateRenderer::class,
		],
	],
	\Lunch\Infrastructure\SimpleTemplateRenderer::class           => [
		'parameters' => [
			\Mustache_Engine::class,
		],
	],
	\Lunch\Component\Http\DefaultEndpointReferenceResolver::class => [
		'methodCalls' => [
			['registerResolver', [\Lunch\Component\Routing\RouteReferenceResolver::class]],
		],
	],
	\Lunch\Component\Routing\RouteReferenceResolver::class        => [
		'parameters' => [
			\Lunch\Component\Routing\UrlGenerator::class,
		],
	],
];