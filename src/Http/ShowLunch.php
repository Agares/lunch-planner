<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadLunchMatrix;
use Lunch\Component\Form\FormView;
use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;

final class ShowLunch extends CQRSHandler
{
	public function handle(string $id): ResponseInterface
	{
		// todo validate if a lunch with $id exists
		$matrix = $this->queryBus()->handle(new ReadLunchMatrix($id));

		$view = new View\ShowLunch(
			new FormView(new Form\AddParticipant($id)),
			new FormView(new Form\AddPotentialPlace($id)),
			$matrix,
			$id
		);
		$layout = new Layout($view);

		$template = $this->viewRenderer()->render($layout);

		return $this->response()->html($template);
	}
}