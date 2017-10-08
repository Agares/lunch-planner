<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\Form;
use Lunch\Component\Routing\RouteReference;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Component\Http\ResponseFactory;
use Lunch\Component\Routing\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddPotentialPlace
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
		CommandBus $commandBus,
		Renderer $formRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->commandBus = $commandBus;
		$this->formRenderer = $formRenderer;
	}

	public function handle(ServerRequestInterface $request, string $id): ResponseInterface
	{
		// todo validate if $id is not empty?
		$formDefinition = new \Lunch\Http\Form\AddPotentialPlace($id);
		$form = new Form($formDefinition);
		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			return $this->responseFactory->html($this->formRenderer->render($formDefinition, $formState));
		}

		$this->commandBus->execute(new \Lunch\Application\AddPotentialPlace($id, $request->getParsedBody()['name']));

		return $this->responseFactory->redirect(new RouteReference('lunch.show', [$id]));
	}
}