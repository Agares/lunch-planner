<?php

declare(strict_types=1);

namespace Lunch\Component\Kernel;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

final class ContainerLoader
{
	public function load(array $containerConfiguration): ContainerInterface
	{
		$containerBuilder = new ContainerBuilder();
		$containerBuilder->useAutowiring(false);

		$serviceDefinitions = [];

		// todo refactor
		foreach($containerConfiguration as $serviceName => $serviceConfiguration) {
			if(isset($serviceConfiguration['create'])) {
				$definition = \DI\factory($serviceConfiguration['create']);
			} elseif(isset($serviceConfiguration['literal'])) {
				$definition = \DI\value($serviceConfiguration['literal']);
			} else {
				$definition = \DI\object($serviceConfiguration['className'] ?? $serviceName);
			}

			if(isset($serviceConfiguration['parameters'])) {
				$constructorParameters = array_map('\DI\get', $serviceConfiguration['parameters']);
				$definition->constructor(...$constructorParameters);
			}

			if(isset($serviceConfiguration['methodCalls'])) {
				foreach($serviceConfiguration['methodCalls'] as $methodCall) {
					$methodParameters = [];

					foreach($methodCall[1] as $argument) {
						if(strpos($argument, 'literal:') === 0) {
							$methodParameters[] = substr($argument, strlen('literal:'));
						} else {
							$methodParameters[] = \DI\get($argument);
						}
					}

					$definition->method($methodCall[0], ...$methodParameters);
				}
			}

			$serviceDefinitions[$serviceName] = $definition;
		}

		$containerBuilder->addDefinitions($serviceDefinitions);

		return $containerBuilder->build();
	}
}