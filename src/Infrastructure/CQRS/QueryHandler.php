<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\CQRS;

interface QueryHandler
{
    public function handle($query);
    public function handledType(): string;
}
