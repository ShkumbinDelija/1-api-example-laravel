<?php

namespace App\Http\Controllers;

use App\Course;
use App\Course_Student;
use App\Http\Resources\Student;
use App\Professor;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;

class StudentController extends Controller {
	public function index( Request $request ) {
		$sortBy = 0;
		if ( $request->t ) {
			$sortBy = $request->t == 'desc' ? 1 : $sortBy;
		}
		if ( $request->s && $request->t ) {
			return Student::collection( User::students()->sortBy( $request->s, $sortBy ) );
		} else if ( $request->s && ! $request->t ) {
			return Student::collection( User::students()->sortBy( $request->s ) );
		}

		return Student::collection( User::students()->sortBy( 'name' ) );
	}

	public function courses( Request $request ) {
		$sortBy = 0;
		if ( $request->t ) {
			$sortBy = $request->t == 'desc' ? 1 : $sortBy;
		}
		$students = User::students();
		$courses  = Course::all();
		foreach ( $students as $student ) {
			$student_courses  = $student->student_courses()->get();
			$courses_relation = [];
			$totali_nota      = 0;
			$courses_count    = 0;
			foreach ( $student_courses as $course ) {
				$courses_count ++;
				$course_actual = Course::find( $course->pivot->course_id );
				array_push( $courses_relation, [
					'Course: ' . $course_actual->name,
					'Grade: ' . ( $course_student = Course_Student::find( $course->id ) )->grade
				] );
				$totali_nota += $course_student->grade;
			}
			$student->courses = $courses_relation;
			if ( $request->n && $request->n == 'true' ) {
				$student->nota_mesatare = $courses_count == 0 ? 0 : ( $totali_nota / $courses_count );
			}
		}
		if ( $request->n && $request->n == 'true' ) {
			if ( $sortBy == 1 ) {
				return Student::collection( $students->sortBy( 'nota_mesatare' )->reverse() );
			} else {
				return Student::collection( $students->sortBy( 'nota_mesatare' ) );
			}
		}

		return Student::collection( $students->sortBy( 'name' ) );
	}

	public function student( Request $request ) {
		return Student::collection( \App\User::where( 'role', '0' )->where( 'id', $request->id )->get() );
	}

	public function student_courses( Request $request ) {
		$student = User::where( 'id', $request->id )->where( 'role', '0' )->first();
		if ( ! $student ) {
			return 'Student not found';
		}
		$student_courses  = User::where( 'id', $request->id )->where( 'role', '0' )->first()->student_courses()->get();
		$courses_relation = [];
		foreach ( $student_courses as $course ) {
			$course_actual = Course::find( $course->pivot->course_id );
			array_push( $courses_relation, [
				'Course: ' . $course_actual->name,
				'Grade: ' . Course_Student::find( $course->id )->grade
			] );
		}
		$student->courses = $courses_relation;

		return response()->json( $student );
	}

	public function nota_mesatare( Request $request ) {
		$student = User::where( 'id', $request->id )->where( 'role', '0' )->first();
		if ( ! $student ) {
			return 'Student not found';
		}
		$student_courses  = User::where( 'id', $request->id )->where( 'role', '0' )->first()->student_courses()->get();
		$courses_relation = [];
		$courses_count    = 0;
		$totali_nota      = 0;
		foreach ( $student_courses as $course ) {
			$courses_count ++;
			$course_actual = Course::find( $course->pivot->course_id );
			array_push( $courses_relation, [
				'Course: ' . $course_actual->name,
				'Grade: ' . ( $course_student = Course_Student::find( $course->id ) )->grade
			] );
			$totali_nota += $course_student->grade;
		}
		$student->courses       = $courses_relation;
		$student->nota_mesatare = $courses_count == 0 ? 0 : ( $totali_nota / $courses_count );

		return response()->json( $student );
	}

	public function studentet_me_note_mesatare( Request $request ) {
		if ( ! $request->n ) {
			return "No student found with that value";
		}
		$students                   = User::students();
		$courses                    = Course::all();
		$studentat_me_note_mesatare = [];
		foreach ( $students as $student ) {
			$student_courses  = $student->student_courses()->get();
			$courses_relation = [];
			$totali_nota      = 0;
			$courses_count    = 0;
			foreach ( $student_courses as $course ) {
				$courses_count ++;
				$course_actual = Course::find( $course->pivot->course_id );
				array_push( $courses_relation, [
					'Course: ' . $course_actual->name,
					'Grade: ' . ( $course_student = Course_Student::find( $course->id ) )->grade
				] );
				$totali_nota += $course_student->grade;
			}
			$student->courses = $courses_relation;

			$student->nota_mesatare = $courses_count == 0 ? 0 : ( $totali_nota / $courses_count );
			if ( $request->m && $request->m == 'true' ) {
				if ( $courses_count > 0 && ( $totali_nota / $courses_count >= $request->n ) ) {
					array_push( $studentat_me_note_mesatare, $student );
				}
			} else if ( ! $request->m && $request->v && $request->v == 'true' ) {
				if ( $courses_count > 0 && ( $totali_nota / $courses_count <= $request->n ) ) {
					array_push( $studentat_me_note_mesatare, $student );
				}
			} else {
				if ( $courses_count > 0 && ( $totali_nota / $courses_count == $request->n ) ) {
					array_push( $studentat_me_note_mesatare, $student );
				}
			}

		}
		if ( sizeof( $studentat_me_note_mesatare ) == 0 ) {
			return "No student found.";
		}

		return response()
			->json( $studentat_me_note_mesatare );

	}

	public function create( Request $request ) {
		User::create( [
			'name'     => $request->name,
			'surname'  => $request->surname,
			'email'    => $request->email,
			'password' => bcrypt( $request->password ),
			'role'     => 0
		] );

		return back();
	}

	public function studentByEmail( Request $request ) {
		return Student::collection( User::where( 'email', $request->email )->get() );
	}

	public function edit( Request $request ) {
		User::where( 'email', $request->email )->first()->update( [
			'email'   => $request->new_email,
			'name'    => $request->name,
			'surname' => $request->surname
		] );

		return redirect()->away( 'http://localhost:52290/Home/Students' );
	}

	public function delete( Request $request ) {
		\App\User::where( 'email', $request->email )->first()->delete();

		return back();
	}

}
