<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Http;

use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\DefaultEndpointReferenceResolver;
use Lunch\Component\Http\ResolverNotFound;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DefaultEndpointReferenceResolverSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DefaultEndpointReferenceResolver::class);
    }

    public function it_throws_if_resolver_cannot_be_found(EndpointReference $endpointReference)
    {
    	$this->shouldThrow(ResolverNotFound::class)->during('resolve', [$endpointReference]);
    }

    public function it_resolves_a_reference_if_resolver_exists()
    {
    	$this->registerResolver(new MockResolver());

    	$this->resolve(new MockEndpointReference())->shouldReturn('I_AM_RESOLVED');
    }
}
