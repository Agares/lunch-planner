<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Routing\RouteReference;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Component\Http\ResponseFactory;
use Lunch\Component\Routing\UrlGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RemoveVote
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var CommandBus
	 */
	private $commandBus;

	public function __construct(ResponseFactory $responseFactory, CommandBus $commandBus)
	{
		$this->responseFactory = $responseFactory;
		$this->commandBus = $commandBus;
	}

	public function handle(ServerRequestInterface $request, $id): ResponseInterface
	{
		$formParams = $request->getParsedBody();
		$participantName = $formParams['participant_name'];
		$potentialPlaceName = $formParams['potential_place_name'];

		$this->commandBus->execute(new \Lunch\Application\RemoveVote($id, $participantName, $potentialPlaceName));

		return $this->responseFactory->redirect(new RouteReference('lunch.show', [$id]));
	}
}