<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->user_id,
            'inquiry_title' => $this->faker->realText(45),
            'inquiry_content' => $this->faker->realText(5000),
            'inquiry_secret' => $this->faker->boolean(),
        ];
    }
}
