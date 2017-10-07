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

final class AddPotentialPlace implements FormDefinition
{
	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;
	/**
	 * @var string
	 */
	private $lunchId;

	public function __construct(UrlGenerator $urlGenerator, string $lunchId)
	{
		$this->urlGenerator = $urlGenerator;
		$this->lunchId = $lunchId;
	}

	public function name(): string
	{
		return 'add_potential_place';
	}

	public function action(): string
	{
		return $this->urlGenerator->generate('lunch.potential_places.add', [$this->lunchId]);
	}

	public function validator(): Validator
	{
		return new class implements Validator {
			public function validate(array $data): ValidationResult
			{
				$violations = [];

				if(!isset($data['name']) || $data['name'] === '') {
					$violations[] = SimpleViolation::forField('name', 'Must not be empty');
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