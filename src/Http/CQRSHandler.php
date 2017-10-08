<?php

declare(strict_types=1);

namespace Lunch\Http;

use Lunch\Component\Http\Handler;
use Lunch\Infrastructure\CQRS\CommandBus;
use Lunch\Infrastructure\CQRS\QueryBus;
use Lunch\Infrastructure\UUIDFactory;

abstract class CQRSHandler extends Handler
{
	protected function commandBus(): CommandBus
	{
		return $this->container()->get(CommandBus::class);
	}

	protected function queryBus(): QueryBus
	{
		return $this->container()->get(QueryBus::class);
	}

	// todo return an IdentifierFactory here, so we're not coupling everything to UUIDs
	protected function uuidFactory(): UUIDFactory
	{
		return $this->container()->get(UUIDFactory::class);
	}
}