<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\CQRS;

interface CommandHandler
{
	public function handle($command): void;

    public function handledType(): string;
}
