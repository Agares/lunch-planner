<?php


class CreateLunchCest
{
    public function tryToTest(AcceptanceTester $I)
    {
    	$I->createLunch();

    	$I->see('Add participant');
    }
}
