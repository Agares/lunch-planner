<?php

declare(strict_types=1);

namespace Lunch\Http\Form;

use Lunch\Component\Form\FormDefinition;
use Lunch\Component\Form\Preprocessor;
use Lunch\Component\Form\TrimPreprocessor;
use Lunch\Component\Validator\SimpleViolation;
use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Validator;
use Lunch\Infrastructure\Http\UrlGenerator;

final class CreateLunch implements FormDefinition
{
	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;

	public function __construct(UrlGenerator $urlGenerator)
	{
		$this->urlGenerator = $urlGenerator;
	}

	public function name(): string
	{
		return 'create_lunch';
	}

	public function action(): string
	{
		return $this->urlGenerator->generate('lunch.create');
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