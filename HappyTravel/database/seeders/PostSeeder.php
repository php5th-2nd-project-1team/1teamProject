<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
	/**
	 *  그냥 데이터
	 *  우아하게 하려고 했는데, 그냥 노가다가 더 빠를거 같음
	 */
	public $datas01_hotel = [
		[
			'local_num' => '03'
			,'theme_num' => '01'
			,'local_name' => '강원 강릉시'
			,'title' => '세인트존스 경포 호텔'
			,'img' => '/developImg/about-three3.png'
		]
	];
	public $datas01_fantion = [
		
	];
	public $datas03 = [
		[
			'local_num' => '02'
			,'theme_num' => '03'
			,'local_name' => '경기 안산시'
			,'title' => '부곡산림욕장 유아숲체험원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '07'
			,'theme_num' => '03'
			,'local_name' => '충북 청주시'
			,'title' => '오창저수지'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '07'
			,'theme_num' => '03'
			,'local_name' => '충북 청주시'
			,'title' => '오창미래지농통테마공원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '13'
			,'theme_num' => '03'
			,'local_name' => '제주 서귀포시'
			,'title' => '오조리마을'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '02'
			,'theme_num' => '03'
			,'local_name' => '경기 시흥시'
			,'title' => '오이도'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '11'
			,'theme_num' => '03'
			,'local_name' => '전북 임실군'
			,'title' => '오수휴게소 반려견놀이터'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '11'
			,'theme_num' => '03'
			,'local_name' => '전북 임실군'
			,'title' => '오수의견공원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '07'
			,'theme_num' => '03'
			,'local_name' => '충북 청주시'
			,'title' => '오송호수공원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '11'
			,'theme_num' => '03'
			,'local_name' => '전북 전주시'
			,'title' => '오송제'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '13'
			,'theme_num' => '03'
			,'local_name' => '제주 서귀포시'
			,'title' => '오설록티뮤지엄'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '02'
			,'theme_num' => '03'
			,'local_name' => '경기 오산시'
			,'title' => '오산반려동물테마파크'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '06'
			,'theme_num' => '03'
			,'local_name' => '대전 유성구'
			,'title' => '오리골근린공원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '03'
			,'local_name' => '부산 남구'
			,'title' => '오륙도가원'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '12'
			,'theme_num' => '03'
			,'local_name' => '전남 신안구'
			,'title' => '오도선착장'
			,'img' => '/developImg/about-three1.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '03'
			,'local_name' => '경북 포항시'
			,'title' => '오도1리간이해수욕장'
			,'img' => '/developImg/about-three1.png'
		]
	];
	public $datas04 = [
		[
			'local_num' => '09'
			,'theme_num' => '04'
			,'local_name' => '대구 달성군'
			,'title' => '119동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '08'
			,'theme_num' => '04'
			,'local_name' => '충남 서산시'
			,'title' => '서산동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '13'
			,'theme_num' => '04'
			,'local_name' => '제주 제주시'
			,'title' => '서사라동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '04'
			,'local_name' => '부산 사상구'
			,'title' => '서부산동물메디컬센터'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '02'
			,'theme_num' => '04'
			,'local_name' => '경기 안성시'
			,'title' => '서부동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '04'
			,'local_name' => '경북 경주시'
			,'title' => '건국동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '01'
			,'theme_num' => '04'
			,'local_name' => '서울 강북구'
			,'title' => '24시루시드동물메디컬센터'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '04'
			,'local_name' => '부산 부산진구'
			,'title' => '서면Q 외과 동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '09'
			,'theme_num' => '04'
			,'local_name' => '부산 부산진구'
			,'title' => '서면동물병원'
			,'img' => '/developImg/about-three2.png'
		]
		,[
			'local_num' => '01'
			,'theme_num' => '04'
			,'local_name' => '서래동물병원'
			,'title' => '서울 서초구'
			,'img' => '/developImg/about-three2.png'
		]
	];
	/**
	 * Post 데이터 삽입하는 함수
	 * 
	 * @param string 지역번호
	 * @param string 테마번호
	 * @param string 장소이름
	 * @param string 제목
	 * @param string 간단소개
	 * @param string 자세히 소개
	 * @param string 이미지 경로
	 */
	public function savePost($local_num, $theme_num, $local_name, $title, $content, $detail_content, $img){
		$post = new Post();
		$post->manager_id = rand(1,4);
		$post->category_local_num = $local_num;
		$post->category_theme_num = $theme_num;
		$post->post_local_name = $local_name;
		$post->post_title = $title;
		$post->post_content = $content;
		$post->post_detail_content = $detail_content;
		$post->post_img = $img;
		$post->save();
	}

	public function run()
	{
		// $response = Http::withHeaders([
		// 	'Accept' => 'application/json',
		// ])->get('http://api.kcisa.kr/openapi/API_TOU_050/request?serviceKey=ed9c0929-f4f3-4eb1-94aa-93a48cc3c0b0&numOfRows=15&pageNo=1&category=%EC%97%AC%ED%96%89%EC%A7%80');
		
		// $data = $response->json();

		// Log::debug('0번 데이터 출력 : '.$data['response']['body']['items']['item'][0]['title']);
		$faker = Faker::create('ko_KR');

		// Log::debug('faker test : '.$faker->realText(50));

		foreach($this->datas01_hotel as $value){
			$this->savePost($value['local_num'], $value['theme_num'], $value['local_name'], $value['title'], $faker->realText(50), $faker->realText(500), $value['img']);
		}
	}
}
