<?php

declare(strict_types = 1);

namespace spec\Lunch\Application;

use Lunch\Application\RemoveVote;
use Lunch\Application\RemoveVoteHandler;
use Lunch\Application\Repository;
use Lunch\Domain\Lunch;
use Lunch\Domain\Participant;
use Lunch\Domain\PotentialPlace;
use Lunch\Infrastructure\CQRS\CommandHandler;
use Lunch\Infrastructure\UUID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class RemoveVoteHandlerSpec extends ObjectBehavior
{
	const LUNCH_ID = 'd5d30d4f-51d8-47f9-8cfc-fa14367ee008';
	const PARTICIPANT_NAME = 'Josey';
	const PLACE_NAME = 'Mexican';

	public function let(Repository $repository)
	{
		$lunch = $this->createLunchWithVote();

		$repository->findById(Argument::any())->willReturn($lunch);

		$this->beConstructedWith($repository);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(RemoveVoteHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_remove_vote()
    {
    	$this->handledType()->shouldReturn(RemoveVote::class);
    }

    public function it_removes_vote(Repository $repository)
    {
    	$lunch = $this->createLunchWithVote();
    	$repository->findById(Argument::any())->willReturn($lunch)->shouldBeCalled();
    	$repository->save(Argument::type(Lunch::class))->shouldBeCalled();

		$this->handle(new RemoveVote(self::LUNCH_ID, self::PARTICIPANT_NAME, self::PLACE_NAME));

		if(count($lunch->votes()) !== 0) {
			throw new \RuntimeException('Lunch vote was not removed');
		}
    }

	/**
	 * @return Lunch
	 */
	private function createLunchWithVote(): Lunch
	{
		$lunch = Lunch::withName('Some lunch', new UUID(self::LUNCH_ID));
		$lunch->addParticipant(Participant::withName(self::PARTICIPANT_NAME));
		$lunch->addPotentialPlace(PotentialPlace::withName(self::PLACE_NAME));

		$lunch->vote(self::PARTICIPANT_NAME, self::PLACE_NAME);

		return $lunch;
	}
}
