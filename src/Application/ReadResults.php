<?php

declare(strict_types=1);

namespace Lunch\Application;

final class ReadResults
{
	/**
	 * @var string
	 */
	private $lunchId;

	public function __construct(string $lunchId)
	{
		$this->lunchId = $lunchId;
	}

	public function lunchId(): string
	{
		return $this->lunchId;
	}
}