<?php

declare(strict_types = 1);

namespace spec\Lunch\Component\Form;

use Lunch\Component\Form\Preprocessor;
use Lunch\Component\Form\TrimPreprocessor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class TrimPreprocessorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TrimPreprocessor::class);
        $this->shouldImplement(Preprocessor::class);
    }

    public function it_should_trim_all_values()
    {
    	$this
		    ->process(['a' => ' a ', 'b' => 'b ', 'c' => ' c'])
		    ->shouldReturn(['a' => 'a', 'b' => 'b', 'c' => 'c']);
    }
}
