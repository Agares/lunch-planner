<?php

declare(strict_types=1);

namespace Lunch\Component\Routing;

use Lunch\Component\Http\EndpointReference;
use Lunch\Component\Http\EndpointReferenceHandler;

final class RouteReferenceResolver implements EndpointReferenceHandler
{
	/**
	 * @var UrlGenerator
	 */
	private $urlGenerator;

	public function __construct(UrlGenerator $urlGenerator)
	{
		$this->urlGenerator = $urlGenerator;
	}

	public function handledType(): string
	{
		return RouteReference::class;
	}

	public function handle(EndpointReference $reference): string
	{
		assert($reference instanceof RouteReference);

		return $this->urlGenerator->generate($reference->routeName(), $reference->arguments());
	}
}