<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

use Lunch\Component\View\Renderer;
use Psr\Container\ContainerInterface;

// the purpose of this class is to provide everything http/html related that might be needed for an http handler
// SRP is broken here, but it might be impossible to balance normal amount of constructor arguments in handlers
// with a sensible API

// todo this breaks if the components listed here are not loaded
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