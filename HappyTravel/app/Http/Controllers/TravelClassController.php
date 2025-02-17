<?php

namespace App\Http\Controllers;

use App\Models\ProductLike;
use App\Models\Purchase;
use App\Models\TravelClass;
use UserToken;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TravelClassController extends Controller
{
    public function shopsBoardList(Request $request) {
        // 쿼리 파라미터 가져오기
        $currentDate = $request->query('current'); // 'current' 값
        // $page = $request->query('page', 1);    

        $shopBoardList = TravelClass::whereDate('class_date', $currentDate)->whereNull('deleted_at')->orderBy('created_at', 'DESC')->paginate(12);

        $shopBoardList->getCollection()->transform(function ($item) {
            // 각 항목의 `class_price`를 포맷팅
            $item->class_date = Carbon::parse($item->class_date)->toDateString();
            $item->class_price = number_format($item->class_price, 0, '.', ',');
            return $item;
        });

        $responseData = [
			'success' => true
			,'msg' => 'shop 리스트 출력'
			,'shopBoardList' => $shopBoardList->toArray()
		];

        return response()->json($responseData, 200);
    }

    public function shopsBoardDetail($id) {

        $shopBoardDetail = TravelClass::find($id);

        // 가격 포맷팅 (천 단위 구분 기호 추가)
        if ($shopBoardDetail) {
            $shopBoardDetail->class_price = number_format($shopBoardDetail->class_price, 0, '.', ',');
            $shopBoardDetail->class_date = Carbon::parse($shopBoardDetail->class_date)->toDateString();
        }

        $responseData = [
			'success' => true
			,'msg' => 'shop 상세 출력'
			,'shopBoardDetail' => $shopBoardDetail->toArray()
		];

        return response()->json($responseData, 200);

    }

    public function requestPayment(Request $request) {
        // 프론트엔드에서 받은 결제 정보
        $purchasePrice = $request->input('purchase_price');
        $userId = $request->input('user_id');
        $contact = $request->input('contact');
        $reservationsName = $request->input('reservations_name');
        $animalType = $request->input('animal_type');
        $notes = $request->input('notes');
        $classId = $request->input('class_id');
        $reservations_number = $request->input('reservations_number');

        $insertData = [];
        $insertData['purchase_price'] = $purchasePrice;
        $insertData['user_id'] = $userId;
        $insertData['contact'] = $contact;
        $insertData['reservations_name'] = $reservationsName;
        $insertData['animal_type'] = $animalType;
        $insertData['notes'] = $notes;
        $insertData['class_id'] = $classId;
        $insertData['reservations_number'] = $reservations_number;

        Purchase::create($insertData);
        
        // 고유한 주문 ID 생성 (merchant_uid)
        $merchantUid = $classId;

        // 결제 금액
        $amount = $purchasePrice;

        // 결제 정보 반환
        return response()->json([
            'merchant_uid' => $merchantUid,
            'amount' => $amount,
        ]);
    }

    // 결제 승인 API
    public function confirmPayment(Request $request)
{
    // 프론트엔드에서 받은 imp_uid
    $impUid = $request->input('imp_uid');
    
    // 로그로 impUid 출력 (배열이 아닌 값은 그대로 출력)
    Log::info('U_Id 결과 : '.$impUid);

    // impUid가 배열이라면 첫 번째 값만 사용
    // if (is_array($impUid)) {
    //     $impUid = implode($impUid); // 배열을 문자열로 변환
    // }

    // IAMPORT 액세스 토큰 요청
    // $apiKey = '5735356664718760'; // IAMPORT API Key
    // $apiSecret = 'uQIvQNj8qk6HGJ4pYuXmOGtnH23g1C7tdSchZpCtMbbSPLcD95hDWCnuWpMMBpnGkJMcy55KgqyviMyt'; // IAMPORT API Secret
    $client = new Client();
    
     try {
            // 토큰 요청
            $responseToken = $client->post('https://api.iamport.kr/users/getToken', [
                'json' => [
                    'imp_key' => env('IAMPORT_API_KEY'),
                    'imp_secret' => env('IAMPORT_SECRET_KEY')
                ]
            ]);
            
            $tokenData = json_decode($responseToken->getBody()->getContents(), true);

            if (isset($tokenData['response']['access_token'])) {
                $accessToken = $tokenData['response']['access_token'];
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => '액세스 토큰을 가져오는데 실패했습니다.',
                ]);
            }

            // 결제 확인 요청
            $response = $client->get('https://api.iamport.kr/payments/' . $impUid, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ]
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            // 응답 코드 확인 후 결제 성공 처리
            if (isset($responseBody['code']) && $responseBody['code'] === 0) {
                Log::info('결제 확인 성공:', ['response' => $responseBody]);
                return response()->json([
                    'status' => 'success',
                    'message' => '결제가 성공적으로 완료되었습니다.',
                ]);
            } else {
                Log::error('결제 확인 실패:', ['response' => $responseBody]);
                return response()->json([
                    'status' => 'failed',
                    'message' => '결제에 실패했습니다.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('API 요청 실패:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'failed',
                'message' => '결제 요청 처리 중 오류가 발생했습니다.',
            ]);
        }
    }

	/**
	 * 클래스 좋아요 클릭 관련 여부
	 * 
	 */
	public function classLike(Request $request, $id){
		$token = $request->bearerToken();
		$user_id = UserToken::getInPayload($token, 'idt');
		$class_id = $id;
		$class_likes_flg = $request->class_likes_flg;

		DB::beginTransaction();

		$like_flg = ProductLike::upsert([
			['user_id' => $user_id, 'class_id' => $class_id, 'class_likes_flg' => $class_likes_flg]
		], ['user_id', 'class_id' ,'class_likes_flg']
		,['class_likes_flg']);

		DB::commit();

		$classLikeFlg = ProductLike::where('user_id', $user_id)
								->where('class_id', $class_id)
								->first();

		$responseData = [
			'success' => true
			,'msg' => '클래스 좋아요 클릭 여부'
			,'classLikeFlg' => $classLikeFlg->toArray()
		];

		return response()->json($responseData, 200);
	}


    // 인덱스 상품 전체 출력
    public function indexShop(Request $request) {
        $IndexShop = TravelClass::select('*')
                    ->whereNull('travel_classes.deleted_at')
                    ->orderBy('travel_classes.created_at', 'DESC')
                    ->limit(3)
                    ->get();

        $responseData = [
            'success' => true
            ,'msg' => '인덱스 상품 출력'
            ,'IndexShop' => $IndexShop->toArray()
        ];

        return response()->json($responseData, 200);
    }
}
