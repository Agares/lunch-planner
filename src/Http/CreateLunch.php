<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Form;
use Lunch\Component\Routing\RouteReference;
use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateLunch extends CQRSHandler
{
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$formDefinition = new \Lunch\Http\Form\CreateLunch();
		$form = new Form($formDefinition);

		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			$renderedForm = $this->formViewFactory()->createView($formDefinition, $formState);

			$layout = new Layout($renderedForm);

			return $this->response()->html($this->viewRenderer()->render($layout));
		}

		$lunchId = (string)$this->uuidFactory()->generateRandom();
		$this->commandBus()->execute(new \Lunch\Application\CreateLunch($lunchId, $formState->data()['lunch_name']));

		return $this->response()->redirect(new RouteReference('lunch.show', [$lunchId]));
	}
}