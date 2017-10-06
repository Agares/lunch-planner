<?php

declare(strict_types = 1);

namespace spec\Lunch\Application;

use Lunch\Application\Repository;
use Lunch\Application\Vote;
use Lunch\Application\VoteHandler;
use Lunch\Domain\Lunch;
use Lunch\Domain\Participant;
use Lunch\Domain\PotentialPlace;
use Lunch\Infrastructure\UUID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoteHandlerSpec extends ObjectBehavior
{
	public function let(Repository $repository)
	{
		$this->beConstructedWith($repository);
	}

	public function it_is_initializable()
	{
		$this->shouldHaveType(VoteHandler::class);
	}

	public function it_votes_for_lunch(Repository $repository)
	{
		$lunchId = 'c8d5ee62-de85-4a68-b598-f9acd14f41b7';
		$lunch = Lunch::withName('The lunch', new UUID($lunchId));

		$lunch->addPotentialPlace(PotentialPlace::withName('Test'));
		$lunch->addParticipant(Participant::withName('Josey'));

		$repository->findById(Argument::exact($lunchId))->willReturn($lunch);
		$repository->save(Argument::exact($lunch))->shouldBeCalled();

		$this->handle(new Vote($lunchId, 'Josey', 'Test'));

		/** @var \Lunch\Domain\Vote $vote */
		$vote = $lunch->votes()[0];
		if($vote->participant()->name() !== 'Josey' || $vote->potentialPlace()->name() !== 'Test') {
			throw new \RuntimeException('Invalid vote');
		}
	}
}