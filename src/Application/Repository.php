<?php

declare(strict_types=1);

namespace Lunch\Application;

use Lunch\Domain\Lunch;

interface Repository
{
    public function save(Lunch $lunch): void;
    public function findById(string $id): Lunch;
}
