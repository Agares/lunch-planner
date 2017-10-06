<?php

declare(strict_types=1);

namespace Lunch\Application;

final class Vote
{
	/**
	 * @var string
	 */
	private $lunchId;

	/**
	 * @var string
	 */
	private $participantName;

	/**
	 * @var string
	 */
	private $placeName;

	public function __construct(string $lunchId, string $participantName, string $placeName)
	{
		$this->lunchId = $lunchId;
		$this->participantName = $participantName;
		$this->placeName = $placeName;
	}

	public function lunchId(): string
	{
		return $this->lunchId;
	}

	public function participantName(): string
	{
		return $this->participantName;
	}

	public function placeName(): string
	{
		return $this->placeName;
	}
}