<?php

declare(strict_types = 1);

namespace Lunch\Component\View;

final class Renderer
{
	/**
	 * @var TemplateReferenceResolver
	 */
	private $templateReferenceResolver;

	/**
	 * @var \Mustache_Engine
	 */
	private $mustacheEngine;

	/**
	 * @var ReferenceResolver
	 */
	private $referenceResolver;

	public function __construct(
		TemplateReferenceResolver $templateReferenceResolver,
		\Mustache_Engine $mustacheEngine,
		ReferenceResolver $referenceResolver
	)
    {
	    $this->templateReferenceResolver = $templateReferenceResolver;
	    $this->mustacheEngine = $mustacheEngine;
	    $this->referenceResolver = $referenceResolver;
    }

    public function render(View $view): string
    {
    	$template = $this->templateReferenceResolver->resolve($view->getTemplate());

	    $viewContext = array_map(function($datum) {
	    	if(is_scalar($datum) || is_array($datum)) // todo support references in nested arrays
		    {
		    	return $datum;
		    }

		    return $this->referenceResolver->resolve($datum);
	    }, $view->getViewData());

	    $viewContext = array_merge(
	    	$viewContext,
		    array_map(
		    	function (View $child) {
		    		return $this->render($child);
			    },
			    $view->getChildren()
		    )
	    );

	    return $this->mustacheEngine->render($template, $viewContext);
    }
}
