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

	public function participants(): array
	{
		return array_values($this->participants);
	}

	public function potentialPlaces(): array
	{
		return array_values($this->potentialPlaces);
	}

    public function vote(string $participant, string $place): void
    {
    	foreach($this->votes as $vote) {
    		if($vote->participant()->name() === $participant && $vote->potentialPlace()->name() === $place) {
    			return;
		    }
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

	public function getId(): Identifier
	{
		return $this->id;
	}
}
