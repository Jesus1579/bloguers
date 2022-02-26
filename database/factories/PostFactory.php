<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    protected $model = Post::class;
    /*
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 26),
            'category_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'publication_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'contents' => $this->faker->text($maxNbChars = 400),
            'status' => 'active',
        ];
    }
}
