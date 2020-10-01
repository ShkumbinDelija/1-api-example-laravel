<?php

namespace App\Http\Controllers;

use App\Http\Resources\Course;
use Illuminate\Http\Request;

class CourseController extends Controller {
	public function index() {
		return Course::collection( \App\Course::all() );
	}

	public function create( Request $request ) {
		\App\Course::create( [
			'name' => $request->name,
			'code' => $request->code
		] );

		return back();
	}

	public function courseByCode( Request $request ) {
		return Course::collection( \App\Course::where( 'code', $request->code )->get() );
	}

	public function edit( Request $request ) {
		\App\Course::where( 'code', $request->code )->first()->update( [
			'name' => $request->name,
			'code' => $request->new_code
		] );

		return redirect()->away( 'http://localhost:52290/Home/Courses' );
	}

	public function delete( Request $request ) {
		\App\Course::where( 'code', $request->code )->first()->delete();

		return back();
	}
}
