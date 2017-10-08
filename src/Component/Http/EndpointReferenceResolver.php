<?php

declare(strict_types = 1);

namespace Lunch\Component\Http;

interface EndpointReferenceResolver
{
	public function resolve(EndpointReference $endpointReference): string;
}