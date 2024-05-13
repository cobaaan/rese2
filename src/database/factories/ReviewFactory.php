<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Review;

class ReviewFactory extends Factory
{
    /**
    * Define the model's default state.
    *
    * @return array
    */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1,3),
            'shop_id' => $this->faker->numberBetween(1,20),
            'reserve_id' =>$this->faker->numberBetween(1,2),
            'rate' =>$this->faker->numberBetween(2,4),
            'comment' =>$this->faker->realText(59)
        ];
    }
}
