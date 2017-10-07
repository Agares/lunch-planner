<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\Validator\ValidationResult;

final class SimpleFormState implements FormState
{
	/**
	 * @var array
	 */
	private $values;

	/**
	 * @var ValidationResult
	 */
	private $validationResult;

	public function __construct(array $values, ValidationResult $validationResult)
	{
		$this->values = $values;
		$this->validationResult = $validationResult;
	}

	public function data(): array
	{
		return $this->values;
	}

    public function validationResult(): ValidationResult
    {
    	return $this->validationResult;
    }
}