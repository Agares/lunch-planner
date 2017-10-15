<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class FormView implements View
{
	/**
	 * @var array
	 */
	private $viewData;

	/**
	 * @var TemplateReference
	 */
	private $template;

	public function __construct(FormDefinition $definition, ?FormState $state = null)
	{
		if($state === null) {
			$state = new EmptyFormState();
		}

		$this->viewData = [
			'values' => $state->data(),
			'validationMessages' => $this->formatValidationMessages($state),
			'action' => $definition->action()
		];

		$this->template = new FilesystemTemplateReference(sprintf('form/%s', $definition->name()));
	}

	private function formatValidationMessages(FormState $form): array
	{
		$messages = [];

		foreach($form->validationResult()->violations() as $violation) {
			$messages[$violation->field()] = $violation->message();
		}

		return $messages;
	}

	public function getViewData(): array
	{
		return $this->viewData;
	}

	public function getTemplate(): TemplateReference
	{
		return $this->template;
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [];
	}
}