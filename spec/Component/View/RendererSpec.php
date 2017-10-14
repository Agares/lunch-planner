<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\View;

use Lunch\Component\View\ReferenceResolver;
use Lunch\Component\View\TemplateReferenceResolver;
use Lunch\Component\View\Renderer;
use Lunch\Component\View\View;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Lunch\Component\Http\MockEndpointReference;

final class RendererSpec extends ObjectBehavior
{
	public function let(TemplateReferenceResolver $templateReferenceResolver, ReferenceResolver $referenceResolver)
	{
		$this->beConstructedWith($templateReferenceResolver, new \Mustache_Engine(), $referenceResolver);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(Renderer::class);
    }

    public function it_renders_a_mustache_view(View $view, TemplateReferenceResolver $templateReferenceResolver)
    {
    	$reference = new MockTemplateReferenceA();

    	$view->getViewData()->willReturn(['a' => 'b']);
    	$view->getTemplate()->willReturn($reference);
    	$view->getChildren()->willReturn([]);

    	$templateReferenceResolver
		    ->resolve(Argument::exact($reference))
		    ->shouldBeCalled()
		    ->willReturn('A {{a}} C');

		$this
			->render($view)
			->shouldReturn('A b C');
    }

    public function it_renders_nested_views(View $view, View $child, TemplateReferenceResolver $templateReferenceResolver)
    {
	    $parentReference = new MockTemplateReferenceA('A');
	    $childReference = new MockTemplateReferenceA('B');

	    $view->getViewData()->willReturn([]);
	    $view->getTemplate()->willReturn($parentReference);
	    $view->getChildren()->willReturn(['b' => $child]);

	    $child->getViewData()->willReturn(['test' => 'B']);
	    $child->getTemplate()->willReturn($childReference);
	    $child->getChildren()->willReturn([]);

	    $templateReferenceResolver
		    ->resolve(Argument::exact($parentReference))
		    ->shouldBeCalled()
		    ->willReturn('A {{b}} C');

	    $templateReferenceResolver
		    ->resolve(Argument::exact($childReference))
		    ->shouldBeCalled()
		    ->willReturn('{{test}}');

	    $this->render($view)->shouldReturn('A B C');
    }

    public function it_resolves_references(View $view, ReferenceResolver $referenceResolver, TemplateReferenceResolver $templateReferenceResolver)
    {
	    $reference = new MockTemplateReferenceA();

	    $view->getViewData()->willReturn(['a' => new MockEndpointReference()]);
	    $view->getTemplate()->willReturn($reference);
	    $view->getChildren()->willReturn([]);

	    $templateReferenceResolver->resolve(Argument::any())->willReturn('{{a}}');

	    $referenceResolver->resolve(Argument::type(MockEndpointReference::class))->willReturn('test');

	    $this->render($view)->shouldReturn('test');
    }
}
