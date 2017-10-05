<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Lunch\Infrastructure\UUIDFactory;
use Psr\Http\Message\RequestInterface;
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

	public function __construct(
		// fixme calm down with the number of arguments...
		ResponseFactory $responseFactory,
		UrlGenerator $urlGenerator,
		CommandBus $commandBus,
		UUIDFactory $uuidFactory
	)
	{
		$this->responseFactory = $responseFactory;
		$this->urlGenerator = $urlGenerator;
		$this->commandBus = $commandBus;
		$this->uuidFactory = $uuidFactory;
	}

	public function handle(ServerRequestInterface $request)
	{
		$lunchId = (string)$this->uuidFactory->generateRandom();
		$this->commandBus->execute(new \Lunch\Application\CreateLunch($lunchId, $request->getParsedBody()['lunch_name']));

		$lunchUrl = $this->urlGenerator->getPath('lunch.show', [$lunchId]);

		return $this->responseFactory->redirect($lunchUrl);
	}
}