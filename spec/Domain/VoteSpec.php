<?php

namespace spec\Lunch\Domain;

use Lunch\Domain\Participant;
use Lunch\Domain\PotentialPlace;
use Lunch\Domain\Vote;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Vote::class);
    }

    public function it_has_participant()
    {
    	$this->beConstructedThrough('for', [PotentialPlace::withName('Pasta'), Participant::withName('Josey')]);

    	$this->participant()->name()->shouldReturn('Josey');
    }

    public function it_has_potential_place()
    {
	    $this->beConstructedThrough('for', [PotentialPlace::withName('Pasta'), Participant::withName('Josey')]);

	    $this->potentialPlace()->name()->shouldReturn('Pasta');
    }
}