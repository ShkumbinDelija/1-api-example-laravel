<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class DataController extends Controller {
	public function create() {
		$path = storage_path() . "/json/courses.json"; // ie: /var/www/laravel/app/storage/json/filename.json

		$json = json_decode( file_get_contents( $path ), true );

		foreach ( $json as $item ) {
			Course::create( [
				'name' => $item['name'],
				'code' => $item['code']
			] );
		}
	}
}
