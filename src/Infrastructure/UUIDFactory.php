<?php

declare(strict_types = 1);

namespace Lunch\Infrastructure;

use Lunch\Domain\Identifier;

final class UUIDFactory
{
    public function generateRandom(): Identifier
    {
    	return new UUID(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }
}
