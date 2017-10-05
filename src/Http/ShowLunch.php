<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Infrastructure\Http\ResponseFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class ShowLunch
{
	/**
	 * @var ResponseFactory
	 */
	private $responseFactory;

	public function __construct(ResponseFactory $responseFactory)
	{
		$this->responseFactory = $responseFactory;
	}

	public function handle(RequestInterface $request, $id): ResponseInterface
	{
		return $this->responseFactory->html($request->getUri() . ' ' . $id);
	}
}