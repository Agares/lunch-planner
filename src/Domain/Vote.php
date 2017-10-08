<?php

declare(strict_types = 1);

namespace Lunch\Domain;

final class Vote
{
	/**
	 * @var PotentialPlace
	 */
	private $place;

	/**
	 * @var Participant
	 */
	private $participant;

	private function __construct(PotentialPlace $place, Participant $participant)
    {
	    $this->place = $place;
	    $this->participant = $participant;
    }

    public static function for(PotentialPlace $place, Participant $participant): self
    {
        return new Vote($place, $participant);
    }

    public function participant(): Participant
    {
    	return $this->participant;
    }

    public function potentialPlace(): PotentialPlace
    {
    	return $this->place;
    }

    public function equals(Vote $other): bool
    {
    	return $this->place->equals($other->place) && $this->participant->equals($other->participant);
    }
}
