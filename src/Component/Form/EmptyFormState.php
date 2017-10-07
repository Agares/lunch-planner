<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\Validator\ValidationResult;

final class EmptyFormState implements FormState
{
	public function data(): array
	{
		return [];
	}

	public function validationResult(): ValidationResult
	{
		return new ValidationResult([]);
	}
}