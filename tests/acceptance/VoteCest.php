<?php


class VoteCest
{
	public function _before(AcceptanceTester $I)
	{
		$I->createLunch();
		$I->addParticipant();
		$I->addPotentialPlace();
	}

    public function addVote(AcceptanceTester $I)
    {
    	$I->click('+');

    	$I->canSeeElement('.show_lunch__vote_no');
    }

    public function removeVote(AcceptanceTester $I)
    {
	    $I->click('+');
	    $I->click('-');

	    $I->canSeeElement('.show_lunch__vote_yes');
    }
}
