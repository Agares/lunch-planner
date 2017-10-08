<?php

declare(strict_types = 1);

namespace Lunch\Application;

use Lunch\Infrastructure\CQRS\CommandHandler;

final class RemoveVoteHandler implements CommandHandler
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
		assert($command instanceof RemoveVote);

		$lunch = $this->repository->findById($command->lunchId());
		$lunch->removeVote($command->participant(), $command->place());

		$this->repository->save($lunch);
	}

	public function handledType(): string
	{
		return RemoveVote::class;
	}
}
