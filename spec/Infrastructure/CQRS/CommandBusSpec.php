<?php

declare(strict_types = 1);

namespace spec\Lunch\Infrastructure\CQRS;

use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\CQRS\CommandHandler;
use Lunch\Infrastructure\CQRS\CommandHandlerNotFound;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class CommandBusSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandBus::class);
    }

    public function it_can_execute_for_single_handler(CommandHandler $handler)
    {
	    $handler->handle(Argument::type(MockCommandA::class))->shouldBeCalled();
	    $handler->handledType()->willReturn(MockCommandA::class);

	    $this->registerHandler($handler);

    	$this->shouldNotThrow()->during('execute', [new MockCommandA()]);
    }

	public function it_can_choose_from_multiple_handlers(CommandHandler $handlerA, CommandHandler $handlerB)
	{
		$handlerA->handle(Argument::type(MockCommandA::class))->shouldBeCalled();
		$handlerA->handledType()->willReturn(MockCommandA::class);

		$handlerB->handle(Argument::type(MockCommandB::class))->shouldNotBeCalled();
		$handlerB->handledType()->willReturn(MockCommandB::class);

		$this->registerHandler($handlerA);
		$this->registerHandler($handlerB);

		$this->shouldNotThrow()->during('execute', [new MockCommandA()]);
	}

	public function it_throws_if_there_is_no_handler_for_command()
	{
		$this->shouldThrow(CommandHandlerNotFound::class)->during('execute', [new MockCommandA()]);
	}
}
