<?php

declare(strict_types = 1);

namespace Lunch\Infrastructure;

use Lunch\Domain\Identifier;

final class UUID implements Identifier
{
	/**
	 * @var string
	 */
	private $value;

	public function __construct(string $value)
    {
	    if (!preg_match('/^[a-f0-9]{8}\-([a-f0-9]{4}\-){3}[a-f0-9]{12}$/i', $value)) {
		    throw new \InvalidArgumentException(sprintf('Invalid UUID: "%s', $value));
	    }

	    $this->value = strtolower($value);
    }

    public function __toString(): string
    {
    	return $this->value;
    }
}
