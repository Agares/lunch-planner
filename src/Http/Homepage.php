<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Renderer;
use Lunch\Component\Form\SimpleForm;
use Lunch\Infrastructure\Http\ResponseFactory;
use Lunch\Infrastructure\Http\UrlGenerator;
use Lunch\Infrastructure\InLayoutTemplateRenderer;
use Psr\Http\Message\ResponseInterface;

final class Homepage
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	/**
	 * @var SimpleForm
	 */
	private $form;

	/**
	 * @var Renderer
	 */
	private $formRenderer;
	/**
	 * @var InLayoutTemplateRenderer
	 */
	private $templateRenderer;
	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;

	public function __construct(
		ResponseFactory $responseFactory,
		UrlGenerator $urlGenerator,
		Renderer $formRenderer,
		InLayoutTemplateRenderer $templateRenderer
	)
	{
		$this->responseFactory = $responseFactory;
		$this->formRenderer = $formRenderer;
		$this->templateRenderer = $templateRenderer;
		$this->urlGenerator = $urlGenerator;
	}

	public function handle(): ResponseInterface
	{
		$formDefinition = new Form\CreateLunch($this->urlGenerator);
		$form = $this->formRenderer->render($formDefinition);

		return $this->responseFactory->html($this->templateRenderer->render('home', ['form' => $form]));
	}
}