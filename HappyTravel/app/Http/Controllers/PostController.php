<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Models\AnimalType;
use App\Models\FacilityType;
use App\Models\Post;
use App\Models\PostAnimalType;
use App\Models\PostComments;
use App\Models\PostDetail;
use App\Models\PostFacilityType;
use App\Models\PostLike;
use Exception;
use UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
	// 포스트 획득
	public function index(Request $request) {
		// 조건 : local은 반드시 있음
		// 조건 : key는 있을 수도, 없을 수도 있음
		$theme = $request->theme;
		$local = $request->local;
		$key = $request->search;
		$animal_type_num = $request->input('animal_type_num', []);
		$facility_type_num = $request->input('facility_type_num', []);

		// Log::debug($animal_type_num);

		// post 테마 유효성 검사 부분
		$validator = Validator::make($request->only('theme', 'animal_type_num', 'facility_type_num'), [
			'theme' => ['exists:category_themes,category_theme_num']
			,'animal_type_num' => ['exists:post_animal_types,animal_type_num']
			,'facility_type_num' => ['exists:post_facility_types,facility_type_num']
		]);

		if($validator->fails()){
			return response()->json('테마 번호 오류', 404); // 일단 404로 보냄
		}

		// 데이터 구하는 부분
		$PostList = Post::select(DB::raw('posts.*'))->distinct()->where('category_theme_num', '=', $theme)
			->when($local, function($query, $local){
			$query->where('category_local_num', '=', $local);
		})->when($key, function($query, $key){
			$query->where(function($query)use($key){
				$query->where('post_title', 'LIKE', '%' . $key . '%')
				->orWhere('post_content', 'LIKE', '%' . $key . '%')
				->orWhere('post_detail_content', 'LIKE', '%' . $key . '%');
			});
		})
		->when($animal_type_num, function($query, $animal_type_num) {
			$query->leftJoin('post_animal_types', 'posts.post_id', '=', 'post_animal_types.post_id')
					->whereNull('post_animal_types.deleted_at');
		})
		->when($facility_type_num, function($query, $facility_type_num) {
			$query->leftJoin('post_facility_types', 'posts.post_id', '=', 'post_facility_types.post_id')
					->whereNull('post_facility_types.deleted_at');
		})
		->where(function($query) use($animal_type_num, $facility_type_num){
			$query->when($animal_type_num, function($query, $animal_type_num){
				$query->where(function($query)use($animal_type_num){
					$query->whereIn('post_animal_types.animal_type_num', $animal_type_num)->where('post_animal_types.using', '=', '1');
				});
			})
			->when($facility_type_num, function($query, $facility_type_num){
				$query->orWhere(function($query)use($facility_type_num){
					$query->whereIn('post_facility_types.facility_type_num', $facility_type_num)->where('post_facility_types.using', '=', '1');
				});
			});
		})->orderBy('posts.created_at', 'DESC')->withCount('postLikes')->paginate(8);

		// 개수 구하는 부분
		$postListCnt = Post::select(DB::raw('COUNT(DISTINCT posts.post_id) as count'))->where('category_theme_num', '=', $theme)
			->when($local, function($query, $local){
			$query->where('category_local_num', '=', $local);
		})->when($key, function($query, $key){
			$query->where(function($query)use($key){
				$query->where('post_title', 'LIKE', '%' . $key . '%')
				->orWhere('post_content', 'LIKE', '%' . $key . '%')
				->orWhere('post_detail_content', 'LIKE', '%' . $key . '%');
			});
		})
		->when($animal_type_num, function($query, $animal_type_num) {
			$query->leftJoin('post_animal_types', 'posts.post_id', '=', 'post_animal_types.post_id')
					->where('post_animal_types.using', '=', '1')->whereNull('post_animal_types.deleted_at');
		})
		->when($facility_type_num, function($query, $facility_type_num) {
			$query->leftJoin('post_facility_types', 'posts.post_id', '=', 'post_facility_types.post_id')
					->where('post_facility_types.using', '=', '1')->whereNull('post_facility_types.deleted_at');
		})
		->where(function($query) use($animal_type_num, $facility_type_num){
			$query->when($animal_type_num, function($query, $animal_type_num){
				$query->where(function($query)use($animal_type_num){
					$query->whereIn('post_animal_types.animal_type_num', $animal_type_num)->where('post_animal_types.using', '=', '1');
				});
			})
			->when($facility_type_num, function($query, $facility_type_num){
				$query->orWhere(function($query)use($facility_type_num){
					$query->whereIn('post_facility_types.facility_type_num', $facility_type_num)->where('post_facility_types.using', '=', '1');
				});
			});
		})->first();

		$responseData = [
			'success' => true
			,'msg' => '포스트 획득 성공'
			,'PostList' => $PostList->toArray()
			,'PostListCnt' => $postListCnt->count
		];

		return response()->json($responseData, 200);
	}


	public function populerPost(Request $request){
		$type = $request->type;
		$PostList = null;
		if($type === 'view'){
			$PostList = Post::withCount('postLikes')->orderBy('post_view', 'DESC')->orderBy('created_at', 'DESC')->paginate(5);
		} else if($type === 'like'){
			$PostList = Post::withCount('postLikes')
							->orderBy('post_likes_count', 'DESC') 
							->orderBy('created_at', 'DESC')
							->paginate(5);
		} else {
			$PostList = Post::withCount('postLikes')->orderBy('created_at', 'DESC')->paginate(5);
		}

		$responseData = [
			'success' => true
			,'msg' => $type.'포스트 획득 성공'
			,'PostList' => $PostList->toArray()
		];

		return response()->json($responseData, 200);
	}

	// 포스트 상세 출력
	// postDetail 도 PostController에 작성 => PostDetailController 은 불필요
	public function showPost(Request $request) {
		// 민주님, post detail에서 좋아요 버튼 눌렀을 때 로직 추가했습니다. 확인 후에 주석 지우거나 놔두시면 됩니다.

		$token = $request->bearerToken(); // 로그인 여부 확인
		
		// 중요. 만약에 vuex에서 
		// 'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
		// 로 보낼 때 localStorage.getItem('accessToken')가 null이면 보내지는 값은 null이 아니라 문자열 'null'이므로 꼭꼭 체크해야 함
		$token = $token === 'null' ? null : $token; 

		$PostComment = null;
		$PostDetail = Post::with('manager')->withCount('postLikes')->find($request->id);
		$PostComment = PostComments::with('user')->where('post_id', '=', $request->id)->orderBy('created_at', 'DESC')->paginate(5);
		$PostCommentCnt = PostComments::select('post_id', PostComments::raw('COUNT(post_comment) cnt'))
						->where('post_id', '=', $request->id)
						->groupBy('post_id')
						->first();		// 하나만 가져오기 때문에 get() 이 아니라 first() 이다.
		$PostClkLike = false; // 클릭 여부 담는 변수 추가
		// 여기에 동물 타입, 펜션 정보 입력
		$AnimalType = PostAnimalType::where('post_id', '=', $request->id)
						->join('animal_types', 'animal_types.animal_type_num', '=', 'post_animal_types.animal_type_num')
						->where('post_animal_types.using', '=', '1')
						->get();
		$FacilityType = PostFacilityType::where('post_id', '=', $request->id)
						->join('facility_types', 'facility_types.facility_type_num', '=', 'post_facility_types.facility_type_num')
						->where('post_facility_types.using', '=', '1')
						->get();

		// 필터 출력(중복때메 상단에 동물타입,시설타입 쪼갬)
		// $PostFilter = Post::select('posts.post_id', 'animal_types.animal_type_name', 'facility_types.facility_type_name')
		// 				->leftJoin('post_animal_types', 'posts.post_id', '=', 'post_animal_types.post_id')->whereNull('post_animal_types.deleted_at')
		// 				->leftJoin('post_facility_types', 'posts.post_id', '=', 'post_facility_types.post_id')->whereNull('post_facility_types.deleted_at')
		// 				->leftJoin('animal_types', 'post_animal_types.animal_type_num', '=', 'animal_types.animal_type_num')
		// 				->leftJoin('facility_types', 'post_facility_types.facility_type_num', '=', 'facility_types.facility_type_num')
		// 				->where('posts.post_id', '=', $id)
		// 				->get();
		
		// if (is_null($token)) {
		// 	Log::info('진짜 토큰 null임');
		// } elseif ($token === '') {
		// 	Log::info('빈 문자열임');
		// } else {
		// 	Log::info('값을 가지고 있음: ', ['token' => $token]);
		// }

		// Log::debug(is_null($token));

		// 로그인 했으면 해당 유저가 좋아요 눌렀는지 안눌렀는지 확인
		if(!is_null($token)){

			$idt = UserToken::getInPayload($token, 'idt');
			$clkData = PostLike::where('user_id', '=', $idt)->where('post_id', '=', $request->id)->first();

			if(!is_null($clkData)){
				$PostClkLike = $clkData->post_likes_flg === '1' ? true : false;
			}
		}

		// 조회수 쿠키없으면 쿠키에 저장
		if(!isset($_COOKIE['views'.$request->id])){
			DB::beginTransaction();
			// 조회수 추가
			$PostDetail->post_view += 1;
			$PostDetail->save();
			DB::commit();

			setcookie('views'.$request->id , true, time() + 60 * 60 * 24);
		}

		Log::debug('postCommentCnt');
		Log::debug($PostCommentCnt);

		$responseData = [
			'success' => true
			,'msg' => '포스트 상세 출력'
			,'PostDetail' => $PostDetail->toArray() 
			,'PostComment' => $PostComment->toArray()
			,'PostCommentCnt' => $PostCommentCnt !== null ? $PostCommentCnt->toArray() : ["post_id" => $request->id, "cnt" => 0]
			,'PostClkLike' => $PostClkLike
			,'AnimalType' => $AnimalType ->toArray()
			,'FacilityType' => $FacilityType->toArray()
			// ,'PostFilter' => $PostFilter
		];

		return response()->json($responseData, 200);
	}

	// 영광의 상처(필터 이름 출력)
	// public function postFilter(Request $request) {
	// 	$Post = Post::where('post_id', '=', $id)->first();
	// 	$AnimalType = PostAnimalType::where('post_id', '=', $id)
	// 					->join('animal_types', 'animal_types.animal_type_num', '=', 'post_animal_types.animal_type_num')->get();
	// 	$FacilityType = PostFacilityType::where('post_id', '=', $id)
	// 					->join('facility_types', 'facility_types.facility_type_num', '=', 'post_facility_types.facility_type_num')->get();

	// 	$responseData = [
	// 		'success' => true
	// 		,'msg' => '포스트 필터 출력'
	// 		,'Post' => $Post -> toArray()
	// 		,'AnimalType' => $AnimalType ->toArray()
	// 		,'FacilityType' => $FacilityType->toArray()
	// 	];

	// 	return response()->json($responseData, 200);
	// }

	// 실제로 댓글 페이지네이션시 PostComment 만 쓰면 얘만 쓰는 함수를 따로 빼야함
	public function getComment(Request $request) {
		$PostComment = null;
		$PostComment = PostComments::with('user')->where('post_id', '=', $request->id)->whereNull('deleted_at')->orderBy('created_at', 'DESC')->paginate(5);

		$responseData = [
			'success' => true
			,'msg' => '포스트 코멘트 출력'
			,'PostComment' => $PostComment->toArray()
		];

		return response()->json($responseData, 200);
	}
	
	// 포스트 댓글 작성
	public function storePostComment(StoreCommentRequest $request, $id) {
		// 로컬스토리지에 토큰이 없을시 작성안됨 조건도 넣기
		$token = $request->bearerToken();

		if(!$token) {
			return response()->json([
				'success' => false
				,'msg' => '로그인한 유저만 댓글을 작성할 수 있습니다.'
			], 400);
		}
		// 유효성 체크
		$insertData = $request->only('post_comment');
		$insertData['user_id'] = UserToken::getInPayload($token, 'idt');
		$insertData['post_id'] = $id;

		// insert
		$storePostComment = PostComments::create($insertData);

		$storePostComment->load('user');

		$responseData = [
			'success' => true
			,'msg' => '포스트 댓글 작성 성공'
			,'storePostComment' => $storePostComment->toArray()
		];

		return response()->json($responseData, 200);
	}

	// 포스트 댓글 삭제
	public function deletePostComment( $id) {
		DB::beginTransaction();
		// TODO: destroy시 $id값이 성공할시 commit 실패할시 rollback 추가해야함(지금은 commit하기만 함)
		PostComments::destroy($id);
		DB::commit();

		$responseData = [
			'success' => true
			,'msg' => '포스트 코멘트 삭제'
		];
		return response()->json($responseData, 200);
	}

	// public function deletePostComment(Request $request) {
	// 	DB::beginTransaction();
	// 	$comment = PostComments::find($request->post_comment_id);
	// 	$comment->deleted_at = now();
	// 	$comment->save();
	// 	$comment->delete();

	// 	$PostComment = PostComments::with('user')->where('post_id', '=', $id)
	// 					->whereNull('deleted_at')
	// 					->orderBy('created_at', 'DESC')
	// 					->paginate(5);

	// 	$responseData = [
	// 		'success' => true
	// 		,'msg' => '포스트 코멘트 삭제'
	// 		,'PostComment' => $PostComment->toArray()
	// 	];
	// 	DB::commit();	
	// 	return response()->json($responseData, 200);
	// }

		/**
	 * 포스트 좋아요 클릭 관련 여부
	 * 
	 */
	public function postLike(Request $request, $id){
		$token = $request->bearerToken();
		$user_id = UserToken::getInPayload($token, 'idt');
		$post_id = $id;
		$post_likes_flg = $request->post_likes_flg;

		DB::beginTransaction();

		$like_flg = PostLike::upsert([
			['user_id' => $user_id, 'post_id' => $post_id, 'post_likes_flg' => $post_likes_flg]
		], ['user_id', 'post_id' ,'post_likes_flg']
		,['post_likes_flg']);

		DB::commit();

		$resultData = PostLike::where('user_id', $user_id)
								->where('post_id', $post_id)
								->first();

		$responseData = [
			'success' => true
			,'msg' => '포스트 좋아요 클릭 여부'
			,'like_flg' => $resultData->toArray()
		];

		return response()->json($responseData, 200);
	}

	// // 포스트 필터(동물종류, 시설)
	// public function postFilter(Request $request) {
	// 	$animal_type_num = $request->animal_type_num;
	// 	$facility_type_num = $request->facility_type_num;

	// 	// $postAnimalType = PostAnimalType::where('post_id', $post_id)
	// 	// 							->where('animal_type_num', $animal_type_num);
	// 	// $postFacilityType = PostFacilityType::where('post_id', $post_id)
	// 	// 									->where('facility_type_num', $facility_type_num);
	// 	$postAnimalType = PostAnimalType::where('animal_type_num', $animal_type_num);
	// 	$postFacilityType = PostFacilityType::where('facility_type_num', $facility_type_num);									

	// 	$responseData = [
	// 		'success' => true
	// 		,'msg' => '포스트 필터 적용'
	// 		,'postAnimalFilter' => $postAnimalType->toArray()
	// 		,'postFacilityFilter' => $postFacilityType->toArray()
	// 	];
	// 	return response()->json($responseData, 200);
	// }
	public function indexPost(Request $request) {
		$IndexPost = Post::select('posts.post_id','posts.post_title', 'posts.post_img', 'posts.post_local_name', 'posts.category_theme_num', 'category_themes.category_theme_name')
							->join('category_themes', 'posts.category_theme_num', '=', 'category_themes.category_theme_num')
							->where('posts.category_theme_num', $request->category_theme_num)
							->orderBy('posts.created_at', 'DESC')
							->limit(4)
							->get();
		$responseData = [
			'success' => true
			,'msg' => '인덱스 포스트 출력'
			,'IndexPost' => $IndexPost->toArray()
		];

		return response()->json($responseData, 200);
	}
}


