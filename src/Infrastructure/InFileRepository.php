<?php

declare(strict_types=1);

namespace Lunch\Infrastructure;

use Lunch\Application\Repository;
use Lunch\Domain\Lunch;

final class InFileRepository implements Repository
{
	public function save(Lunch $lunch): void
	{
		file_put_contents(__DIR__.'/../../data/lunches/' . $lunch->getId(), serialize($lunch));
	}
}