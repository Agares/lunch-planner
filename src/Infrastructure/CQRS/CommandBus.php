<?php

declare(strict_types = 1);

namespace Lunch\Infrastructure\CQRS;

final class CommandBus
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
	    	throw new CommandHandlerNotFound($commandClassName);
	    }

	    $this->handlers[$commandClassName]->handle($command);
    }
}
