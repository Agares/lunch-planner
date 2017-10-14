<?php

namespace Lunch\Component\View;

class TemplateReferenceResolver
{
	/**
	 * @var TemplateReferenceHandler[]
	 */
	private $handlers;

	public function resolve(TemplateReference $reference): string
    {
    	if(!isset($this->handlers[get_class($reference)])) {
		    throw new TemplateReferenceHandlerNotFound(get_class($reference));
	    }

	    return $this->handlers[get_class($reference)]->resolve($reference);
    }

    public function registerHandler(TemplateReferenceHandler $handler): void
    {
    	$this->handlers[$handler->handledType()] = $handler;
    }
}
