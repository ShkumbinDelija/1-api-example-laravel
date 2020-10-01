<?php

use Illuminate\Database\Seeder;

class Course_StudentTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory( App\Course_Student::class, 800 )->create();
	}
}
