<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$array = [
			[
				"name" => "Admin",
				"last_name" => "Cronapis",
				"email" => "admin@cronapis.com",
				"password" => bcrypt("admin123"),
				"role" => "admin"
			]
			];
			$u = User::firstOrCreate($array);
		}

}
