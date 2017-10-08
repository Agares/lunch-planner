<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadLunchMatrix;
use Lunch\Component\Routing\RouteReference;
use Psr\Http\Message\ResponseInterface;

final class ShowLunch extends CQRSHandler
{
	public function handle(string $id): ResponseInterface
	{
		// todo validate if a lunch with $id exists
		$matrix = $this->queryBus()->handle(new ReadLunchMatrix($id));

		$template = $this->templateRenderer()->render(
			'show',
			[
				'matrix' => $matrix,
				'addParticipantForm' => $this->formRenderer()->render(new \Lunch\Http\Form\AddParticipant($id)),
				'addPotentialPlaceForm' => $this->formRenderer()->render(new \Lunch\Http\Form\AddPotentialPlace($id)),
				'voteLink' => $this->endpointReferenceResolver()->resolve(new RouteReference('lunch.vote', [$id])),
				'removeVoteLink' => $this->endpointReferenceResolver()->resolve(new RouteReference('lunch.remove_vote', [$id])),
				'resultsLink' => $this->endpointReferenceResolver()->resolve(new RouteReference('lunch.results', [$id]))
			]
		);

		return $this->response()->html($template);
	}
}