<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadLunchMatrix;
use Lunch\Infrastructure\CQRS\QueryBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Lunch\Infrastructure\TemplateRenderer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShowLunch
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var TemplateRenderer
	 */
	private $templateRenderer;

	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;

	/**
	 * @var QueryBus
	 */
	private $queryBus;

	public function __construct(
		// todo calm down with the number of parameters
		ResponseFactory $responseFactory,
		TemplateRenderer $templateRenderer,
		UrlGenerator $urlGenerator,
		QueryBus $queryBus
	)
	{
		$this->responseFactory = $responseFactory;
		$this->templateRenderer = $templateRenderer;
		$this->urlGenerator = $urlGenerator;
		$this->queryBus = $queryBus;
	}

	public function handle(string $id): ResponseInterface
	{
		$matrix = $this->queryBus->handle(new ReadLunchMatrix($id));

		$template = $this->templateRenderer->render(
			'show',
			[
				'matrix' => $matrix,
				'addParticipantLink' => $this->urlGenerator->generate('lunch.participants.add', [$id]),
				'addPotentialPlaceLink' => $this->urlGenerator->generate('lunch.potential_places.add', [$id]),
				'voteLink' => $this->urlGenerator->generate('lunch.vote', [$id])
			]
		);

		return $this->responseFactory->html($template);
	}
}