<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\View;

use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\EndpointReferenceResolver;
use Lunch\Component\View\ReferenceResolver;
use Lunch\Component\View\ResolverNotFound;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Lunch\Component\Http\MockEndpointReference;

final class ReferenceResolverSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ReferenceResolver::class);
    }

    public function it_throws_if_no_resolver_exists()
    {
    	$this
		    ->shouldThrow(ResolverNotFound::class)
		    ->during('resolve', [new MockEndpointReference()]);
    }

    public function it_resolves_for_registered_resolver(EndpointReferenceResolver $resolver)
    {
    	$resolver->resolve(Argument::type(EndpointReference::class))->willReturn('some url');

    	$this->registerResolver($resolver, EndpointReference::class);

    	$this->resolve(new MockEndpointReference())->shouldReturn('some url');
    }

    public function it_can_tell_if_reference_is_not_resolvable()
    {
    	$this->isResolvable(new MockEndpointReference())->shouldReturn(false);
    }

    public function it_can_tell_if_reference_is_resolvable(EndpointReferenceResolver $resolver)
    {
	    $this->registerResolver($resolver, EndpointReference::class);

	    $this->isResolvable(new MockEndpointReference())->shouldReturn(true);
    }
}
