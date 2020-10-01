<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
	return $request->user();
} );
Route::get( '/student/{id}', 'StudentController@student' );
Route::get( '/student/{id}/courses', 'StudentController@student_courses' );
Route::get( '/student/{id}/courses/nota_mesatare', 'StudentController@nota_mesatare' );
Route::get( '/students', 'StudentController@index' );
Route::get( '/students/courses', 'StudentController@courses' );
Route::get( '/students/nota_mesatare', 'StudentController@studentet_me_note_mesatare' );
Route::get( '/professors', 'ProfessorController@index' );
Route::get( '/professor/{id}', 'ProfessorController@professor' );
Route::get( '/professor/{id}/courses', 'ProfessorController@professor_courses' );
Route::get( '/professors/courses', 'ProfessorController@courses' );
Route::get( '/courses', 'CourseController@index' );
Route::get( '/create/data', 'DataController@create' );
Route::post( '/create/professor', 'ProfessorController@create' )->name( 'createProfessors' );
Route::post( '/create/student', 'StudentController@create' )->name( 'createStudents' );
Route::post( '/create/course', 'CourseController@create' )->name( 'createCourses' );
Route::get('/professorByEmail/{email}','ProfessorController@professorByEmail');
Route::get('/studentByEmail/{email}','StudentController@studentByEmail');
Route::get('/courseByCode/{code}','CourseController@courseByCode');
Route::put('/edit/student','StudentController@edit');
Route::put('/edit/professor','ProfessorController@edit');
Route::put('/edit/course','CourseController@edit');
Route::delete('/delete/student','StudentController@delete');
Route::delete('/delete/professor','ProfessorController@delete');
Route::delete('/delete/course','CourseController@delete');