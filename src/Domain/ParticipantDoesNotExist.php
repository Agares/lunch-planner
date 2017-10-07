<?php

declare(strict_types=1);

namespace Lunch\Domain;

final class ParticipantDoesNotExist extends \RuntimeException
{
	public function __construct(string $participantName)
	{
		parent::__construct(sprintf('Participant named "%s" does not exist', $participantName));
	}
}