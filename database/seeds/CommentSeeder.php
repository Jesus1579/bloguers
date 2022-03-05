<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 200; $i++) {
            $post = Comment::create([
                'user_id' => $faker->numberBetween($min = 2, $max = 151),
                'post_id' => $faker->numberBetween($min = 1, $max = 200),
                'comment' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            ]);
        }
    }
}
