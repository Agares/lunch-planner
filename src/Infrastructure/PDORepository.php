<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

use Lunch\Application\Repository;
use Lunch\Domain\Lunch;

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

	public function save(Lunch $lunch): void
	{
		$statement = $this->pdo->prepare('
			INSERT INTO lunches ("id", "name", "participants", "potentialPlaces", "votes")
			VALUES (:id, :name, :participants, :potentialPlaces, :votes)
		');

		$statement->bindValue(':id', (string)$lunch->getId());
		$statement->bindValue(':name', $lunch->name());
		$statement->bindValue(':participants', json_encode($lunch->participants()));
		$statement->bindValue(':potentialPlaces', json_encode($lunch->potentialPlaces()));
		$statement->bindValue(':votes', json_encode($lunch->votes()));

		$statement->execute();
	}
}