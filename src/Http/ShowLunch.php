<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadLunchMatrix;
use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\SimpleForm;
use Lunch\Infrastructure\CQRS\QueryBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Lunch\Infrastructure\InLayoutTemplateRenderer;
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
	 * @var InLayoutTemplateRenderer
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

	/**
	 * @var Renderer
	 */
	private $formRenderer;

	public function __construct(
		// todo calm down with the number of parameters
		ResponseFactory $responseFactory,
		TemplateRenderer $templateRenderer,
		UrlGenerator $urlGenerator,
		QueryBus $queryBus,
		Renderer $formRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->templateRenderer = $templateRenderer;
		$this->urlGenerator = $urlGenerator;
		$this->queryBus = $queryBus;
		$this->formRenderer = $formRenderer;
	}

	public function handle(string $id): ResponseInterface
	{
		// todo validate if a lunch with $id exists
		$matrix = $this->queryBus->handle(new ReadLunchMatrix($id));

		$template = $this->templateRenderer->render(
			'show',
			[
				'matrix' => $matrix,
				'addParticipantForm' => $this->formRenderer->render(new Form\AddParticipant($this->urlGenerator, $id)),
				'addPotentialPlaceForm' => $this->formRenderer->render(new Form\AddPotentialPlace($this->urlGenerator, $id)),
				'voteLink' => $this->urlGenerator->generate('lunch.vote', [$id]),
				'removeVoteLink' => $this->urlGenerator->generate('lunch.remove_vote', [$id]),
				'resultsLink' => $this->urlGenerator->generate('lunch.results', [$id])
			]
		);

		return $this->responseFactory->html($template);
	}
}