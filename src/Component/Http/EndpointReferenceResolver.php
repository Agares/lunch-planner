<?php

namespace Lunch\Component\Http;

class EndpointReferenceResolver
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
