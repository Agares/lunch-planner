<?php

declare(strict_types = 1);

return [
	'home' => [
		'path' => '/',
		'handler' => \Lunch\Http\Homepage::class,
		'method' => 'GET'
	],
	'lunch.create' => [
		'path' => '/lunches',
		'handler' => \Lunch\Http\CreateLunch::class,
		'method' => 'POST'
	],
	'lunch.show' => [
		'path' => '/lunches/{id}',
		'handler' => \Lunch\Http\ShowLunch::class,
		'method' => 'GET'
	],
	'lunch.participants.add' => [
		'path' => '/lunches/{id}/participants',
		'handler' => \Lunch\Http\AddParticipant::class,
		'method' => 'POST'
	],
	'lunch.potential_places.add' => [
		'path' => '/lunches/{id}/potential_places',
		'handler' => \Lunch\Http\AddPotentialPlace::class,
		'method' => 'POST'
	],
	'lunch.vote' => [
		'path' => '/lunches/{id}/votes',
		'handler' => \Lunch\Http\Vote::class,
		'method' => 'POST'
	],
	'lunch.remove_vote' => [
		'path' => '/lunches/{id}/votes/remove',
		'handler' => \Lunch\Http\RemoveVote::class,
		'method' => 'POST' // todo investigate if it's possible to do a DELETE here (browser support, etc.)
	],
	'lunch.results' => [
		'path' => '/lunches/{id}/results',
		'handler' => \Lunch\Http\ShowResults::class,
		'method' => 'GET'
	]
];