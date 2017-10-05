<?php

namespace spec\Lunch\Infrastructure;

use Lunch\Domain\Identifier;
use Lunch\Infrastructure\UUIDFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UUIDFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(UUIDFactory::class);
    }

    public function it_returns_identifiers()
    {
    	$this->generateRandom()->shouldReturnAnInstanceOf(Identifier::class);
    }
}
