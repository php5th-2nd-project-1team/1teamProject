<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $date = $this->faker->dateTimeBetween('-1 years');
        $manager = Manager::select('manager_id')->inRandomOrder()->first();

        return [
        'manager_id' => $manager->manager_id,
        'category_local_num',
        'category_theme_num',
        'post_local_name',
        'post_title',
        'post_content',
        'post_detail_content',
        'post_img',
        'post_like',
        'post_view',
        ];
    }
}
