<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->name,
            'last_name' => $faker->lastName,
            'main_image' => $faker->image(public_path('images'),250,200),
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ];
    }
}
