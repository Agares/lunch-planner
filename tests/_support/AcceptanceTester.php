<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
	use _generated\AcceptanceTesterActions;

	public function createLunch(?string $name = null)
	{
		if($name === null) {
			$name = uniqid('', true);
		}

		$this->amOnPage('/');
		$this->fillField('Lunch name:', 'Some name');
		$this->click('Go');
	}

	public function addParticipant(string $name = 'Josey')
	{
		$this->submitForm('.add_participant', [
			'name' => $name
		]);
	}

	public function addPotentialPlace(string $name = 'Mexican')
	{
		$this->submitForm('.add_potential_place', [
			'name' => $name
		]);
	}
}
