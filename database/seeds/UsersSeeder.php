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
			],
			[
				"name" => "Admin 2",
				"last_name" => "Cronapis 2",
				"email" => "admin2@cronapis.com",
				"password" => bcrypt("admin123"),
				"role" => "admin"
			]
		];
		foreach ($array as $arr) {
			$u = User::firstOrCreate([
				"email" => $arr['email']
			], collect($arr)->except('role')->all());
			if (!$u->hasRole($arr['role']))
				$u->assignRole($arr['role']);
		}
	}
}
