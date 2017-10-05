<?php

declare(strict_types=1);

namespace spec\Lunch\Infrastructure\CQRS;

final class MockHandler
{
	/**
	 * @var boolean
	 */
	private $wasExecuted = false;

	public function handle(MockCommandA $command)
	{
		$this->wasExecuted = true;
	}

	public function wasExecuted()
	{
		return $this->wasExecuted;
	}
}