<?php


class AddParticipantCest
{
    public function emptyForm(AcceptanceTester $I)
    {
    	$I->createLunch();

    	$I->submitForm('.add_participant', []);
    	$I->see('Must not be empty');
    }

    public function validForm(AcceptanceTester $I)
    {
    	$I->createLunch();
    	$I->addParticipant('Josey');
    	$I->see('Josey');
    }
}
