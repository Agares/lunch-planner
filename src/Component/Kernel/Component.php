<?php

declare(strict_types=1);

namespace Lunch\Component\Kernel;

interface Component
{
	public function services() : array;
	public function dependencies(): array;
}