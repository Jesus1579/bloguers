<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 300; $i++) {
            $post = Post::create([
                'user_id' => $faker->numberBetween($min = 2, $max = 151),
                'category_id' => $faker->numberBetween($min = 1, $max = 10),
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'publication_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'contents' => $faker->text($maxNbChars = 250),
                'status' => $faker->randomElement(['active','inactive']),
            ]);
        }
    }
}
