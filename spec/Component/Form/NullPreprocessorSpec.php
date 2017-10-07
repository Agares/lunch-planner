<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\NullPreprocessor;
use Lunch\Component\Form\Preprocessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class NullPreprocessorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(NullPreprocessor::class);
        $this->shouldImplement(Preprocessor::class);
    }

    public function it_should_not_change_the_array()
    {
	    $data = ['a' => 'b', 'c' => 'd'];

	    $this->process($data)->shouldReturn($data);
    }
}
