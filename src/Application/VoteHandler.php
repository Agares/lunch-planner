<?php

namespace Lunch\Application;

use Lunch\Infrastructure\CQRS\CommandHandler;

class VoteHandler implements CommandHandler
{
	/**
	 * @var Repository
	 */
	private $repository;

	public function __construct(Repository $repository)
	{
		$this->repository = $repository;
	}

	public function handle($command): void
	{
		assert($command instanceof Vote);

		$lunch = $this->repository->findById($command->lunchId());
		$lunch->vote($command->participantName(), $command->placeName());

		$this->repository->save($lunch);
	}

	public function handledType(): string
	{
		return Vote::class;
	}
}
