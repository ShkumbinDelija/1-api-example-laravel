<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'surname',
		'role'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'created_at',
		'updated_at',
		'role',
		'id',
		'student_id',
		'professor_id'
	];

	public static function students() {
		return User::where( 'role', '0' )->get();
	}

	public static function professors() {
		return User::where( 'role', '1' )->get();
	}

	public function student_courses() {
		return $this->belongsToMany( 'App\Course', 'course__students', 'student_id' );
	}

	public function professor_courses() {
		return $this->belongsToMany( 'App\Course', 'course__professors', 'professor_id' );
	}
}
