<?php

use Faker\Generator as Faker;

$factory->define( \App\Course_Professor::class, function ( Faker $faker ) {
	$professors = \Illuminate\Support\Facades\DB::table( 'users' )
	                                            ->where( 'role', '=', '1' )
	                                            ->pluck( 'id' );
	$courses    = \Illuminate\Support\Facades\DB::table( 'courses' )
	                                            ->pluck( 'id' );

	return [
		'professor_id' => $faker->randomElement( $professors->toArray() ),
		'course_id'    => $faker->randomElement( $courses->toArray() )
	];
} );
