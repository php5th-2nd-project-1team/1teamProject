<?php

namespace Database\Seeders;

use App\Models\AnimalType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function saveAnimalType($animal_type_name, $animal_type_num)
    {
        $animalType = new AnimalType();
        $animalType->animal_type_name = $animal_type_name;
        $animalType->animal_type_num = $animal_type_num;
        $animalType->save();
    }

    public $data = [
        '01' => '소형견'
        ,'02' => '중형견'
        ,'03' => '대형견'
        ,'04' => '고양이'
        ,'05' => '조류'
    ];

    public function run()
    {
        foreach($this->data as $key => $value){
            $this->saveAnimalType($value, $key);
        }
    }
}
