<?php

declare(strict_types = 1);

namespace spec\Lunch\Infrastructure\CQRS;

use Lunch\Infrastructure\CQRS\QueryBus;
use Lunch\Infrastructure\CQRS\QueryHandler;
use Lunch\Infrastructure\CQRS\QueryHandlerNotFound;
use MongoDB\Driver\Query;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class QueryBusSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(QueryBus::class);
    }

    public function it_can_execute_a_simple_query(QueryHandler $queryHandler)
    {
    	$queryHandler->handle(Argument::type(MockQueryA::class))->willReturn('CAFEBABE');
    	$queryHandler->handledType()->willReturn(MockQueryA::class);

    	$this->registerHandler($queryHandler);

    	$this->handle(new MockQueryA())->shouldReturn('CAFEBABE');
    }

    public function it_can_choose_correct_handler(QueryHandler $queryHandlerA, QueryHandler $queryHandlerB)
    {
    	$queryHandlerA->handle(Argument::type(MockQueryA::class))->willReturn('Something random');
    	$queryHandlerA->handledType()->willReturn(MockQueryA::class);

    	$queryHandlerB->handle(Argument::type(MockQueryB::class))->willReturn('CAFEBABE');
    	$queryHandlerB->handledType()->willReturn(MockQueryB::class);

    	$this->registerHandler($queryHandlerA);
    	$this->registerHandler($queryHandlerB);

    	$this->handle(new MockQueryB())->shouldReturn('CAFEBABE');
    }

    public function it_will_throw_if_there_is_no_handler()
    {
    	$this->shouldThrow(QueryHandlerNotFound::class)->during('handle', [new MockQueryA()]);
    }
}
