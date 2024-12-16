<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostDetailSeeder extends Seeder
{
	public function run()
    {
        // API 호출
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('http://api.kcisa.kr/openapi/API_TOU_050/request?serviceKey=ed9c0929-f4f3-4eb1-94aa-93a48cc3c0b0&numOfRows=5&pageNo=1&category=%EC%97%AC%ED%96%89%EC%A7%80');

        // API로부터 받은 데이터를 배열로 변환
        $data = json_decode($response->body(), true);

        // API 응답 구조 확인
        //Log::info($data); // 응답 구조를 확인하기 위한 로그

        foreach ($data['response']['body']['items']['item'] as $item) {
            // API의 title 값과 일치하는 post_title을 가진 Post 찾기
            $post = Post::where('post_title', $item['title'])->first();

            // post가 존재하는 경우에만 진행
            if ($post) {
                $post_id = $post->post_id; // 찾은 포스트의 post_id
                $manager_id = $post->manager_id; // manager_id도 가져옵니다.

                // API에서 필요한 데이터 추출
                $post_detail_num = is_null($item['tel']) ? '0' : $item['tel']; // tel이 null이면 '0', 아니면 원래 값
                $post_detail_addr = is_null($item['address']) ? '' : $item['address']; // address가 null이면 빈 문자열
                $post_detail_time = is_null($item['description']) ? null : $this->extractOperatingHoursAndHolidays($item['description']); // description이 null이면 null
                $post_detail_site = is_null($item['url']) ? null : $item['url']; // url이 null이면 null
                $post_detail_price = is_null($item['charge']) ? null : $item['charge']; // charge가 null이면 null
                $post_detail_parking = (strpos($item['description'], '주차가능') !== false) ? 1 : 0; // 주차 가능 여부

                // PostDetail 모델 인스턴스 생성
                $postDetail = new PostDetail();
                $postDetail->post_id = $post_id;
                $postDetail->manager_id = $manager_id;
                $postDetail->post_detail_num = $post_detail_num;
                $postDetail->post_detail_addr = $post_detail_addr;
                $postDetail->post_detail_time = $post_detail_time;
                $postDetail->post_detail_site = $post_detail_site;
                $postDetail->post_detail_price = $post_detail_price;
                $postDetail->post_detail_parking = $post_detail_parking;

                // 데이터 저장
                $postDetail->save();
            } else {
                Log::warning("Post not found for title: {$item['title']}"); // post_title이 없을 경우 경고 로그
            }
        }
    }

    // 운영시간과 휴무일 추출하는 함수
    private function extractOperatingHoursAndHolidays($description)
    {
        // 운영시간과 휴무일을 |로 구분하여 추출
        preg_match('/운영시간\s*:\s*(.*?)\s*\|\s*휴무일\s*:\s*(.*?)(?:\s*\|)?/', $description, $matches);

        // 운영시간과 휴무일을 추출
        $operating_hours = isset($matches[1]) ? trim($matches[1]) : null;
        $holidays = isset($matches[2]) ? trim($matches[2]) : null;

        // 결과를 포맷하여 반환
        if ($operating_hours) {
            return '운영시간: ' . $operating_hours . ($holidays ? ', 휴무일: ' . $holidays : '');
        }

        return null; // 운영시간이 없으면 null 반환
    }
}
