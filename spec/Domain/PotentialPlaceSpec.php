<?php

namespace spec\Lunch\Domain;

use Lunch\Domain\PotentialPlace;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PotentialPlaceSpec extends ObjectBehavior
{
	public function let()
	{
		$this->beConstructedThrough('withName', ['Pasta']);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(PotentialPlace::class);
    }

    public function it_has_name()
    {
    	$this->name()->shouldReturn('Pasta');
    }

    public function it_can_be_compared_to_equal()
    {
		$this->equals(PotentialPlace::withName('Pasta'))->shouldReturn(true);
    }

    public function it_can_be_compared_to_unequal()
    {
    	$this->equals(PotentialPlace::withName('Gemuese'))->shouldReturn(false);
    }
}
