<?php

declare(strict_types = 1);

namespace Lunch\Component\Form;

use Lunch\Component\Http\EndpointReferenceResolver;
use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\View;
use Lunch\Infrastructure\TemplateRenderer;

final class ViewFactory
{
	/**
	 * @var EndpointReferenceResolver
	 */
	private $endpointReferenceResolver;

	public function __construct(EndpointReferenceResolver $endpointReferenceResolver)
    {
	    $this->endpointReferenceResolver = $endpointReferenceResolver;
    }

    public function createView(FormDefinition $definition, FormState $state = null): View
    {
    	if($state === null) {
    		$state = new EmptyFormState();
	    }

	    return new FormView([
	    	'values' => $state->data(),
		    'validationMessages' => $this->formatValidationMessages($state),
		    'action' => $this->endpointReferenceResolver->resolve($definition->action())
	    ], new FilesystemTemplateReference(sprintf('form/%s', $definition->name())));
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
