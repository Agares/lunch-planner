<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

use Lunch\Infrastructure\TemplateRenderer;

final class Renderer
{
	/**
	 * @var TemplateRenderer
	 */
	private $renderer;

	public function __construct(TemplateRenderer $renderer)
    {
	    $this->renderer = $renderer;
    }

    public function render(FormDefinition $definition, FormState $state = null): string
    {
    	if($state === null) {
    		$state = new EmptyFormState();
	    }

	    $templateName = sprintf('form/%s', $definition->name());

	    return $this->renderer->render($templateName, [
	    	'values' => $state->data(),
	        'validationMessages' => $this->formatValidationMessages($state),
		    'action' => $definition->action()
	    ]);
    }

	private function formatValidationMessages(FormState $form): array
	{
		$messages = [];

		foreach($form->validationResult()->violations() as $violation) {
			$messages[$violation->field()] = $violation->message();
		}

		return $messages;
	}
}
