<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
//		$this->call( StudentsTableSeeder::class );
//		$this->call( Course_StudentTableSeeder::class );
         $this->call(ProfessorsTableSeeder::class);
         $this->call(Course_ProfessorTableSeeder::class);
	}
}
