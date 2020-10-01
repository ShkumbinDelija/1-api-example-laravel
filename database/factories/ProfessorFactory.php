<?php

use Faker\Generator as Faker;

$factory->define( \App\User::class, function ( Faker $faker ) {
	return [
		'name'           => $faker->firstName,
		'surname'        => $faker->lastName,
		'email'          => $faker->unique()->safeEmail,
		'password'       => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
		'remember_token' => str_random( 10 ),
		'role'           => 1,
		'professor_id'   => rand( 10000000, 99999999 )
	];
} );
