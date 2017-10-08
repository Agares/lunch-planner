<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Form\Form;
use Lunch\Component\Routing\RouteReference;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddParticipant extends CQRSHandler
{
	public function handle(ServerRequestInterface $request, string $id): ResponseInterface
	{
		// todo validate if $id is empty
		$formDefinition = new \Lunch\Http\Form\AddParticipant($id);
		$form = new Form($formDefinition);
		$formState = $form->submit($request->getParsedBody());

		if(!$formState->validationResult()->isValid()) {
			$renderedForm = $this->formRenderer()->render($formDefinition, $formState);
			$formInLayout = $this->templateRenderer()->render('single_form', ['form' => $renderedForm]);

			return $this->response()->html($formInLayout);
		}
		$this->commandBus()->execute(new \Lunch\Application\AddParticipant($id, $request->getParsedBody()['name']));

		return $this->response()->redirect(new RouteReference('lunch.show', [$id]));
	}
}