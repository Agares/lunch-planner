<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
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

	public function __construct(
		ResponseFactory $responseFactory,
		UrlGenerator $urlGenerator,
		CommandBus $commandBus
	)
	{
		$this->responseFactory = $responseFactory;
		$this->urlGenerator = $urlGenerator;
		$this->commandBus = $commandBus;
	}

	public function handle(ServerRequestInterface $request, string $id): ResponseInterface
	{
		$this->commandBus->execute(new \Lunch\Application\AddPotentialPlace($id, $request->getParsedBody()['name']));

		return $this->responseFactory->redirect($this->urlGenerator->getPath('lunch.show', [$id]));
	}
}