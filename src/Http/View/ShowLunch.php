<?php

declare(strict_types=1);

namespace Lunch\Http\View;

use Lunch\Component\Routing\RouteReference;
use Lunch\Component\View\FilesystemTemplateReference;
use Lunch\Component\View\TemplateReference;
use Lunch\Component\View\View;

final class ShowLunch implements View
{
	/**
	 * @var View
	 */
	private $addParticipantForm;

	/**
	 * @var View
	 */
	private $addPotentialPlaceForm;

	/**
	 * @var array
	 */
	private $matrix;

	/**
	 * @var string
	 */
	private $lunchId;

	public function __construct(View $addParticipantForm, View $addPotentialPlaceForm, array $matrix, string $lunchId)
	{
		$this->addParticipantForm = $addParticipantForm;
		$this->addPotentialPlaceForm = $addPotentialPlaceForm;
		$this->matrix = $matrix;
		$this->lunchId = $lunchId;
	}

	public function getViewData(): array
	{
		return [
			'matrix' => $this->matrix,
			'voteLink' => new RouteReference('lunch.vote', [$this->lunchId]),
			'removeVoteLink' => new RouteReference('lunch.remove_vote', [$this->lunchId]),
			'resultsLink' => new RouteReference('lunch.results', [$this->lunchId])
		];
	}

	public function getTemplate(): TemplateReference
	{
		return new FilesystemTemplateReference('show');
	}

	/**
	 * @return View[]
	 */
	public function getChildren(): array
	{
		return [
			'addParticipantForm' => $this->addParticipantForm,
			'addPotentialPlaceForm' => $this->addPotentialPlaceForm
		];
	}
}