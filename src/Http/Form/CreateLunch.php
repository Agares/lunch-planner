<?php

declare(strict_types=1);

namespace Lunch\Http\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\Preprocessor;
use Lunch\Component\Form\TrimPreprocessor;
use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Routing\RouteReference;
use Lunch\Component\Validator\SimpleViolation;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Validator;

final class CreateLunch implements FormDefinition
{
	public function name(): string
	{
		return 'create_lunch';
	}

	public function action(): EndpointReference
	{
		return new RouteReference('lunch.create');
	}

	public function validator(): Validator
	{
		// todo make a real abstraction for validator
		return new class implements Validator {
			public function validate(array $data): ValidationResult
			{
				$violations = [];

				if(!isset($data['lunch_name']) || $data['lunch_name'] === '') {
					$violations[] = SimpleViolation::forField('lunch_name', 'Must not be empty');
				}

				return new ValidationResult($violations);
			}
		};
	}

	public function preprocessor(): Preprocessor
	{
		return new TrimPreprocessor();
	}
}