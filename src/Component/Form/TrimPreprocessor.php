<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

final class TrimPreprocessor implements Preprocessor
{
	public function process(array $data): array
	{
		return array_map('trim', $data);
	}
}
