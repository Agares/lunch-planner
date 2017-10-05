<?php

declare(strict_types = 1);

namespace Lunch\Application;

final class CreateLunch
{
	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	public function __construct(string $id, string $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	public function id(): string
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}
}
