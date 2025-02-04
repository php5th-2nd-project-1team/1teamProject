<?php

namespace App\Http\Controllers\Managers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\AnimalType;
use App\Models\CategoryLocal;
use App\Models\CategoryTheme;
use App\Models\FacilityType;
use App\Models\Manager;
use App\Models\Notice;
use App\Models\Post;
use App\Models\PostAnimalType;
use App\Models\PostComments;
use App\Models\PostFacilityType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller 
{
	// 계정 영역
	// 로그인 처리
	public function login(Request $request){

		$validator = Validator::make($request->only('m_account', 'm_password'), [
			'm_account' => ['required', 'exists:managers,m_account'],
			'm_password' => ['required']
		]);

		if($validator->fails()){
			return redirect()->route('manager.login')->withErrors($validator)->withInput();
		}

		$manager = Manager::where('m_account', $request->m_account)->first();

		if(!Hash::check($request->m_password, $manager->m_password)){
			return redirect()->route('manager.login')->withErrors(['message' => '비밀번호가 일치하지 않습니다.'])->withInput();
		}

		Auth::guard('manager')->login($manager);

		return redirect()->route('manager.index');
	}

	// 로그아웃 처리
	public function logout(){
		Auth::guard('manager')->logout();
		Session::invalidate();
		Session::regenerateToken();
		return redirect()->route('manager.login');
	}

	// 계정 영역 끝

	// 인덱스 영역
	public function index(){

		$users = User::orderBy('created_at', 'desc')->limit(5)->get();

		$posts = $posts = Post::select(
					'posts.*',
					'c.comment_created_at',
					'c.comment_count'
					)
					->join(DB::raw(
						'(SELECT 
							post_comments.post_id AS c_id, 
							max(post_comments.created_at) AS comment_created_at, 
							count(post_comments.post_id) AS comment_count
						FROM post_comments
						WHERE post_comments.deleted_at IS null
						GROUP BY post_comments.post_id
						) AS c'
					), 'posts.post_id', '=', 'c.c_id')
					->orderBy('c.comment_created_at', 'desc')
					->limit(5)
					->get();

		// TODO 문의, 신고 준비되면 추가

		return view('manager.layout.index')
		->with(
			['users' => $users
			,'posts' => $posts]
		);
	}

	// 메인페이지 영역 끝
	// 유저 영역
	public function users(){
		$users = User::orderBy('created_at', 'desc')->paginate(10);
		return view('manager.layout.users.users')->with('users', $users);
	}

	// 유저 상세 정보
	public function usersDetail($id){
		$user = User::find($id);
		$commentCount = PostComments::where('user_id', $id)->count();
		$page = request()->query('page', 1);  // 현재 페이지에서 page 파라미터 값을 가져오는데, 없으면 1을 기본값으로 사용함
		
		return view('manager.layout.users.usersDetail')
			->with('user', $user)
			->with('commentCount', $commentCount)
			->with('page', $page);
	}

	// 유저 영역 끝
	// 포스트 영역
	// 포스트 목록 조회
	public function posts(){
		$posts = Post::
			orderBy('created_at', 'desc')->
			withCount('postLikes')->
			paginate(10);

		$page = request()->query('page', 1);

		// 예외처리 : 입력받은 페이지 번호가 1 이하라면 1페이지로 리다이렉트
		if ($page < 1) {
			return redirect()->route('post.posts', ['page' => 1]);
		}

		// 예외처리 : 입력받은 페이지 번호가 마지막 페이지 번호보다 크다면 마지막 페이지로 리다이렉트
		if($page > $posts->lastPage()){
			return redirect()->route('post.posts', ['page' => $posts->lastPage()]);
		}

		return view('manager.layout.posts.posts')->with('posts', $posts);

	}

	// 포스트 상세 조회
	public function postsDetail($id){
		$post = Post::select('posts.*', 'managers.m_nickname as m_nickname', 'category_locals.category_local_name as category_local_name', 'category_themes.category_theme_name as category_theme_name')->
					join('managers', 'posts.manager_id', '=', 'managers.manager_id')->
					join('category_locals', 'posts.category_local_num', '=', 'category_locals.category_local_num')->
					join('category_themes', 'posts.category_theme_num', '=', 'category_themes.category_theme_num')->
					find($id);

		$postAnimalTypes = PostAnimalType::where('post_id', $id)->where('using', '1')->get();
		$postFacilities = PostFacilityType::where('post_id', $id)->where('using', '1')->get();
		$animalTypes = AnimalType::get();
		$facilities = FacilityType::get();

		$categoryLocal = CategoryLocal::get();
		$categoryTheme = CategoryTheme::get();
		
		$page = request()->query('page', 1);  // 현재 페이지 정보 가져오기

		return view('manager.layout.posts.postsDetail')
				->with('post', $post)
				->with('postAnimalTypes', $postAnimalTypes)
				->with('postFacilities', $postFacilities)
				->with('animalTypes', $animalTypes)
				->with('facilities', $facilities)
				->with('categoryLocal', $categoryLocal)
				->with('categoryTheme', $categoryTheme)
				->with('page', $page);  // 페이지 정보 전달
	}

	// 포스트 작성 (get)
	public function postCreate(){

		$categoryLocals = CategoryLocal::get();
		$categoryThemes = CategoryTheme::get();
		$animalTypes = AnimalType::get();
		$facilityTypes = FacilityType::get();

		return view('manager.layout.posts.postsCreate')
				->with('categoryLocals', $categoryLocals)
				->with('categoryThemes', $categoryThemes)
				->with('animalTypes', $animalTypes)
				->with('facilityTypes', $facilityTypes);
	}

	// 포스트 작성 (post)
	public function postStore(PostRequest $request){
		
		DB::beginTransaction();

		try{
			$inputData = new Post();

				$inputData->manager_id = Auth::guard('manager')->user()->manager_id;
				
				$inputData->category_local_num = $request->category_local_num;
				$inputData->category_theme_num = $request->category_theme_num;
				$inputData->post_title = $request->post_title;
				$inputData->post_local_name = $request->post_local_name;
				$inputData->post_content = $request->post_content;
				$inputData->post_detail_content = $request->post_detail_content;
				$inputData->post_img = '/'.$request->file('post_img')->store('img');
				$inputData->post_subimg1 = '/'.$request->file('post_subimg1')->store('img');
				$inputData->post_subimg2 = '/'.$request->file('post_subimg2')->store('img');
				$inputData->post_subimg3 = '/'.$request->file('post_subimg3')->store('img');
				$inputData->post_lat = $request->post_lat;
				$inputData->post_lon = $request->post_lon;
				$inputData->post_detail_num = is_null($request->post_detail_num) ? "0" : $request->post_detail_num;
				$inputData->post_detail_addr = $request->post_detail_addr;
				$inputData->post_detail_time = $request->post_detail_time;
				$inputData->post_detail_site = is_null($request->post_detail_site) ? null : $request->post_detail_site;
				$inputData->post_detail_price = $request->post_detail_price;
				$inputData->post_detail_parking = $request->post_detail_parking;
			$inputData->save();
		
			foreach($request->animal_type_num as $animal_type_num){
				$inputAnimalType = new PostAnimalType();
				$inputAnimalType->post_id = $inputData->post_id;
				$inputAnimalType->animal_type_num = $animal_type_num;
				$inputAnimalType->save();
			}

			foreach($request->facility_type_num as $facility_type_num){
				$inputFacilityType = new PostFacilityType();
				$inputFacilityType->post_id = $inputData->post_id;
				$inputFacilityType->facility_type_num = $facility_type_num;
				$inputFacilityType->save();
			}

			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return response()->json([
				'success' => false
				,'msg' => '포스트 작성 실패'
				,'error' => $e->getMessage()
			], 500);
		}

		return redirect()->route('post.posts.detail', ['id' => $inputData->post_id]);
	}

	// 포스트 수정(get)
	public function postEdit($id){
		$post = Post::select('posts.*', 'managers.m_nickname as m_nickname', 'category_locals.category_local_name as category_local_name', 'category_themes.category_theme_name as category_theme_name')->
			join('managers', 'posts.manager_id', '=', 'managers.manager_id')->
			join('category_locals', 'posts.category_local_num', '=', 'category_locals.category_local_num')->
			join('category_themes', 'posts.category_theme_num', '=', 'category_themes.category_theme_num')->
			find($id);

		$postAnimalTypes = PostAnimalType::where('post_id', $id)->where('using', '1')->get();
		$postFacilities = PostFacilityType::where('post_id', $id)->where('using', '1')->get();

		$categoryLocals = CategoryLocal::get();
		$categoryThemes = CategoryTheme::get();
		$animalTypes = AnimalType::get();
		$facilityTypes = FacilityType::get();
		return view('manager.layout.posts.postsUpdate')
				->with('post', $post)
				->with('postAnimalTypes', $postAnimalTypes)
				->with('postFacilities', $postFacilities)
				->with('categoryLocals', $categoryLocals)
				->with('categoryThemes', $categoryThemes)
				->with('animalTypes', $animalTypes)
				->with('facilityTypes', $facilityTypes);
	}

	// 포스트 수정(post)
	// 포스트 수정
	public function updatePost(PostRequest $request, $id){

		DB::beginTransaction();

		try{
			$inputData = Post::find($id);
				$inputData->manager_id = Auth::guard('manager')->user()->manager_id;

				// 전체 수정 부분
				$inputData->category_local_num = $request->category_local_num;
				$inputData->category_theme_num = $request->category_theme_num;
				$inputData->post_title = $request->post_title;
				$inputData->post_local_name = $request->post_local_name;
				$inputData->post_content = $request->post_content;
				$inputData->post_detail_content = $request->post_detail_content;
				$inputData->post_lat = $request->post_lat;
				$inputData->post_lon = $request->post_lon;
				$inputData->post_detail_num = is_null($request->post_detail_num) ? "0" : $request->post_detail_num;
				$inputData->post_detail_addr = $request->post_detail_addr;
				$inputData->post_detail_time = $request->post_detail_time;
				$inputData->post_detail_site = is_null($request->post_detail_site) ? null : $request->post_detail_site;
				$inputData->post_detail_price = $request->post_detail_price;
				$inputData->post_detail_parking = $request->post_detail_parking;

				// 이미지 수정 부분
				// 이미지 수정 위해 파일 업로드 시 기존 이미지 삭제 및 새 이미지로 교체
				// 왜 이렇게 해야 하는가 : 보안상 기존 파일을 input:file에 넣어줄 수 없음
				if($request->file('post_img')){
					if(Storage::exists($inputData->post_img)){
						Storage::delete($inputData->post_img);
					}
					$inputData->post_img = '/'.$request->file('post_img')->store('img');
				}
				if($request->file('post_subimg1')){
					if(Storage::exists($inputData->post_subimg1)){
						Storage::delete($inputData->post_subimg1);
					}
					$inputData->post_subimg1 = '/'.$request->file('post_subimg1')->store('img');
				}
				if($request->file('post_subimg2')){
					if(Storage::exists($inputData->post_subimg2)){
						Storage::delete($inputData->post_subimg2);
					}
					$inputData->post_subimg2 = '/'.$request->file('post_subimg2')->store('img');
				}

				if($request->file('post_subimg3')){
					if(Storage::exists($inputData->post_subimg3)){
						Storage::delete($inputData->post_subimg3);
					}
					$inputData->post_subimg3 = '/'.$request->file('post_subimg3')->store('img');
				}
			$inputData->save();
		
			PostAnimalType::where('post_id', '=', $id)->update([
				'using' => '0'
			]);
			PostFacilityType::where('post_id', '=', $id)->update([
				'using' => '0'
			]);

			foreach($request->animal_type_num as $animal_type_num){
				PostAnimalType::updateOrCreate(
				[
					'post_id' => $inputData->post_id, 
					'animal_type_num' => $animal_type_num
				], 
				[
					'using' => '1'
				]);
			}

			foreach($request->facility_type_num as $facility_type_num){
				PostFacilityType::updateOrCreate(
				[
					'post_id' => $inputData->post_id, 
					'facility_type_num' => $facility_type_num
				], 
				[
					'using' => '1'
				]);
			}

			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return response()->json([
				'success' => false
				,'msg' => '포스트 수정 실패'
				,'error' => $e->getMessage()
			], 500);
		}

		return redirect()->route('post.posts.detail', ['id' => $inputData->post_id]);
	}

	// 포스트 삭제
	public function postDestroy($id){
		try{
			DB::beginTransaction();

			$post = Post::find($id);
			$postAnimalType = PostAnimalType::where('post_id', '=', $id)->get();
			$postFacilityType = PostFacilityType::where('post_id', '=', $id)->get();

			
			$post->delete();

			foreach($postAnimalType as $animalType){
				$animalType->delete();
			}
			foreach($postFacilityType as $facilityType){
				$facilityType->delete();
			}

			DB::commit();
		} catch(Exception $e) {
			DB::rollBack();
			return response()->json([
				'success' => false
				,'msg' => '포스트 삭제 실패'
				,'error' => $e->getMessage()
			], 500);
		}

		return redirect()->route('post.posts');
	}

	// 포스트 영역 종료
	// 공지사항 영역 
	// 공지사항 리스트
	public function noticeIndex()
	{
		$notices = Notice::with('managers')
						->orderBy('created_at', 'desc')
						->paginate(10);

		$page = request()->query('page', 1);
		if ($page < 1) {
			return redirect()->route('notice.index', ['page' => 1]);
		}

		// 예외처리 : 입력받은 페이지 번호가 마지막 페이지 번호보다 크다면 마지막 페이지로 리다이렉트
		if($page > $notices->lastPage()){
			return redirect()->route('notice.index', ['page' => $notices->lastPage()]);
		}

		return view('manager.layout.notice.notices', [
			'notices' => $notices,
			'page' => $page
		]);
	}

	// 공지사항 상세
	public function noticeDetail($id){
		$notice = Notice::with('managers')->find($id);
		$page = request()->query('page', 1);

		return view('manager.layout.notice.noticesDetail', [
			'notice' => $notice,
			'page' => $page
		]);
	}

	// 공지사항 작성 (get)
	public function noticeCreate(){
		return view('manager.layout.notice.noticesCreate');
	}

	// 공지사항 작성 (post)
	public function noticeStore(Request $request){
		
		$validator = Validator::make($request->only('notice_title', 'notice_content'), [
			'notice_title' => 'required|string|max:50',
			'notice_content' => 'required|string',
		]);

		if($validator->fails()){
			return redirect()->route('notice.create')->withErrors($validator)->withInput();
		}
		
		$notice = null;
		try{

			DB::beginTransaction();
			$notice = new Notice();
				$notice->manager_id = Auth::guard('manager')->user()->manager_id;
				$notice->notice_title = $request->notice_title;
				$notice->notice_content = $request->notice_content;
				$notice->notice_tag = isset($request->notice_tag) ? '1' : '0';
				$notice->save();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return response()->json([
				'success' => false
				,'msg' => '공지사항 작성 실패'
				,'error' => $e->getMessage()
			], 500);
		}


		return redirect()->route('notice.detail', ['id' => $notice->notice_id]);
	}

	// 공지사항 수정 (get)
	public function noticeEdit($id){
		$notice = Notice::find($id);
		return view('manager.layout.notice.noticesUpdate', [
			'notice' => $notice
		]);
	}

	// 공지사항 수정 (post)
	public function noticeUpdate(Request $request, $id){

		$validator = Validator::make($request->only('notice_title', 'notice_content'), [
			'notice_title' => 'required|string|max:50',
			'notice_content' => 'required|string',
		]);

		if($validator->fails()){
			return redirect()->route('notice.edit', ['id' => $id])->withErrors($validator)->withInput();
		}

		$notice = Notice::find($id);
		try{
			DB::beginTransaction();
			$notice->notice_title = $request->notice_title;
			$notice->notice_content = $request->notice_content;
			$notice->notice_tag = isset($request->notice_tag) ? '1' : '0';
			$notice->save();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return response()->json([
				'success' => false
				,'msg' => '공지사항 수정 실패'
				,'error' => $e->getMessage()
			], 500);
		}

		return redirect()->route('notice.detail', ['id' => $notice->notice_id]);
	}

	// 공지사항 삭제
	public function noticeDestroy($id){
		try{
			DB::beginTransaction();
			$notice = Notice::find($id);
			$notice->delete();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->
			route('notice.detail', ['id' => $id])->
			withErrors(['message' => '공지사항 삭제 실패. 잠시 후 시도바람']);

			Log::error($e->getMessage());
		}

		return redirect()->route('notice.index');
	}
	// 공지사항 영역 끝 ===============================

	// 매니저 영역 시작 ================================
	// 매니저 출력
	public function managerIndex(){
		$managers = Manager::paginate(10);
		$page = request()->query('page', 1);

		if($page < 1){
			return redirect()->route('manager.managers', ['page' => 1]);
		}

		if($page > $managers->lastPage()){
			return redirect()->route('manager.managers', ['page' => $managers->lastPage()]);
		}

		return view('manager.layout.managers.managers', [
			'managers' => $managers,
			'page' => $page
		]);
	}

	// 매니저 작성
	public function managerCreate(){
		return view('manager.layout.managers.managerCreate');
	}

	public function managerStore(Request $request){
		try{
			Log::debug('삽입 시작 1' );
			foreach($request->managers as $manager){
				
			}
			// DB::beginTransaction();
			// foreach($request->managers as $manager){
			// 	$manager = new Manager();
			// 		$manager->m_account = $manager['m_account'];
			// 		$manager->m_password = Hash::make($manager['m_password']);
			// 		$manager->m_nickname = $manager['m_nickname'];
			// 	$manager->save();
			// 	Log::debug('삽입 성공 2' );
			// }
			// DB::commit();
			Log::debug('삽입 성공');
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->route('manager.store')->withErrors(['message' => '관리자 작성 실패. 잠시 후 시도바람']);
			Log::error($e->getMessage());
		}
		return redirect()->route('manager.index');
	}
}