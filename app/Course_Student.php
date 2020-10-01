<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course_Student extends Model {

	protected $hidden = [ 'student_id', 'course_id', 'created_at', 'updated_at', 'id' ];

	public function students() {
		return $this->belongsToMany( 'App\User' );
	}

	public function courses() {
		return $this->belongsToMany( 'App\Students' );
	}

	public static function courses_with_grade( $grade ) {
		return Course_Student::where( 'grade', $grade )->get();
	}
}
