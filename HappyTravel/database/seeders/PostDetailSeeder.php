<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostDetailSeeder extends Seeder
{
	public $datas_01hotel = [
		[
			'post_id' => 27
			,'phoneNum' => '033-660-9000'
			,'addr' => '강원도 강릉시 창해로 307'
			,'time' => '매일 16:00~11:00'
			,'site' => 'https://new.stjohns.co.kr/'
			,'price' => '변동. 애견 동반 추가 요금 : 35,000원'
			,'parking' => true
		]
	];

	public function mySavePostDetail($post_id, $manager_id, $phoneNum, $addr, $time, $site, $price, $parking){
		$detail = new PostDetail();
		$detail->post_id = $post_id;
		$detail->manager_id = $manager_id;
		$detail->post_detail_num = $phoneNum;
		$detail->post_detail_addr = $addr;
		$detail->post_detail_time = $time;
		$detail->post_detail_site = $site;
		$detail->post_detail_price = $price;
		$detail->post_detail_parking = $this->getParkingAble($parking);
		$detail->save();
	}
	public function getParkingAble($able){
		if(gettype($able) === 'boolean'){
			return $able;
		}

		switch($able){
			case '1':
				return true;
			case '0':
				return false;
			default :
				return false;
		}
	}
	public function run()
	{
		foreach($this->datas_01hotel as $value){
			$manager_id = Post::select('manager_id')->where('post_id', '=' ,$value['post_id'])->first()->manager_id;
			$this->mySavePostDetail($value['post_id'], $manager_id, $value['phoneNum'], $value['addr'], $value['time'], $value['site'], $value['price'], $value['parking']);
		}
	}
}
