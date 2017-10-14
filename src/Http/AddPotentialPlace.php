<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Form;
use Lunch\Component\Routing\RouteReference;
use Lunch\Http\View\Layout;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddPotentialPlace extends CQRSHandler
{
	public function handle(ServerRequestInterface $request, string $id): ResponseInterface
	{
		// todo validate if $id is not empty?
		$formDefinition = new \Lunch\Http\Form\AddPotentialPlace($id);
		$form = new Form($formDefinition);
		$formState = $form->submit($request->getParsedBody());


		if(!$formState->validationResult()->isValid()) {
			$renderedForm = $this->formViewFactory()->createView($formDefinition, $formState);
			$layout = new Layout($renderedForm);

			return $this->response()->html($this->viewRenderer()->render($layout));
		}

		$this->commandBus()->execute(new \Lunch\Application\AddPotentialPlace($id, $request->getParsedBody()['name']));

		return $this->response()->redirect(new RouteReference('lunch.show', [$id]));
	}
}