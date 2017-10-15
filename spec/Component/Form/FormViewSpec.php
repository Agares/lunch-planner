<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\FormState;
use Lunch\Component\Form\FormView;
use Lunch\Component\Form\ViewFactory;
use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\DefaultEndpointReferenceResolver;
use Lunch\Component\Http\EndpointReferenceResolver;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Violation;
use Lunch\Infrastructure\TemplateRenderer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\Lunch\Component\Http\MockEndpointReference;

class FormViewSpec extends ObjectBehavior
{
	public function let(
		FormDefinition $definition,
		FormState $state,
		EndpointReference $endpointReference
	)
	{
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

		$this->beConstructedWith($definition, $state);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(FormView::class);
    }

    public function it_passes_values_to_the_view(FormState $state)
    {
    	$state
		    ->data()
		    ->willReturn([
    		'value_01' => 'a'
	    ]);

    	$this->getViewData()->shouldHaveKeyWithValue('values', ['value_01' => 'a']);
    }

    public function it_passes_validation_violations_to_the_view(FormDefinition $definition, FormState $state, Violation $violation)
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

    	$this
		    ->getViewData()
		    ->shouldHaveKeyWithValue('validationMessages', ['value_01' => 'Oh noes']);
    }

    public function it_passes_form_action_to_the_template(EndpointReference $endpointReference)
    {
		$this->getViewData()->shouldHaveKeyWithValue('action', $endpointReference);
    }

    public function it_correctly_handles_empty_state(FormDefinition $definition, EndpointReference $endpointReference)
    {
    	$this->beConstructedWith($definition, null);

    	$this->getViewData()->shouldBeEqualTo([
		    'values' => [],
		    'validationMessages' => [],
		    'action' => $endpointReference
	    ]);
    }
}
