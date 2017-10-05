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
	]
];