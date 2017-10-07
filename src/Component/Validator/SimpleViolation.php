<?php

declare(strict_types=1);

namespace Lunch\Component\Validator;

final class SimpleViolation implements Violation
{
	/**
	 * @var string
	 */
	private $field;

	/**
	 * @var string
	 */
	private $message;

	public function __construct(string $field, string $message)
	{
		$this->field = $field;
		$this->message = $message;
	}

	public static function forField(string $field, string $message)
	{
		return new self($field, $message);
	}

	public function field(): string
	{
		return $this->field;
	}

	public function message(): string
	{
		return $this->message;
	}
}