<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\SimpleForm;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Lunch\Infrastructure\UUIDFactory;
use Psr\Http\Message\RequestInterface;
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
		UrlGenerator $urlGenerator,
		CommandBus $commandBus,
		UUIDFactory $uuidFactory,
		Renderer $formRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->urlGenerator = $urlGenerator;
		$this->commandBus = $commandBus;
		$this->uuidFactory = $uuidFactory;
		$this->formRenderer = $formRenderer;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$formDefinition = new Form\CreateLunch($this->urlGenerator);
		$form = new SimpleForm($formDefinition);

		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			$renderedForm = $this->formRenderer->render($formDefinition, $formState);

			return $this->responseFactory->html($renderedForm);
		}

		$lunchId = (string)$this->uuidFactory->generateRandom();
		$this->commandBus->execute(new \Lunch\Application\CreateLunch($lunchId, $formState->data()['lunch_name']));

		$lunchUrl = $this->urlGenerator->generate('lunch.show', [$lunchId]);

		return $this->responseFactory->redirect($lunchUrl);
	}
}