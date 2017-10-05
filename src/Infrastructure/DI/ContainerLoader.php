<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\DI;

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
					$definition->method($methodCall[0], ...array_map('\DI\get', $methodCall[1] ?? []));
				}
			}

			$serviceDefinitions[$serviceName] = $definition;
		}

		$containerBuilder->addDefinitions($serviceDefinitions);

		return $containerBuilder->build();
	}
}