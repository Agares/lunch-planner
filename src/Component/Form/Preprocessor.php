<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

interface Preprocessor
{
    public function process(array $data): array;
}
