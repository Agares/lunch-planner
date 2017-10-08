<?php

declare(strict_types = 1);

namespace Lunch\Domain;

final class Participant
{
	/**
	 * @var string
	 */
	private $name;

    private function __construct(string $name)
    {
    	$this->name = $name;
    }

    public static function withName(string $name): self
    {
	    return new Participant($name);
    }

    public function name(): string
    {
    	return $this->name;
    }

    public function equals(Participant $other): bool
    {
    	return $other->name === $this->name;
    }
}
