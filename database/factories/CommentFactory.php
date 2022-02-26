<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    protected $model = Comment::class;
    /*
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->text($maxNbChars = 400),
            'user_id' => $this->faker->numberBetween($min = 1, $max = 26),
            'post_id' => $this->faker->numberBetween($min = 1, $max = 50),
        ];
    }
}
