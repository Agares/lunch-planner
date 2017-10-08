<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Application\ReadResults;
use Lunch\Infrastructure\CQRS\QueryBus;
use Lunch\Component\Http\ResponseFactory;
use Lunch\Infrastructure\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShowResults
{
	/**
	 * @var TemplateRenderer
	 */
	private $templateRenderer;

	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var QueryBus
	 */
	private $queryBus;

	public function __construct(TemplateRenderer $templateRenderer, ResponseFactory $responseFactory, QueryBus $queryBus)
	{
		$this->templateRenderer = $templateRenderer;
		$this->responseFactory = $responseFactory;
		$this->queryBus = $queryBus;
	}

	public function handle(string $id): ResponseInterface
	{
		$results = $this->queryBus->handle(new ReadResults($id));
		$responseContent = $this->templateRenderer->render('results', ['results' => $results]);

		return $this->responseFactory->html($responseContent);
	}
}