<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */


	protected $except = [
		'http://localhost:8000/api/create/professor',
		'http://localhost:8000/api/create/student',
		'http://localhost:8000/api/create/course',
	];
}
