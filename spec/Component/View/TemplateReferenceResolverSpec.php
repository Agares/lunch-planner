<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\View;

use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\TemplateReferenceHandler;
use Lunch\Component\View\TemplateReferenceHandlerNotFound;
use Lunch\Component\View\TemplateReferenceResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class TemplateReferenceResolverSpec extends ObjectBehavior
{
	public function let(TemplateReferenceHandler $handler)
	{
		$handler->handledType()->willReturn(MockTemplateReferenceA::class);
		$handler->resolve(Argument::type(TemplateReference::class))->willReturn('TEST');
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(TemplateReferenceResolver::class);
    }

    public function it_throws_if_resolver_does_not_exist(TemplateReference $reference)
    {
    	$this->shouldThrow(TemplateReferenceHandlerNotFound::class)->during('resolve', [$reference]);
    }

    public function it_resolves_template_if_resolver_is_registered(TemplateReferenceHandler $handler)
    {
    	$this->registerHandler($handler);

    	$this->resolve(new MockTemplateReferenceA())->shouldReturn('TEST');
    }
}
