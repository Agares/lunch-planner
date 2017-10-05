<?php
return [
	'paths' => [
		'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
	],
	'environments' => [
		'default_migration_table' => 'phinxlog',
		'default_database'        => 'development',
		'development'             => [
			'adapter' => 'pgsql',
			'host'    => 'db',
			'name'    => getenv('POSTGRES_DB'),
			'user'    => getenv('POSTGRES_USER'),
			'pass'    => getenv('POSTGRES_PASSWORD'),
			'charset' => 'utf8',
		],
	],
];