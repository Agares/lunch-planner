<?php

declare(strict_types = 1);

namespace Lunch\Application;

use Lunch\Domain\PotentialPlace;
use Lunch\Infrastructure\CQRS\CommandHandler;

final class AddPotentialPlaceHandler implements CommandHandler
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
		assert($command instanceof AddPotentialPlace);

		$lunch = $this->repository->findById($command->lunchId());
		$lunch->addPotentialPlace(PotentialPlace::withName($command->name()));

		$this->repository->save($lunch);
	}

	public function handledType(): string
	{
		return AddPotentialPlace::class;
	}
}
