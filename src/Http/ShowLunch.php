<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadLunchMatrix;
use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;

final class ShowLunch extends CQRSHandler
{
	public function handle(string $id): ResponseInterface
	{
		// todo validate if a lunch with $id exists
		$matrix = $this->queryBus()->handle(new ReadLunchMatrix($id));

		$view = new View\ShowLunch(
			$this->formViewFactory()->createView(new \Lunch\Http\Form\AddParticipant($id)),
			$this->formViewFactory()->createView(new \Lunch\Http\Form\AddPotentialPlace($id)),
			$matrix,
			$id
		);
		$layout = new Layout($view);

		$template = $this->viewRenderer()->render($layout);

		return $this->response()->html($template);
	}
}