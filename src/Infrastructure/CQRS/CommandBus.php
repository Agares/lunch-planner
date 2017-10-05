<?php

namespace Lunch\Infrastructure\CQRS;

class CommandBus
{
	/**
	 * @var CommandHandler[]
	 */
	private $handlers = [];

	public function registerHandler(CommandHandler $handler): void
    {
    	$this->handlers[$handler->handledType()] = $handler;
    }

    public function execute($command): void
    {
	    $commandClassName = get_class($command);

	    if(!isset($this->handlers[$commandClassName])) {
	    	throw new HandlerNotFound($commandClassName);
	    }

	    $this->handlers[$commandClassName]->handle($command);
    }
}
