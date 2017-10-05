<?php

declare(strict_types = 1);

namespace spec\Lunch\Application;

use Lunch\Application\AddParticipant;
use Lunch\Application\AddParticipantHandler;
use Lunch\Application\Repository;
use Lunch\Domain\Lunch;
use Lunch\Infrastructure\UUID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class AddParticipantHandlerSpec extends ObjectBehavior
{
	public function let(Repository $repository)
	{
		$this->beConstructedWith($repository);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(AddParticipantHandler::class);
    }

    public function it_adds_a_participant(Repository $repository)
    {
	    $lunchId = 'bd0b1c35-2c65-4974-ab1a-17ca5ab92427';

	    $lunch = Lunch::withName('My Lunch', new UUID($lunchId));

	    $repository->findById(Argument::exact($lunchId))->willReturn($lunch);
	    $repository->save(Argument::type(Lunch::class))->shouldBeCalled();

	    $this->beConstructedWith($repository);

	    $this->handle(new AddParticipant($lunchId, 'Josey'));

	    if($lunch->participants()[0]->name() !== 'Josey') {
	    	throw new \RuntimeException('Participant was not added');
	    }
    }
}
