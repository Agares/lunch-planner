<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

use Lunch\Application\Repository;
use Lunch\Domain\Lunch;
use Lunch\Domain\Participant;
use Lunch\Domain\PotentialPlace;

final class PDORepository implements Repository
{
	/**
	 * @var \PDO
	 */
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	// todo refactor this (serialization should be extracted to its own class)
	public function save(Lunch $lunch): void
	{
		$statement = $this->pdo->prepare('
			INSERT INTO lunches ("id", "name", "participants", "potentialPlaces", "votes")
			VALUES (:id, :name, :participants, :potentialPlaces, :votes)
			ON CONFLICT (id) DO UPDATE SET name=:name, participants=:participants, "potentialPlaces"=:potentialPlaces, votes=:votes
		');

		$participants = array_map(function(Participant $x) { return $x->name(); }, $lunch->participants());
		$potentialPlaces = array_map(function(PotentialPlace $x) { return $x->name(); }, $lunch->potentialPlaces());

		$statement->bindValue(':id', (string)$lunch->getId());
		$statement->bindValue(':name', $lunch->name());
		$statement->bindValue(':participants', json_encode($participants));
		$statement->bindValue(':potentialPlaces', json_encode($potentialPlaces));
		$statement->bindValue(':votes', json_encode($lunch->votes()));

		$statement->execute();
	}

	// todo refactor this (or just use doctrine...)
	// todo throw if not found
	public function findById(string $id): Lunch
	{
		$statement = $this->pdo->prepare('SELECT id, name, participants, "potentialPlaces", votes FROM lunches WHERE id=:id');
		$statement->bindValue(':id', $id);

		$statement->execute();

		$rawLunch = $statement->fetch();

		$lunch = Lunch::withName($rawLunch['name'], new UUID($rawLunch['id']));
		foreach(json_decode($rawLunch['participants'], true) as $participant) {
			$lunch->addParticipant(Participant::withName($participant));
		}

		foreach(json_decode($rawLunch['potentialPlaces'], true) as $potentialPlace) {
			$lunch->addPotentialPlace(PotentialPlace::withName($potentialPlace));
		}

		foreach(json_decode($rawLunch['votes'], true) as $vote) {
			$lunch->vote($vote['participant'], $vote['place']);
		}

		return $lunch;
	}
}