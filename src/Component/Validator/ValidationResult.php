<?php

declare(strict_types=1);

namespace Lunch\Component\Validator;

final class ValidationResult
{
	/**
	 * @var Violation[]
	 */
	private $violations;

	public function __construct(array $violations)
	{
		$this->violations = $violations;
	}

	/**
	 * @return Violation[]
	 */
	public function violations(): array
	{
		return $this->violations;
	}

	public function isValid(): bool
	{
		return count($this->violations) === 0;
	}
}