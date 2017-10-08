<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\Form;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddParticipant
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;

	/**
	 * @var CommandBus
	 */
	private $commandBus;
	/**
	 * @var Renderer
	 */
	private $formRenderer;

	public function __construct(
		ResponseFactory $responseFactory,
		UrlGenerator $urlGenerator,
		CommandBus $commandBus,
		Renderer $formRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->urlGenerator = $urlGenerator;
		$this->commandBus = $commandBus;
		$this->formRenderer = $formRenderer;
	}

	public function handle(ServerRequestInterface $request, string $id): ResponseInterface
	{
		// todo validate if $id is empty
		$formDefinition = new Form\AddParticipant($this->urlGenerator, $id);
		$form = new Form($formDefinition);
		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			return $this->responseFactory->html($this->formRenderer->render($formDefinition, $formState));
		}
		$this->commandBus->execute(new \Lunch\Application\AddParticipant($id, $request->getParsedBody()['name']));

		return $this->responseFactory->redirect($this->urlGenerator->generate('lunch.show', [$id]));
	}
}