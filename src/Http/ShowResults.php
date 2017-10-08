<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadResults;
use Psr\Http\Message\ResponseInterface;

final class ShowResults extends CQRSHandler
{
	public function handle(string $id): ResponseInterface
	{
		$results = $this->queryBus()->handle(new ReadResults($id));
		$responseContent = $this->templateRenderer()->render('results', ['results' => $results]);

		return $this->response()->html($responseContent);
	}
}