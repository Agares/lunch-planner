<?php

declare(strict_types = 1);

namespace Lunch\Component\Http;

final class DefaultEndpointReferenceResolver implements EndpointReferenceResolver
{
	/**
	 * @var EndpointReferenceHandler[]
	 */
	private $resolvers = [];

	public function registerResolver(EndpointReferenceHandler $resolver): void
	{
		$this->resolvers[$resolver->handledType()] = $resolver;
	}

	public function resolve(EndpointReference $endpointReference): string
    {
    	if(!isset($this->resolvers[get_class($endpointReference)])) {
	        throw new ResolverNotFound(get_class($endpointReference));
        }

        return $this->resolvers[get_class($endpointReference)]->handle($endpointReference);
    }
}
