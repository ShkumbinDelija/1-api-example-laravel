<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', function () {
	dd( \Illuminate\Support\Facades\DB::table( 'users' )->pluck( 'id' ) );
} );

Route::get( '/test', function () {
	dd( \Illuminate\Support\Facades\DB::table( 'course__students' )
	                                  ->join( 'users', 'users.id', '=', 'course__students.student_id' )
	                                  ->join( 'courses', 'courses.id', '=', 'course__students.course_id' )
	                                  ->select( 'courses.name as course_name','course__students.grade' )
	                                  ->get() );
} );


Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

