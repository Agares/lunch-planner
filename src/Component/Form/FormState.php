<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\Validator\ValidationResult;

interface FormState
{
    public function data(): array;
    public function validationResult(): ValidationResult;
}
