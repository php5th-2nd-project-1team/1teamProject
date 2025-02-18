<?php

namespace App\Http\Controllers\Managers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\AnimalType;
use App\Models\CategoryLocal;
use App\Models\CategoryTheme;
use App\Models\FacilityType;
use App\Models\Inquiry;
use App\Models\Manager;
use App\Models\Notice;
use App\Models\Post;
use App\Models\PostAnimalType;
use App\Models\PostComments;
use App\Models\PostFacilityType;
use App\Models\Report;
use App\Models\ReportProcess;
use App\Models\TravelClass;
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

	public $reportCategory = [
		'01' => '욕설/비속어 포함'
		,'02' => '갈등 조장 및 허위사실 유포'
		,'03' => '폭력적이고 혐오스러운 콘텐츠'
		,'04' => '도배 및 광고글'
		,'05' => '기타'
	];

	public $reportPlace = [
		'01' => '포스트 댓글'
		,'02' => '커뮤니티'
		,'03' => '커뮤티니 댓글'
	];

	/**
	 * 관리자 로그인 처리
	 * 
	 * @param Request $request 로그인 폼 데이터 (계정, 비밀번호)
	 * @return 성공 시 관리자 대시보드로 이동, 실패 시 로그인 페이지로 이동
	 */
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

	/**
	 * 관리자 로그아웃 처리
	 * 세션 무효화 및 토큰 재생성
	 * 
	 * @return 로그인 페이지로 리다이렉트
	 */
	public function logout(){
		Auth::guard('manager')->logout();
		Session::invalidate();
		Session::regenerateToken();
		return redirect()->route('manager.login');
	}

	// 계정 영역 끝

	// 인덱스 영역
	/**
	 * 관리자 대시보드 메인 페이지
	 * 최근 사용자, 게시물, 신고 내역 등을 표시
	 * 
	 * @return 대시보드 메인 뷰와 함께 최근 데이터들을 전달
	 */
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

		$inquiries = Inquiry::whereNull('inquiry_response')->orderBy('created_at', 'desc')->orderBy('inquiry_id', 'desc')->limit(5)->get();

		$reports = Report::where('report_status', '=', '01')->orderBy('created_at', 'desc')->limit(5)->get();

		return view('manager.layout.index')
		->with(
			['users' => $users
			,'posts' => $posts
			,'reports' => $reports
			,'reportCategory' => $this->reportCategory
			,'reportPlace' => $this->reportPlace
			,'inquiries' => $inquiries
			]
		);
	}


	// 메인페이지 영역 끝
	// 유저 영역
	/**
	 * 사용자 목록 조회
	 * 페이지네이션 적용 (10개씩)
	 * 
	 * @return 사용자 목록 뷰와 페이지네이션된 사용자 데이터
	 */
	public function users(){
		$users = User::orderBy('created_at', 'desc')->paginate(10);
		return view('manager.layout.users.users')->with('users', $users);
	}

	/**
	 * 사용자 상세 정보 조회
	 * 사용자의 상세 정보와 댓글 수 등을 표시
	 * 
	 * @param int $id 사용자 ID
	 * @return 사용자 상세 정보 뷰와 관련 데이터
	 */
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
	/**
	 * 게시물 목록 조회
	 * 좋아요 수 포함, 삭제된 게시물도 표시
	 * 페이지네이션 적용 (10개씩)
	 * 
	 * @return 게시물 목록 뷰와 페이지네이션된 게시물 데이터
	 */
	public function posts(){
		$posts = Post::
			orderBy('created_at', 'desc')->
			withCount('postLikes')->withTrashed()->
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

	/**
	 * 게시물 상세 조회
	 * 게시물 정보, 작성자, 카테고리, 동물 유형, 시설 정보 등을 포함
	 * 
	 * @param int $id 게시물 ID
	 * @return 게시물 상세 뷰와 관련 데이터
	 */
	public function postsDetail($id){
		$post = Post::select('posts.*', 'managers.m_nickname as m_nickname', 'category_locals.category_local_name as category_local_name', 'category_themes.category_theme_name as category_theme_name')->
					join('managers', 'posts.manager_id', '=', 'managers.manager_id')->
					join('category_locals', 'posts.category_local_num', '=', 'category_locals.category_local_num')->
					join('category_themes', 'posts.category_theme_num', '=', 'category_themes.category_theme_num')->
					withTrashed()->find($id);

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

	/**
	 * 게시물 작성 폼
	 * 카테고리, 동물 유형, 시설 유형 등의 선택 옵션 제공
	 * 
	 * @return 게시물 작성 폼 뷰와 필요한 선택 옵션 데이터
	 */
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

	/**
	 * 게시물 저장 처리
	 * 이미지 업로드 및 관련 데이터 저장
	 * 트랜잭션 처리
	 * 
	 * @param PostRequest $request 유효성 검증된 게시물 데이터
	 * @return 성공 시 게시물 상세 페이지로 이동, 실패 시 에러 응답
	 */
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

	/**
	 * 게시물 수정 폼
	 * 기존 게시물 정보를 폼에 표시
	 * 
	 * @param int $id 게시물 ID
	 * @return 게시물 수정 폼 뷰와 기존 데이터
	 */
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

	/**
	 * 게시물 수정 처리
	 * 이미지 업데이트 시 기존 이미지 삭제
	 * 트랜잭션 처리
	 * 
	 * @param PostRequest $request 유효성 검증된 수정 데이터
	 * @param int $id 게시물 ID
	 * @return 성공 시 게시물 상세 페이지로 이동, 실패 시 에러 응답
	 */
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

	/**
	 * 게시물 삭제 처리
	 * 관련된 동물 유형, 시설 정보도 함께 삭제
	 * 트랜잭션 처리
	 * 
	 * @param int $id 게시물 ID
	 * @return 성공 시 게시물 목록으로 이동, 실패 시 에러 응답
	 */
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
	/**
	 * 공지사항 목록 조회
	 * 페이지네이션 적용 (10개씩)
	 * 
	 * @return 공지사항 목록 뷰와 페이지네이션된 공지사항 데이터
	 */
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
			DB::beginTransaction();

			foreach($request->managers as $m_manager){
				$manager = new Manager();
					$manager->m_account = $m_manager['m_account'];
					$manager->m_password = Hash::make($m_manager['m_password']);
					$manager->m_nickname = $m_manager['m_nickname'];
				$manager->save();
			}

			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->route('manager.store')->withErrors(['message' => '관리자 작성 실패. 잠시 후 시도바람']);
			Log::error($e->getMessage());
		}
		return redirect()->route('manager.index');
	}

	// 매니저 영역 종료 =================================================

	// 신고 영역 시작
	// 신고 댓글 리스트 출력 
	/**
	 * 신고 댓글 목록 조회
	 * 포스트 댓글과 커뮤니티 댓글 신고 내역 표시
	 * 페이지네이션 적용 (10개씩)
	 * 
	 * @return 신고 댓글 목록 뷰와 페이지네이션된 신고 데이터
	 */
	public function reportCommentIndex(){
		// 01 : 포스트 댓글 -> 이거 가져오셈
		// 03 : 커뮤니티 댓글 -> 이거 가져오셈

		// 02 : 커뮤니티 글
		$reports = Report::with('user')->whereIn('report_category', [1, 3])->orderBy('created_at', 'DESC')->paginate(10);

		Log::debug($reports);

		$page = request()->query('page', 1);

		if($page < 1){
			return redirect()->route('report.comments', ['page' => 1]);
		}
		else if($page > $reports->lastPage()){
			return redirect()->route('report.comments', ['page' => $reports->lastPage()]);
		}

		return view('manager.layout.report_comments.reportComments', [
			'reports' => $reports,
			'page' => $page,
			'category' => $this->reportCategory
		]);
	}

	// 댓글 신고 상세 리스트 출력 
	public function reportCommentDetail($id){
		$report = Report::with('user')->find($id);

		if($report === null){
			return redirect()->route('reports.comments');
		}

		$reported_content = null;
		$comment_category = null;
		$url = null;
		switch($report->report_category){
			case '01':
				$reported_content = PostComments::with('user')->withTrashed()->find($report->report_board_id);
				$comment_category = '포스트';
				$url = '/posts/01/'.$reported_content->post_id;
				break;
			case '03':
				// TODO : 커뮤니티 댓글 상세 출력
				$comment_category = '커뮤니티';
				// TODO : 커뮤니티 댓글 url 출력
				break;
		}

		$report_result = ReportProcess::where('report_id', '=', $id)->withTrashed()->first();

		return view('manager.layout.report_comments.reportCommentsDetail', [
			'report' => $report,
			'reported_content' => $reported_content,
			'url' => $url,
			'report_category' => $this->reportCategory,
			'page' => request()->query('page', 1),
			'comment_category' => $comment_category,
			'report_result' => $report_result

		]);
	}

	/**
	 * 신고 처리 결과 저장
	 * 신고 상태 업데이트 및 처리 결과 기록
	 * 징계 시 해당 댓글 자동 삭제
	 * 트랜잭션 처리
	 * 
	 * @param Request $request 처리 결과 데이터
	 * @param int $id 신고 ID
	 * @return 성공 시 신고 상세 페이지로 이동, 실패 시 에러 메시지와 함께 되돌아감
	 */
	public function reportCommentPunishment(Request $request, $id){
		Log::debug($request->report_result);
		$validator = Validator::make($request->only('report_reason'), [
			'report_reason' => ['required', 'max:200']
		]);

		if($validator->fails()){
			return redirect()->route('reports.comments.detail', ['id' => $id])->withErrors($validator)->withInput();
		}

		try{
			DB::beginTransaction();

			$report_process = new ReportProcess();
				$report_process->report_id = $id;
				$report_process->manager_id = Auth::guard('manager')->user()->manager_id;
				$report_process->report_result = $request->report_result;
				$report_process->report_reason = $request->report_reason;
				if($request->report_result === '02'){
					$report_process->ban_at = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').('+'.$request->ban_at.' days')));
				}
				else if($request->report_result === '03'){
					$report_process->ban_at = '9999-12-31 23:59:59';
				}
			$report_process->save();

			$report = Report::find($id);
				$report->report_status = '02';
			$report->save();
			
			// 징계 대상이면 댓글 자동 삭제
			if($request->report_result === '02' || $request->report_result === '03'){
				if($report->report_category === '01'){					
					//PostComments::where('post_comment_id', '=', $report->report_board_id)->delete();
				}
				else if($report->report_category === '03'){
					// TODO : 커뮤니티 댓글 삭제
				}
			}

			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->route('reports.comments.detail', ['id' => $id])->withErrors($e->getMessage());
			Log::error($e->getMessage());
		}

		return redirect()->route('reports.comments.detail', ['page' => request()->query('page', 1), 'id' => $id]);
	}

	// 신고 영역 끝 ================================================

	// 상점 영역 시작 ==============================================

	// 상품 리스트 조회
	public function storeIndex(){
		$shops = TravelClass::orderBy('created_at', 'DESC')->paginate(10);

		$page = request()->query('page', 1);

		if($page < 1){
			return redirect()->route('shops.index', ['page' => 1]);
		}
		else if($page > $shops->lastPage()){
			return redirect()->route('shops.index', ['page' => $shops->lastPage()]);
		}

		return view('manager.layout.shops.shops')->
			with('shops', $shops)->
			with('page', $page);
	}

	// 상품 상세 조회
	public function storeDetail($id){
		$travelClass = TravelClass::find($id);
		if($travelClass === null){
			return redirect()->route('shops.index');
		}

		$url = '/shops/'.$travelClass->class_id;

		return view('manager.layout.shops.shopsDetail', [
			'travelClass' => $travelClass,
			'url' => $url
		]);
	}

	// 상품 등록창
	public function storeCreate(){
		return view('manager.layout.shops.shopsCreate');
	}

	/**
	 * 여행 클래스(상품) 등록 처리
	 * 이미지 업로드 및 클래스 정보 저장
	 * 트랜잭션 처리
	 * 
	 * @param Request $request 클래스 등록 데이터
	 * @return 성공 시 상품 목록으로 이동, 실패 시 등록 폼으로 되돌아감
	 */
	public function storeStore(Request $request){
		$validator = Validator::make($request->only(
			'class_title', 'class_title_img', 'class_content', 'class_price', 'location', 'class_date', 'class_date_time'),
			[
				'class_title' => ['required', 'string', 'max:20'],
				'class_title_img' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
				'class_content' => ['required'],
				'class_price' => ['required', 'min:3', 'max:255'],
				'location' => ['required', 'string', 'max:255'],
				'class_date' => ['required', 'after_or_equal:today'],
				'class_date_time' => ['required']
			]
		);

		if($validator->fails()){
			return redirect()->route('stores.create')->withErrors($validator)->withInput();
		}

		try{
			DB::beginTransaction();
				$travelClass = new TravelClass();
					$travelClass->class_title = $request->class_title;
					$travelClass->user_id = 53; // TODO :임시 값임
					$travelClass->class_title_img = '/'.$request->file('class_title_img')->store('img');
					$travelClass->class_content = $request->class_content;
					$travelClass->class_price = $request->class_price;
					$travelClass->location = $request->location;
					$travelClass->class_date = $request->class_date.' '.$request->class_date_time;
				$travelClass->save();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->route('stores.create')->withErrors($e->getMessage());
			Log::error($e->getMessage());
		}

		// return redirect()->route('stops.detail', ['id' => $travelClass->class_id]);
		return redirect()->route('shops.index', ['page' => request()->query('page', 1) ?? '']);
	}

	// 상품 영역 종료 ===========================================
	// 문의 영역 시작 ===========================================
	// 문의 목록 조회
	public function inquiryIndex(){
		$inquiries = Inquiry::with('users')->orderBy('created_at', 'DESC')->orderBy('inquiry_id', 'DESC')->paginate(10);

		$page = request()->query('page', 1);

		if($page < 1){
			return redirect()->route('inquiries.index', ['page' => 1]);
		}
		else if($page > $inquiries->lastPage()){	
			return redirect()->route('inquiries.index', ['page' => $inquiries->lastPage()]);
		}

		return view('manager.layout.inquiries.inquiries', [
			'inquiries' => $inquiries,
			'page' => $page
		]);
	}

	// 문의 상세 조회
	public function inquiryDetail($id){
		$inquiry = Inquiry::with('users')->find($id);
		if($inquiry === null){
			return redirect()->route('inquiries.index');
		}

		return view('manager.layout.inquiries.inquiriesDetail', [
			'inquiry' => $inquiry
			,'url' => '/inquiries/'.$inquiry->inquiry_id
			,'page' => request()->query('page', 1)
		]);
	}

	// 문의 답변 작성 및 수정
	public function inquiryResponse(Request $request, $id){
		$inquiry = Inquiry::find($id);
		if($inquiry === null){
			return redirect()->route('inquiries.index');
		}

		$response = trim($request->inquiry_response) === '<p>&nbsp;</p>' ? null : $request->inquiry_response;

		try{
			DB::beginTransaction();
				$inquiry->inquiry_response = $response;
				$inquiry->save();
			DB::commit();
		}catch(Exception $e){
			DB::rollBack();
			return redirect()->route('inquiries.detail', ['id' => $id])->withErrors($e->getMessage());
			Log::error($e->getMessage());
		}

		return redirect()->route('inquiries.detail', [
			'id' => $id
			,'page' => $request->page
		]);
	}
}