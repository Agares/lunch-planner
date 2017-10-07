<?php

declare(strict_types=1);

namespace Lunch\Component\Validator;

interface Violation
{
	public function field(): string;
	public function message(): string;
}