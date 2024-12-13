<?php

namespace Database\Factories;

use App\Models\Manager;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        $manager =Manager::select('manager_id')->inRandomOrder()->first();
        return [
            'manager_id'=>$manager->manager_id,
            'notice_title' =>$this->faker->realText(30),
            'notice_content'=>$this->faker->realText(500),
            'notice_img' =>'/img/link-file'.'.png',
        ];
    }
}
