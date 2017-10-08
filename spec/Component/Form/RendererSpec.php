<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\FormState;
use Lunch\Component\Form\Renderer;
use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\DefaultEndpointReferenceResolver;
use Lunch\Component\Http\EndpointReferenceResolver;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Violation;
use Lunch\Infrastructure\TemplateRenderer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Lunch\Component\Http\MockEndpointReference;

class RendererSpec extends ObjectBehavior
{
	public function let(
		FormDefinition $definition,
		FormState $state,
		TemplateRenderer $templateRenderer,
		EndpointReference $endpointReference,
		EndpointReferenceResolver $endpointReferenceResolver
	)
	{
		$endpointReferenceResolver->resolve(Argument::any())->willReturn('resolved_action');

		$this->beConstructedWith($templateRenderer, $endpointReferenceResolver);

		$definition
			->name()
			->willReturn('mock_form');

		$definition
			->action()
			->willReturn($endpointReference);

		$state
			->data()
			->willReturn([]);

		$state
			->validationResult()
			->willReturn(new ValidationResult([]));
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(Renderer::class);
    }

    public function it_renders_the_form(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer)
    {
	    $templateRenderer
		    ->render(Argument::exact('form/mock_form'), Argument::any())
		    ->willReturn('');

    	$this->render($definition, $state);
    }

    public function it_passes_values_to_the_view(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer)
    {
    	$state
		    ->data()
		    ->willReturn([
    		'value_01' => 'a'
	    ]);

    	$templateRenderer
		    ->render(Argument::any(), Argument::withEntry('values', ['value_01' => 'a']))
		    ->willReturn('')
	        ->shouldBeCalled();

    	$this->render($definition, $state);
    }

    public function it_passes_validation_violations_to_the_view(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer, Violation $violation)
    {
    	$violation->field()->willReturn('value_01');
    	$violation->message()->willReturn('Oh noes');

    	$state
		    ->data()
		    ->willReturn(
		    	['value_01' => 'a']
		    );

    	$state
		    ->validationResult()
		    ->willReturn(new ValidationResult([$violation->getWrappedObject()]));

    	$templateRenderer
		    ->render(Argument::any(), Argument::withEntry('validationMessages', ['value_01' => 'Oh noes']))
	        ->shouldBeCalled();

    	$this->render($definition, $state);
    }

    public function it_passes_resolved_form_action_to_the_template(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer)
    {
		$templateRenderer
			->render(Argument::any(), Argument::withEntry('action', 'resolved_action'))
			->shouldBeCalled();

		$this->render($definition, $state);
    }
}
