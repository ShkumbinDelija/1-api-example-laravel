<?php

use Faker\Generator as Faker;

$factory->define( \App\Course_Student::class, function ( Faker $faker ) {
	$students = \Illuminate\Support\Facades\DB::table( 'users' )
	                                          ->where( 'role', '=', '0' )
	                                          ->pluck( 'id' );
	$courses  = \Illuminate\Support\Facades\DB::table( 'courses' )
	                                          ->pluck( 'id' );

	return [
		'student_id' => $faker->randomElement( $students->toArray() ),
		'course_id'   => $faker->randomElement( $courses->toArray() ),
		'grade' => rand(5,10)
	];
} );
