<?php

declare(strict_types=1);

namespace Lunch\Application;

final class AddParticipant
{
	/**
	 * @var string
	 */
	private $lunchId;

	/**
	 * @var string
	 */
	private $name;

	public function __construct(string $lunchId, string $name)
	{
		$this->lunchId = $lunchId;
		$this->name = $name;
	}

	public function lunchId(): string
	{
		return $this->lunchId;
	}

	public function name(): string
	{
		return $this->name;
	}
}