<?php


class ResultsCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    	$I->createLunch();
    	$I->addParticipant();
    	$I->addPotentialPlace();

    	$I->click('+');

    	$I->click('Results');

    	$I->see('1 (100.00%)');
    }
}
