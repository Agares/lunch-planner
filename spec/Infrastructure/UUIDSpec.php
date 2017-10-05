<?php

namespace spec\Lunch\Infrastructure;

use Lunch\Infrastructure\UUID;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UUIDSpec extends ObjectBehavior
{
	const VALUE = '89a9476f-dfdf-4947-962a-91ec7d42c818';

	public function let()
	{
		$this->beConstructedWith(self::VALUE);
	}

    public function it_is_initializable()
    {
        $this->shouldHaveType(UUID::class);
        $this->shouldNotThrow()->duringInstantiation();
    }

    public function it_cannot_be_constructed_from_invalid_arguments()
    {
    	$this->beConstructedWith('invalid');
    	$this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_can_be_converted_to_string_representation()
    {
    	$this->__toString()->shouldReturn(self::VALUE);
    }

    public function it_normalizes_value_to_lowercase()
    {
    	$this->beConstructedWith(strtoupper(self::VALUE));

    	$this->__toString()->shouldReturn(self::VALUE);
    }
}
