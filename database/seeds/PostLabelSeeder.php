<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabelPost;

class PostLabelSeeder extends Seeder
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
        $postLabel = LabelPost::create([
            'label_id' => $faker->numberBetween($min = 1, $max = 10),
            'post_id' => $faker->numberBetween($min = 1, $max = 300),
        ]);
        }
    }
}
