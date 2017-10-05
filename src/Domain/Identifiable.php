<?php

declare(strict_types=1);

namespace Lunch\Domain;

interface Identifiable
{
	public function getId(): Identifier;
}