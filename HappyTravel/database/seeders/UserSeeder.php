<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
       $data= [
            ['account'=> 'admin1','password' =>Hash::make('admin'), 'profile' => '/profile/default.png','name'=>'홍길동','nickname'=>'홍길동',
            'gender' => '0','address' => '00시 00구 ','detail_address' => '00동00호','phone_number'=>'010-1234-123','post_code' =>'123'],
        ];
        foreach($data as $item) {
            User::create($item);
        }
    }
}
