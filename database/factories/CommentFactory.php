<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => 0,
            'user_name' => $this->faker->name(),
            'comment' => $this->faker->text(),
        ];
    }
}
