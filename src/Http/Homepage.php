<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\TemplateRenderer;
use Lunch\Infrastructure\Http\UrlGenerator;
use Psr\Http\Message\ResponseInterface;

final class Homepage
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
	 * @var TemplateRenderer
	 */
	private $templateRenderer;

	public function __construct(ResponseFactory $responseFactory, UrlGenerator $urlGenerator, TemplateRenderer $templateRenderer)
	{
		$this->responseFactory = $responseFactory;
		$this->urlGenerator = $urlGenerator;
		$this->templateRenderer = $templateRenderer;
	}

	public function handle(): ResponseInterface
	{
		$response = $this->templateRenderer->render(
			'home',
			[
				'createLunchUrl' => $this->urlGenerator->generate('lunch.create')
			]
		);

		return $this->responseFactory->html($response);
	}
}