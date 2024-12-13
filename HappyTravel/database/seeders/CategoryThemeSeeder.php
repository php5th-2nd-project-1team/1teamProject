<?php

namespace Database\Seeders;

use App\Models\CategoryTheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryThemeSeeder extends Seeder
{
    public function saveTheme($category_name, $category_num){
        $local = new CategoryTheme();
        $local->category_theme_name = $category_name;
        $local->category_theme_num = $category_num;
        $local->save();
    }
    public $data = [
        '01' => '숙소'
        ,'02' => '식음료'
        ,'03' => '관광지'
        ,'04' => '병원'
    ];
    public function run()
    {
        foreach($this->data as $key => $value){
            $this->saveTheme($value, $key);
        }
    }
}
