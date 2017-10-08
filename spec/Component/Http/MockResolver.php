<?php

declare(strict_types=1);

namespace spec\Lunch\Component\Http;

use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\EndpointReferenceHandler;

final class MockResolver implements EndpointReferenceHandler
{
	public function handledType(): string
	{
		return MockEndpointReference::class;
	}

	public function handle(EndpointReference $reference): string
	{
		return 'I_AM_RESOLVED';
	}
}