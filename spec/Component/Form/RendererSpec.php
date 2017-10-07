<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\FormState;
use Lunch\Component\Form\Renderer;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Violation;
use Lunch\Infrastructure\TemplateRenderer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RendererSpec extends ObjectBehavior
{
	public function let(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer)
	{
		$this->beConstructedWith($templateRenderer, $definition);

		$definition
			->name()
			->willReturn('mock_form');

		$definition
			->action()
			->willReturn('TEST');

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

    public function it_passes_form_action_to_the_view(FormDefinition $definition, FormState $state, TemplateRenderer $templateRenderer)
    {
		$templateRenderer
			->render(Argument::any(), Argument::withEntry('action', 'TEST'))
			->shouldBeCalled();

		$this->render($definition, $state);
    }
}
