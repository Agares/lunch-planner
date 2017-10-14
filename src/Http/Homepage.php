<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;

final class Homepage extends CQRSHandler
{
	public function handle(): ResponseInterface
	{
		$formDefinition = new Form\CreateLunch();
		$formView = $this->formViewFactory()->createView($formDefinition);
		$layout = new Layout(new View\Homepage($formView));

		return $this->response()->html($this->viewRenderer()->render($layout));
	}
}