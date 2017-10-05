<?php

namespace spec\Lunch\Domain;

use Lunch\Domain\Participant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParticipantSpec extends ObjectBehavior
{
	public function let()
	{
		$this->beConstructedThrough('withName', ['Josey']);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(Participant::class);
    }

    public function it_can_have_name()
    {
	    $this->name()->shouldReturn('Josey');
    }

    public function it_can_be_compared_to_equal()
    {
    	$this->equals(Participant::withName('Josey'))->shouldReturn(true);
    }

    public function it_can_be_compared_to_unequal()
    {
    	$this->equals(Participant::withName('Jackie'))->shouldReturn(false);
    }
}
