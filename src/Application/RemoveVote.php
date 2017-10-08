<?php

declare(strict_types=1);

namespace Lunch\Application;

final class RemoveVote
{
	/**
	 * @var string
	 */
	private $lunchId;

	/**
	 * @var string
	 */
	private $participant;

	/**
	 * @var string
	 */
	private $place;

	public function __construct(string $lunchId, string $participant, string $place)
	{
		$this->lunchId = $lunchId;
		$this->participant = $participant;
		$this->place = $place;
	}

	public function lunchId(): string
	{
		return $this->lunchId;
	}

	public function participant(): string
	{
		return $this->participant;
	}

	public function place(): string
	{
		return $this->place;
	}
}