<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

interface Form
{
	public function definition(): FormDefinition;
	public function submit(array $values): FormState;
}