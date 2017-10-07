<?php

declare(strict_types=1);

namespace Lunch\Component\Validator;

interface Validator
{
    public function validate(array $data): ValidationResult;
}
