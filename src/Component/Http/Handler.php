<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

use Lunch\Component\Form\ViewFactory;
use Lunch\Component\View\Renderer;
use Lunch\Infrastructure\InLayoutTemplateRenderer;
use Lunch\Infrastructure\TemplateRenderer;
use Psr\Container\ContainerInterface;

// the purpose of this class is to provide everything http/html related that might be needed for an http handler
// SRP is broken here, but it might be impossible to balance normal amount of constructor arguments in handlers
// with a sensible API
abstract class Handler
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	protected function response(): ResponseFactory
	{
		return $this->container->get(ResponseFactory::class);
	}

	// todo get rid of this, form views should probably be created in Form class
	protected function formViewFactory(): ViewFactory
	{
		return $this->container->get(ViewFactory::class);
	}

	protected function viewRenderer() : Renderer
	{
		return $this->container()->get(Renderer::class);
	}

	protected function endpointReferenceResolver(): DefaultEndpointReferenceResolver
	{
		return $this->container()->get(DefaultEndpointReferenceResolver::class);
	}

	protected function container(): ContainerInterface
	{
		return $this->container;
	}
}