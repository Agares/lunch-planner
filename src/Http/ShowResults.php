<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadResults;
use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;

final class ShowResults extends CQRSHandler
{
	public function handle(string $id): ResponseInterface
	{
		$results = $this->queryBus()->handle(new ReadResults($id));
		$view = new View\ShowResults($results);
		$layout = new Layout($view);
		$responseContent = $this->viewRenderer()->render($layout);

		return $this->response()->html($responseContent);
	}
}