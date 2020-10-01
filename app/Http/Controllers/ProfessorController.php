<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Resources\Professor;
use App\Http\Resources\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfessorController extends Controller {
	public function index( Request $request ) {
		$sortBy = 0;
		if ( $request->t ) {
			$sortBy = $request->t == 'desc' ? 1 : $sortBy;
		}
		if ( $request->s && $request->t ) {
			return Professor::collection( User::professors()->sortBy( $request->s, $sortBy ) );
		} else if ( $request->s && ! $request->t ) {
			return Professor::collection( User::professors()->sortBy( $request->s ) );
		}

		return Professor::collection( User::professors()->sortBy( 'name' ) );
	}

	public function courses() {
		$professors = User::professors();
		$courses    = \App\Course::all();
		foreach ( $professors as $professor ) {
			$professor_courses = $professor->professor_courses()->get();
			$courses_relation  = [];
			foreach ( $professor_courses as $course ) {
				$course_actual = \App\Course::find( $course->pivot->course_id );
				array_push( $courses_relation, 'Course: ' . $course_actual->name );
			}
			$professor->courses = $courses_relation;
		}

		return Professor::collection( $professors );
	}

	public function professor( Request $request ) {
		return Professor::collection( User::where( 'role', '1' )->where( 'id', $request->id )->get() );
	}

	public function professor_courses( Request $request ) {
		$professor = User::where( 'id', $request->id )->where( 'role', '1' )->first();
		if ( ! $professor ) {
			return 'Professor not found';
		}
		$professor_courses = User::where( 'id', $request->id )->where( 'role', '1' )->first()->professor_courses()->get();
		$courses_relation  = [];
		foreach ( $professor_courses as $course ) {
			$course_actual = Course::find( $course->pivot->course_id );
			array_push( $courses_relation, [
				'Course: ' . $course_actual->name
			] );
		}
		$professor->courses = $courses_relation;

		return response()->json( $professor );
	}

	public function create( Request $request ) {
		User::create( [
			'name'     => $request->name,
			'surname'  => $request->surname,
			'email'    => $request->email,
			'password' => bcrypt( $request->password ),
			'role'     => 1
		] );

		return back();
	}

	public function test( Request $request ) {

	}

	public function professorByEmail( Request $request ) {
		return Professor::collection(User::where('email',$request->email)->get());
	}

	public function edit( Request $request ) {
		User::where( 'email', $request->email )->first()->update( [
			'email'   => $request->new_email,
			'name'    => $request->name,
			'surname' => $request->surname
		] );
		return redirect()->away( 'http://localhost:52290/Home/Professors' );
	}

	public function delete( Request $request ) {
		\App\User::where('email', $request->email)->first()->delete();
		return back();
	}
}
