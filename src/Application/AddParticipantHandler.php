<?php

declare(strict_types = 1);

namespace Lunch\Application;

use Lunch\Domain\Participant;
use Lunch\Infrastructure\CQRS\CommandHandler;

final class AddParticipantHandler implements CommandHandler
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
    	assert($command instanceof AddParticipant);

    	$lunch = $this->repository->findById($command->lunchId());
    	$lunch->addParticipant(Participant::withName($command->name()));

    	$this->repository->save($lunch);
    }

	public function handledType(): string
	{
		return AddParticipant::class;
	}
}
