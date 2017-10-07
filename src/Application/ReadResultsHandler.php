<?php

declare(strict_types=1);

namespace Lunch\Application;

use Lunch\Infrastructure\CQRS\QueryHandler;

final class ReadResultsHandler implements QueryHandler
{
	/**
	 * @var \PDO
	 */
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	// todo refactor, maybe move some logic to the DB?
	public function handle($query)
	{
		assert($query instanceof ReadResults);

		$statement = $this->pdo->prepare('SELECT votes FROM lunches WHERE id=:id');
		$statement->bindValue(':id', $query->lunchId());
		$statement->execute();

		$votes = json_decode($statement->fetchColumn(), true);

		$result = [];
		$totalVotes = count($votes);

		$votesPerPlace = [];

		foreach($votes as $vote) {
			if(!isset($votesPerPlace[$vote['place']])) {
				$votesPerPlace[$vote['place']] = 0;
			}

			$votesPerPlace[$vote['place']]++;
		}

		foreach($votesPerPlace as $place => $numberOfVotes) {
			$result[] = [
				'place' => $place,
				'votes' => $numberOfVotes,
				// number_format is used to convert to a string that will have the desired number of decimal places,
				// even if float precision would otherwise mess it up
				'votes_percentage' => number_format(round(($numberOfVotes/$totalVotes)*100.0, 2), 2)
			];
		}

		usort($result, function($a, $b) { return $b['votes'] <=> $a['votes']; });

		return $result;
	}

	public function handledType(): string
	{
		return ReadResults::class;
	}
}