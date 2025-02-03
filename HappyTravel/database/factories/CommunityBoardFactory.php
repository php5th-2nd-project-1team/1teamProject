<?php

namespace Database\Factories;

use App\Models\CommunityBoard;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommunityBoard>
 */
class CommunityBoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $user= User::select('user_id')->inRandomOrder()->first();
        return [
            'user_id'=>$user->user_id,
            'community_type' => $this->faker->randomElement([0, 1]),
            'community_title'=>$this->faker->realText(30),
            'community_content'=>$this->faker->realText(500),
            'community_view'=>200,            
        ];
    }
}
