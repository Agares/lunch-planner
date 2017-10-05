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

	public function handle($query)
	{
		assert($query instanceof ReadLunchMatrix);

		$statement = $this->pdo->prepare('SELECT votes FROM lunches WHERE id = :id');
		$statement->bindValue(':id', $query->id());

		$statement->execute();

		$lunch = $statement->fetch();
		$votes = json_decode($lunch['votes']);

		return $votes;
	}

	public function handledType(): string
	{
		return ReadLunchMatrix::class;
	}
}