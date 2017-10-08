<?php

declare(strict_types=1);

namespace Lunch\Http;

use Psr\Http\Message\ResponseInterface;

final class Homepage extends CQRSHandler
{
	public function handle(): ResponseInterface
	{
		$formDefinition = new Form\CreateLunch();
		$form = $this->formRenderer()->render($formDefinition);

		return $this->response()->html($this->templateRenderer()->render('home', ['form' => $form]));
	}
}