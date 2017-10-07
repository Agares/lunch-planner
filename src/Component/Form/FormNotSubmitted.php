<?php

declare(strict_types=1);

namespace Lunch\Component\Form;

final class FormNotSubmitted extends \RuntimeException
{
	public function __construct()
	{
		parent::__construct('The form was not submitted');
	}
}