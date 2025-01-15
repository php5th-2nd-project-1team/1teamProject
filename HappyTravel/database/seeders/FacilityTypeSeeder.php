<?php

namespace Database\Seeders;

use App\Models\FacilityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function saveFacilityType($facility_type_name, $facility_type_num)
    {
        $facilityType = new FacilityType();
        $facilityType->facility_type_name = $facility_type_name;
        $facilityType->facility_type_num = $facility_type_num;
        $facilityType->save();
    }

    public $data = [
        '01' => '펫메뉴'
        ,'02' => '드라이룸'
        ,'03' => '애견수영장'
        ,'04' => '애견놀이터'
        ,'05' => '잔디마당'
    ];

    public function run()
    {
        foreach($this->data as $key => $value){
            $this->saveFacilityType($value, $key);
        }
    }
}
