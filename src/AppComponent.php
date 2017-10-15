<?php

declare(strict_types=1);

namespace Lunch;

use Lunch\Component\Kernel\Component;

final class AppComponent implements Component
{
	public function services(): array
	{
		return require __DIR__.'/../config/services.php';
	}

	public function dependencies(): array
	{
		return [
			\Lunch\Component\Form\Component::class,
			\Lunch\Component\Http\Component::class,
			\Lunch\Component\Routing\Component::class,
			\Lunch\Component\Validator\Component::class,
			\Lunch\Component\View\Component::class,
		];
	}
}