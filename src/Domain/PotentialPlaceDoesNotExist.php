<?php

declare(strict_types=1);

namespace Lunch\Domain;

final class PotentialPlaceDoesNotExist extends \RuntimeException
{
	public function __construct(string $placeName)
	{
		parent::__construct(sprintf('Potential place "%s" does not exist', $placeName));
	}
}