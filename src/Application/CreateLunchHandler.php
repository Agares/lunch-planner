<?php

declare(strict_types = 1);

namespace Lunch\Application;

use Lunch\Domain\Lunch;
use Lunch\Infrastructure\CQRS\CommandHandler;
use Lunch\Infrastructure\UUID;

final class CreateLunchHandler implements CommandHandler
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
		assert($command instanceof CreateLunch);

	    $id = new UUID($command->id());
	    $name = $command->name();

	    $lunch = Lunch::withName($name, $id);

	    $this->repository->save($lunch);
    }

	public function handledType(): string
	{
		return CreateLunch::class;
	}
}
