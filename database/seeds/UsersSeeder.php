<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
		$faker = \Faker\Factory::create();

		$user = User::query();

		$user->create([
				"name" => "AdminBlog",
				"last_name" => "Blog",
				"main_image" => "https://picsum.photos/200/300",
				"email" => "admin@example.com",
				"email_verified_at" => now(),
				"password" => bcrypt("12345678"),
				"roles" => "admin",
		]);


		for ($i=0; $i < 150; $i++) {
			$user->create([
				"name" => $faker->name,
				"last_name" => $faker->lastName,
				"main_image" => "https://picsum.photos/200/300",
				"email" => $faker->safeEmail,
				"email_verified_at" => now(),
				"password" => bcrypt("12345678"),
				"roles" => "blogled",
		]);
		}

	}
}
