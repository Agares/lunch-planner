<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

use Lunch\Component\Http\EndpointReferenceResolver;
use Lunch\Infrastructure\TemplateRenderer;

final class Renderer
{
	/**
	 * @var TemplateRenderer
	 */
	private $renderer;

	/**
	 * @var EndpointReferenceResolver
	 */
	private $endpointReferenceResolver;

	public function __construct(TemplateRenderer $renderer, EndpointReferenceResolver $endpointReferenceResolver)
    {
	    $this->renderer = $renderer;
	    $this->endpointReferenceResolver = $endpointReferenceResolver;
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
		    'action' => $this->endpointReferenceResolver->resolve($definition->action())
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
