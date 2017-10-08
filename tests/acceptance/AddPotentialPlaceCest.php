<?php


class AddPotentialPlaceCest
{
	public function emptyForm(AcceptanceTester $I)
	{
		$I->createLunch();

		$I->submitForm('.add_potential_place', []);
		$I->see('Must not be empty');
	}

	public function validForm(AcceptanceTester $I)
	{
		$I->createLunch();
		$I->addPotentialPlace('Mexican');
		$I->see('Mexican');
	}
}
