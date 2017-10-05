<?php

declare(strict_types = 1);

namespace spec\Lunch\Application;

use Lunch\Application\CreateLunch;
use Lunch\Application\CreateLunchHandler;
use Lunch\Application\Repository;
use Lunch\Domain\Lunch;
use Lunch\Infrastructure\CQRS\CommandHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class CreateLunchHandlerSpec extends ObjectBehavior
{
	public function let(Repository $repository)
	{
		$this->beConstructedWith($repository);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(CreateLunchHandler::class);
        $this->shouldImplement(CommandHandler::class);
    }

    public function it_handles_create_lunch()
    {
    	$this->handledType()->shouldReturn(CreateLunch::class);
    }

    public function it_creates_lunch(Repository $repository)
    {
    	$this->beConstructedWith($repository);

		$repository->save(Argument::type(Lunch::class))->shouldBeCalled();

		$this->handle(new CreateLunch('c8d5ee62-de85-4a68-b598-f9acd14f41b7', 'Our awesome lunch!'));
    }
}
