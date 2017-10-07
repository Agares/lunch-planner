<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\FormNotSubmitted;
use Lunch\Component\Form\Preprocessor;
use Lunch\Component\Form\SimpleForm;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Validator;
use Lunch\Component\Validator\Violation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class SimpleFormSpec extends ObjectBehavior
{
	public function let(FormDefinition $definition, Validator $validator, Violation $violation, Preprocessor $preprocessor)
	{
		$preprocessor->process(Argument::any())->willReturnArgument();

		$violation->message()->willReturn('OH NO');
		$violation->field()->willReturn('blah_blah');

		$validator->validate(Argument::any())->willReturn(new ValidationResult([]));

		$definition->validator()->willReturn($validator);
		$definition->preprocessor()->willReturn($preprocessor);

		$this->beConstructedWith($definition);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(SimpleForm::class);
    }

    public function it_correctly_passes_negative_validation_result(Validator $validator, Violation $violation)
    {
	    $validationResult = new ValidationResult([$violation]);
	    $validator->validate(Argument::exact([]))->willReturn($validationResult);

    	$this->submit([])->validationResult()->shouldReturn($validationResult);
    }

    public function it_correctly_passes_positive_validation_result(Validator $validator)
    {
	    $validationResult = new ValidationResult([]);

	    $validator->validate(Argument::exact([]))->willReturn($validationResult);

		$this->submit([])->validationResult()->shouldReturn($validationResult);
    }

    public function it_passes_validation_violations_to_state(Validator $validator, Violation $violation)
    {
	    $validationResult = new ValidationResult([$violation]);

	    $validator->validate(Argument::any())->willReturn($validationResult);

		$this->submit([])->validationResult()->shouldReturn($validationResult);
    }

    public function it_preprocesses_values_when_submitted(Preprocessor $preprocessor)
    {
    	$preprocessor->process(Argument::exact(['a' => '']))->willReturn(['a' => 'b']);

    	$this->submit(['a' => ''])->data()->shouldReturn(['a' => 'b']);
    }
}
