<?php

declare(strict_types=1);

namespace Lunch\Application;

use Lunch\Infrastructure\CQRS\QueryHandler;

final class ReadLunchMatrixHandler implements QueryHandler
{
	/**
	 * @var \PDO
	 */
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	// todo refactor to return an object instead of an array
	// todo throw if lunch doesn't exist
	// todo move the logic to the query? Or find other ways to make it more readable...
	public function handle($query): array
	{
		assert($query instanceof ReadLunchMatrix);

		$statement = $this->pdo->prepare('SELECT votes, participants, "potentialPlaces" FROM lunches WHERE id = :id');
		$statement->bindValue(':id', $query->id());

		$statement->execute();

		$lunch = $statement->fetch();
		$votes = json_decode($lunch['votes'], true);

		$participants = json_decode($lunch['participants'], true);
		$potentialPlaces = json_decode($lunch['potentialPlaces'], true);

		$participantsWithVotes = [];

		foreach($participants as $participant) {
			$participantsWithVotes[] = [
				'name' => $participant,
				'votes' => array_map(function($potentialPlace) use($votes, $participant) {
					$value = false;

					foreach($votes as $vote) {
						if($vote['participant'] === $participant && $vote['place'] === $potentialPlace) {
							$value = true;
							break;
						}
					}

					return [
						'value' => $value,
						'potentialPlaceName' => $potentialPlace
					];
				}, $potentialPlaces)
			];
		}

		$matrix = [
			'participants' => $participantsWithVotes,
			'potentialPlaces' => $potentialPlaces
		];

		return $matrix;
	}

	public function handledType(): string
	{
		return ReadLunchMatrix::class;
	}
}