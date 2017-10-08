<?php

declare(strict_types = 1);

namespace Lunch\Domain;

final class PotentialPlace
{
	/**
	 * @var string
	 */
	private $name;

    private function __construct(string $name)
    {
    	$this->name = $name;
    }

    public static function withName($name): self
    {
	    return new PotentialPlace($name);
    }

    public function name(): string
    {
    	return $this->name;
    }

    public function equals(PotentialPlace $other): bool
    {
    	return $other->name === $this->name;
    }
}
