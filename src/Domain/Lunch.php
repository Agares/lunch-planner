<?php

namespace Lunch\Domain;

final class Lunch implements Identifiable
{
	/**
	 * @var Identifier
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var Participant[]
	 */
	private $participants = [];

	/**
	 * @var PotentialPlace[]
	 */
	private $potentialPlaces = [];

	/**
	 * @var Vote[]
	 */
	private $votes = [];

	private function __construct(Identifier $id, string $name)
    {
    	$this->id = $id;
	    $this->name = $name;
    }

    public static function withName(string $name, Identifier $id): self
    {
        return new Lunch($id, $name);
    }

	public function addParticipant(Participant $participant): void
    {
    	$this->participants[$participant->name()] = $participant;
    }

	public function addPotentialPlace(PotentialPlace $place): void
    {
    	$this->potentialPlaces[$place->name()] = $place;
    }

	/**
	 * @return Participant[]
	 */
	public function participants(): array
	{
		return array_values($this->participants);
	}

	/**
	 * @return PotentialPlace[]
	 */
	public function potentialPlaces(): array
	{
		return array_values($this->potentialPlaces);
	}

    public function vote(string $participant, string $place): void
    {
	    $this->assertPotentialPlaceExists($place);
	    $this->assertParticipantExists($participant);

	    if($this->voteExists($participant, $place)) {
	    	return;
	    }

    	$this->votes[] = Vote::for(
    		$this->potentialPlaces[$place],
		    $this->participants[$participant]
	    );
    }

    public function votes(): array
    {
    	return $this->votes;
    }

    public function name(): string
    {
    	return $this->name;
    }

	public function removeVote(string $participant, string $place): void
	{
		$this->votes = array_filter($this->votes, function (Vote $vote) use ($participant, $place) {
			return $vote->participant()->name() !== $participant && $vote->potentialPlace()->name() !== $place;
		});
	}

	public function id(): Identifier
	{
		return $this->id;
	}

	private function voteExists(string $participant, string $place): bool
	{
		foreach($this->votes as $vote) {
			if ($vote->participant()->name() === $participant && $vote->potentialPlace()->name() === $place) {
				return true;
			}
		}

		return false;
	}

	private function assertPotentialPlaceExists(string $place): void
	{
		if (!isset($this->potentialPlaces[$place])) {
			throw new PotentialPlaceDoesNotExist($place);
		}
	}

	private function assertParticipantExists(string $participant): void
	{
		if (!isset($this->participants[$participant])) {
			throw new ParticipantDoesNotExist($participant);
		}
	}
}
