<?php

namespace Lunch\Component\Form;

class NullPreprocessor implements Preprocessor
{
	public function process(array $data): array
	{
		return $data;
	}
}
