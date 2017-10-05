<?php

declare(strict_types = 1);

namespace spec\Lunch\Application;

use Lunch\Application\AddPotentialPlace;
use Lunch\Application\AddPotentialPlaceHandler;
use Lunch\Application\Repository;
use Lunch\Domain\Lunch;
use Lunch\Infrastructure\CQRS\CommandHandler;
use Lunch\Infrastructure\UUID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class AddPotentialPlaceHandlerSpec extends ObjectBehavior
{
	public function let(Repository $repository)
	{
		$this->beConstructedWith($repository);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(AddPotentialPlaceHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_adds_potential_place(Repository $repository)
    {
	    $lunchId = 'bd0b1c35-2c65-4974-ab1a-17ca5ab92427';

	    $lunch = Lunch::withName('My Lunch', new UUID($lunchId));

	    $repository->findById(Argument::exact($lunchId))->willReturn($lunch);
	    $repository->save(Argument::type(Lunch::class))->shouldBeCalled();

	    $this->beConstructedWith($repository);

	    $this->handle(new AddPotentialPlace($lunchId, 'Some mexican place'));

	    if($lunch->potentialPlaces()[0]->name() !== 'Some mexican place') {
	    	throw new \RuntimeException('Potential place was not added correctly');
	    }
    }
}
