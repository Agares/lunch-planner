<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Routing\RouteReference;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Vote extends CQRSHandler
{
	public function handle(ServerRequestInterface $request, $id): ResponseInterface
	{
		$formParams = $request->getParsedBody();
		$participantName = $formParams['participant_name'];
		$potentialPlaceName = $formParams['potential_place_name'];

		$this->commandBus()->execute(new \Lunch\Application\Vote($id, $participantName, $potentialPlaceName));

		return $this->response()->redirect(new RouteReference('lunch.show', [$id]));
	}
}