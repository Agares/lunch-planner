<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\Form;
use Lunch\Component\Routing\RouteReference;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Component\Http\ResponseFactory;
use Lunch\Component\Routing\UrlGenerator;
use Lunch\Infrastructure\UUIDFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateLunch
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
	 * @var UUIDFactory
	 */
	private $uuidFactory;

	/**
	 * @var Renderer
	 */
	private $formRenderer;

	public function __construct(
		// fixme calm down with the number of arguments...
		ResponseFactory $responseFactory,
		CommandBus $commandBus,
		UUIDFactory $uuidFactory,
		Renderer $formRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->commandBus = $commandBus;
		$this->uuidFactory = $uuidFactory;
		$this->formRenderer = $formRenderer;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$formDefinition = new \Lunch\Http\Form\CreateLunch();
		$form = new Form($formDefinition);

		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			$renderedForm = $this->formRenderer->render($formDefinition, $formState);

			return $this->responseFactory->html($renderedForm);
		}

		$lunchId = (string)$this->uuidFactory->generateRandom();
		$this->commandBus->execute(new \Lunch\Application\CreateLunch($lunchId, $formState->data()['lunch_name']));

		return $this->responseFactory->redirect(new RouteReference('lunch.show', [$lunchId]));
	}
}