<?php

namespace spec\Lunch\Domain;

use Lunch\Domain\Identifiable;
use Lunch\Domain\Lunch;
use Lunch\Domain\Participant;
use Lunch\Domain\ParticipantDoesNotExist;
use Lunch\Domain\PotentialPlace;
use Lunch\Domain\PotentialPlaceDoesNotExist;
use Lunch\Domain\Vote;
use Lunch\Infrastructure\UUIDFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LunchSpec extends ObjectBehavior
{
	public function let()
	{
		$id = (new UUIDFactory())->generateRandom();
		$this->beConstructedThrough('withName', ['Lunch 2017-10-03', $id]);
	}

	public function it_is_initializable()
	{
		$this->shouldHaveType(Lunch::class);
	}

	public function it_is_identifiable()
	{
		$this->shouldBeAnInstanceOf(Identifiable::class);
	}

	public function it_has_no_participants_after_creating()
	{
		$this->participants()->shouldReturn([]);
	}

	public function it_has_no_potential_places_after_creating()
	{
		$this->potentialPlaces()->shouldReturn([]);
	}

	public function it_can_add_participant()
	{
		$participant = Participant::withName('Josey');

		$this->addParticipant($participant);

		$this->participants()->shouldReturn([$participant]);
	}

	public function it_can_add_potential_place()
	{
		$place = PotentialPlace::withName('Pasta');

		$this->addPotentialPlace($place);

		$this->potentialPlaces()->shouldReturn([$place]);
	}

	public function it_can_accept_a_single_vote_for_place()
	{
		$potentialPlaceA = PotentialPlace::withName('Pasta');
		$potentialPlaceB = PotentialPlace::withName('Some mexican place');

		$participantA = Participant::withName('Josey');
		$participantB = Participant::withName('Alice');

		$this->addPotentialPlace($potentialPlaceA);
		$this->addPotentialPlace($potentialPlaceB);

		$this->addParticipant($participantA);
		$this->addParticipant($participantB);

		$this->vote('Josey', 'Pasta');
		$this->vote('Josey', 'Pasta');

		$this->vote('Alice', 'Pasta');

		$votes = $this->votes();
		$votes->shouldHaveCount(2);
		$votes[0]->equals(Vote::for($potentialPlaceA, $participantA))->shouldReturn(true);
		$votes[1]->equals(Vote::for($potentialPlaceA, $participantB))->shouldReturn(true);
	}

	public function it_has_name()
	{
		$this->name()->shouldReturn('Lunch 2017-10-03');
	}

	public function it_throws_when_voting_on_not_existant_potential_place()
	{
		$this->addParticipant(Participant::withName('Josey'));

		$this->shouldThrow(PotentialPlaceDoesNotExist::class)->during('vote', ['Josey', 'Mexican place']);
	}

	public function it_throws_when_voting_by_a_participant_that_does_not_exist()
	{
		$this->addPotentialPlace(PotentialPlace::withName('test'));

		$this->shouldThrow(ParticipantDoesNotExist::class)->during('vote', ['Josey', 'test']);
	}
}
