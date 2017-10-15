<?php

declare(strict_types=1);

namespace Lunch\Component\Kernel;

use DI\Container;
use Psr\Container\ContainerInterface;

final class ComponentLoader
{
	/**
	 * @var array
	 */
	private $serviceDefinitions = [];

	/**
	 * @var array
	 */
	private $loadedComponents = [];

	/**
	 * @var ContainerLoader
	 */
	private $containerLoader;

	public function __construct(ContainerLoader $containerLoader)
	{
		$this->containerLoader = $containerLoader;
	}

	// todo convert to non-recursive approach
	public function addComponent(Component $component): void
	{
		$this->loadComponentDependencies($component);
		$this->loadComponentServices($component);

		$this->loadedComponents[get_class($component)] = $component;
	}

	public function loadServices(): ContainerInterface
	{
		return $this->containerLoader->load($this->serviceDefinitions);
	}

	/**
	 * @param Component $component
	 */
	private function loadComponentDependencies(Component $component): void
	{
		foreach ($component->dependencies() as $dependency) {
			if (isset($this->loadedComponents[$dependency])) {
				continue;
			}

			$this->addComponent(new $dependency);
		}
	}

	/**
	 * @param Component $component
	 */
	private function loadComponentServices(Component $component): void
	{
		foreach ($component->services() as $serviceName => $serviceDefinition) {
			if (isset($this->serviceDefinitions[$serviceName])) {
				throw new ServiceAlreadyDefined($serviceName);
			}

			$this->serviceDefinitions[$serviceName] = $serviceDefinition;
		}
	}
}