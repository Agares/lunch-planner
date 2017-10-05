<?php

declare(strict_types = 1);

namespace Lunch\Infrastructure\CQRS;

final class QueryBus
{
	/**
	 * @var QueryHandler[]
	 */
	private $handlers;

	public function registerHandler(QueryHandler $handler): void
    {
    	$this->handlers[$handler->handledType()] = $handler;
    }

    public function handle($query)
    {
	    $className = get_class($query);

	    if(!isset($this->handlers[$className])) {
	    	throw new QueryHandlerNotFound($className);
	    }

	    return $this->handlers[$className]->handle($query);
    }
}
