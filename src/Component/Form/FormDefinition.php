<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\Validator\Validator;

interface FormDefinition
{
	public function name(): string;
	public function action(): string;

    public function validator(): Validator;
    public function preprocessor(): Preprocessor;
}
