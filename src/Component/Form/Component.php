<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

final class Component implements \Lunch\Component\Kernel\Component
{
	public function services(): array
	{
		return [];
	}

	public function dependencies(): array
	{
		return [
			\Lunch\Component\Validator\Component::class,
			\Lunch\Component\Http\Component::class,
		];
	}
}