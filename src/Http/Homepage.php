<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Http\ResponseFactory;
use Lunch\Infrastructure\InLayoutTemplateRenderer;
use Psr\Http\Message\ResponseInterface;

final class Homepage
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var Renderer
	 */
	private $formRenderer;
	/**
	 * @var InLayoutTemplateRenderer
	 */
	private $templateRenderer;

	public function __construct(
		ResponseFactory $responseFactory,
		Renderer $formRenderer,
		InLayoutTemplateRenderer $templateRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->formRenderer = $formRenderer;
		$this->templateRenderer = $templateRenderer;
	}

	public function handle(): ResponseInterface
	{
		$formDefinition = new Form\CreateLunch();
		$form = $this->formRenderer->render($formDefinition);

		return $this->responseFactory->html($this->templateRenderer->render('home', ['form' => $form]));
	}
}