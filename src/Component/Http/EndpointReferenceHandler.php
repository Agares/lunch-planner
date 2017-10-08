<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

interface EndpointReferenceHandler
{
	public function handledType(): string;
	public function handle(EndpointReference $reference): string;
}