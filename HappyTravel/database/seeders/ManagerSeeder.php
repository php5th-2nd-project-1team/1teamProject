<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data= [
        ['m_account'=> 'admin', 'm_password' =>Hash::make('admin'), 'm_nickname'=>'관리자'],
        ['m_account'=> 'admin1', 'm_password' =>Hash::make('admin1'), 'm_nickname'=>'관리자1'],
        ['m_account'=> 'admin2', 'm_password' =>Hash::make('admin2'), 'm_nickname'=>'관리자2'],
        ['m_account'=> 'admin3', 'm_password' =>Hash::make('admin3'), 'm_nickname'=>'관리자3'],
       ];
       foreach($data as $item) {
        Manager::create($item);
       }
    }
}
