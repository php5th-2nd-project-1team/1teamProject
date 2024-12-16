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
    public function run()
    {
		$faker = Faker::create('ko_KR'); // 한국어 로케일 설정

        // API 호출, 헤더에 application/json 추가
        $response = Http::withHeaders([
            'Accept' => 'application/json', // JSON 형식으로 요청
        ])->get('http://api.kcisa.kr/openapi/API_TOU_050/request?serviceKey=ed9c0929-f4f3-4eb1-94aa-93a48cc3c0b0&numOfRows=5&pageNo=1&category=%EC%97%AC%ED%96%89%EC%A7%80');

        // API로부터 받은 데이터를 배열로 변환
        $data = json_decode($response->body(), true);

        // 지역 코드 매핑
        $category_local_map = [
            '서울' => '01',
            '경기도' => '02',
            '강원도' => '03',
            '인천' => '04',
            '세종' => '05',
            '대전' => '06',
            '충청북도' => '07',
            '충청남도' => '08',
            '경상북도' => '09',
            '경상남도' => '10',
            '전라북도' => '11',
            '전라남도' => '12',
            '제주특별자치도' => '13',
        ];


        Log::debug($data);

        foreach ($data['response']['body']['items']['item'] as $item) {
			// 주소에서 우편번호 및 괄호 제거
			$post_local_name = preg_replace('/\(\d+\)\s?/', '', $item['address']); // 괄호와 그 안의 숫자 제거
			
			// 주소를 공백 기준으로 분리
			$address_parts = explode(' ', trim($post_local_name));

			// '도', '시'만 포함하여 재구성
			$post_local_name = '';
			if (count($address_parts) >= 2) {
				// '도'와 '시'가 있는 경우
				$post_local_name = implode(' ', array_slice($address_parts, 0, 2)); // 처음 2개 부분을 합쳐서 '도 시' 형태
			}

			// category_local_num 설정
			$category_local_num = isset($category_local_map[$address_parts[0]]) ? $category_local_map[$address_parts[0]] : null;

            // 한글 난수 생성
            $post_content = $faker->realText(50); // 50자 이내의 한글 난수
            $post_detail_content = $faker->realText(500); // 500자 이내의 한글 난수

            // 좌표 추출
			list($post_lat, $post_lon) = $this->extractCoordinates($item['coordinates']);

            // Post 모델을 사용하여 데이터 삽입
            $post = new Post();
			$post->manager_id = rand(1,4);
            $post->post_local_name = $post_local_name;
            $post->post_title = $item['title'];
            $post->post_content = $post_content;
            $post->post_detail_content = $post_detail_content;
            $post->post_img = '/developImg/post-content-img.png';
            $post->post_subimg1 = '/developImg/about-three1.png';
            $post->post_subimg2 = '/developImg/about-three2.png';
            $post->post_subimg3 = '/developImg/about-three3.png';
            $post->post_lat = $post_lat;
            $post->post_lon = $post_lon;
            $post->category_local_num = $category_local_num;
            $post->category_theme_num = '03';
            $post->created_at = now();
            $post->updated_at = now();

            // 데이터 저장
            $post->save();
        }
    }
	// 좌표 추출 함수
	private function extractCoordinates($coordinates)
	{
		// 좌표 문자열에서 'N'과 'E'를 제거하고 쉼표로 나눕니다.
		$coordinates = str_replace(['N', 'E'], '', $coordinates); // N과 E 제거
		$parts = preg_split('/[\s,]+/', trim($coordinates)); // 공백과 쉼표를 기준으로 분리
	
		$post_lat = null;
		$post_lon = null;
	
		// 분리된 배열에서 위도와 경도를 설정
		if (count($parts) === 2) {
			$post_lat = trim($parts[0]); // 위도
			$post_lon = trim($parts[1]); // 경도
		}
	
		return [$post_lat, $post_lon];
	}
}
