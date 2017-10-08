<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

final class NullPreprocessor implements Preprocessor
{
	public function process(array $data): array
	{
		return $data;
	}
}
