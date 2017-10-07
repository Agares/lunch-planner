<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

use Lunch\Component\Validator\ValidationResult;
use Lunch\Component\Validator\Validator;

final class SimpleForm
{
	/**
	 * @var FormDefinition
	 */
	private $definition;

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @var ValidationResult
	 */
	private $validationResult;

	/**
	 * @var bool
	 */
	private $isSubmitted = false;

	/**
	 * @var Preprocessor
	 */
	private $preprocessor;

	/**
	 * @var Validator
	 */
	private $validator;

	public function __construct(FormDefinition $definition)
    {
	    $this->definition = $definition;

	    $this->preprocessor = $definition->preprocessor();
	    $this->validator = $definition->validator();
    }

    public function submit(array $data): FormState
    {
    	$this->data = $this->preprocessor->process($data);
    	$this->isSubmitted = true;

    	$this->validate();

    	return new SimpleFormState($this->data, $this->validationResult);
    }

	private function validate(): void
	{
		$this->validationResult = $this->validator->validate($this->data);
	}

	public function definition(): FormDefinition
	{
		return $this->definition;
	}
}
