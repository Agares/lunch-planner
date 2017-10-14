<?php

namespace Lunch\Component\View;

class ReferenceResolver
{
	private $resolvers = [];

	public function resolve($reference): string
    {
    	$resolver = $this->findResolver($reference);

    	if($resolver === null) {
		    throw new ResolverNotFound(get_class($reference));
	    }

	    return $resolver->resolve($reference);
    }

    public function registerResolver($resolver, $resolvedType): void
    {
    	$this->resolvers[$resolvedType] = $resolver;
    }

    public function isResolvable($reference): bool
    {
    	return $this->findResolver($reference) !== null;
    }

    private function findResolver($reference)
    {
	    foreach($this->resolvers as $resolvedType => $resolver)
	    {
		    if(is_a($reference, $resolvedType)) {
			    return $resolver;
		    }
	    }

	    return null;
    }
}
