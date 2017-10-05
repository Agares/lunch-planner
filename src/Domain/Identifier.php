<?php

declare(strict_types=1);

namespace Lunch\Domain;

interface Identifier
{
	public function __toString();
}