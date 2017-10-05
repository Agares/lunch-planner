<?php

declare(strict_types=1);

namespace Lunch\Infrastructure\Http;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

final class ResponseFactory
{
	public function html(string $content, int $responseCode = 200): ResponseInterface
	{
		return new HtmlResponse($content, $responseCode);
	}

	public function redirect(string $targetPath, int $responseCode = 302): ResponseInterface
	{
		return new RedirectResponse($targetPath, $responseCode);
	}
}