<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
	protected $fillable = [ 'name', 'code' ];

	protected $hidden = [ 'created_at', 'updated_at' ,'id'];

	public function students() {
		return $this->belongsToMany( 'App\User', 'course__students', 'course_id' );
	}
}
