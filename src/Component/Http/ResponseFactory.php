<?php

declare(strict_types=1);

namespace Lunch\Component\Http;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

final class ResponseFactory
{
	/**
	 * @var DefaultEndpointReferenceResolver
	 */
	private $endpointReferenceResolver;

	public function __construct(DefaultEndpointReferenceResolver $endpointReferenceResolver)
	{
		$this->endpointReferenceResolver = $endpointReferenceResolver;
	}

	public function html(string $content, int $responseCode = 200): ResponseInterface
	{
		return new HtmlResponse($content, $responseCode);
	}

	// todo use an EndpointReference here, instead of a path
	public function redirect(EndpointReference $targetReference, int $responseCode = 302): ResponseInterface
	{
		$targetPath = $this->endpointReferenceResolver->resolve($targetReference);

		return new RedirectResponse($targetPath, $responseCode);
	}
}