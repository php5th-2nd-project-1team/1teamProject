<?php

namespace Database\Seeders;

use App\Models\CategoryLocal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class CategoryLocalSeeder extends Seeder
{
    public function saveLocal($category_name, $category_num, $category_img){
        $local = new CategoryLocal();
        $local->category_local_name = $category_name;
        $local->category_local_num = $category_num;
        $local->category_local_img = $category_img;
        $local->save();
    }

    public $data = [
        '01' => '서울'
        ,'02' => '경기'
        ,'03' => '강원'
        ,'04' => '인천'
        ,'05' => '세종'
        ,'06' => '대전'
        ,'07' => '충북'
        ,'08' => '충남'
        ,'09' => '경북'
        ,'10' => '경남'
        ,'11' => '전북'
        ,'12' => '전남'
        ,'13' => '제주'
        ,'00' => '전국'
    ];
    public function run()
    {
        // foreach($this->data as $key => $value){
        //     $this->saveLocal($value, $key, '/developImg/seoul_icon.png');
        // }
        $this->saveLocal('전국', '00', '/developImg/seoul_icon.png');
    }
}
