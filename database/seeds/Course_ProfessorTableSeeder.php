<?php

use Illuminate\Database\Seeder;

class Course_ProfessorTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory( App\Course_Professor::class, 800 )->create();
	}
}
