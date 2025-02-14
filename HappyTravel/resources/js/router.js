import {createWebHistory, createRouter } from 'vue-router';
import IndexComponet from '../views/components/index/IndexComponet.vue';
// auth

// ----------------------------------------------------------------------
import LoginComponet from '../views/components/auth/LoginComponet.vue';
import LogoutComponet from '../views/components/auth/LogoutComponet.vue';
import PasswordChangeComponent from '../views/components/auth/PasswordChangeComponent.vue';
import PasswordRecoverComponent from '../views/components/auth/PasswordRecoverComponent.vue';

// ----------------------------------------------------------------------

// user

// ----------------------------------------------------------------------
import MypageComponent from '../views/components/user/MypageComponent.vue';
import MypageAuthUpadateComponet from '../views/components/user/MypageAuthUpadateComponet.vue';
import UserRegistrationComponent from '../views/components/user/UserRegistrationComponent.vue';
import UserWithdrawComponet from '../views/components/user/UserWithdrawComponet.vue';
import MypageAuthComponet from '../views/components/user/MypageAuthComponet.vue';
import MypagePuchadeComponent from '../views/components/user/MypagePurchadeComponet.vue';
import MypageReservationComponet from '../views/components/user/MypageReservationComponet.vue';
import UserPasswordCheckComponent from '../views/components/user/UserPasswordCheckComponent';
import MypageAuthPasswordUpadateComponet from '../views/components/user/MypageAuthPasswordUpadateComponet.vue'
import MypageWishlistComponent from '../views/components/user/MypageWishlistComponent.vue';
// ----------------------------------------------------------------------

// commuity
// ----------------------------------------------------------------------
import CommunityComponet from '../views/components/community/CommunityComponet.vue';
import CommunityNoticeComponent from '../views/components/community/CommunityNoticeComponent.vue';
import CommunityNoticeDetailComponet from '../views/components/community/CommunityNoticeDetailComponet.vue';
import CommunityEventComponet from '../views/components/community/CommunityEventComponet.vue';
import CommunityPhotoAlbumComponet from '../views/components/community/CommunityPhotoAlbumComponet.vue';
import CommunityCommentComponet from '../views/components/community/CommunityCommnet.vue';
import CommunityDetailComponet from '../views/components/community/CommunityDetailComponet.vue';
import CommunityInsertComponet from '../views/components/community/CommunityInsertComponet.vue';
import CommunityUpdateComponet from '../views/components/community/CommunityUpdateComponet.vue';
import CommunityFreeComponet from '../views/components/community/CommunityFreeComponet.vue';
import CommunityFreeDetailComponent from '../views/components/community/CommunityFreeDetailComponent.vue';
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// shop
import ShopComponent from '../views/components/shop/ShopComponent.vue';
import ShopDetailComponet from '../views/components/shop/ShopDetailComponet.vue';
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// post
import PostDetailComponet from '../views/components/post/PostDetailComponet.vue';
import PostComponet from '../views/components/post/PostComponet.vue';
import AboutComponent from '../views/components/AboutComponent.vue';
// ----------------------------------------------------------------------

import { useStore } from 'vuex';
import SocialComponent from '../views/components/auth/SocialComponent.vue';
import CommunityFreeStoreComponent from '../views/components/community/CommunityFreeStoreComponent.vue';
import AccountRecoverComponent from '../views/components/auth/AccountRecoverComponent.vue';
import AccountRecoverResultComponent from '../views/components/auth/AccountRecoverResultComponent.vue';
import InquiryComponent from '../views/components/inquiry/InquiryComponent.vue';
import InquiryDetailComponent from '../views/components/inquiry/InquiryDetailComponent.vue';
import InquiryCreateComponent from '../views/components/inquiry/InquiryCreateComponent.vue';
const chkAuth = (to, from, next) => {
    const store = useStore();
    const authFlg = store.state.auth.authFlg; // 로그인 여부 플레그
	// 비 로그인 시 접근 가능 페이지 플레그
    const noAuthPassFlg = (to.path === '/login' || to.path === '/registration' || to.path === '/account-recover' || to.path === '/reset-password' || to.path === '/password-reset');
	// 로그인 시 접근 가능 페이지
	const AuthPassFlg = to.path.startsWith('/user'); 

	window.scrollTo(0, 0);
    if(authFlg && noAuthPassFlg) {
        // 인증된 유저가 비인증으로 이동할 수 있는 페이지에 접근할 경우 board로 이동
        next('/index');
    }else if(!authFlg && AuthPassFlg) {
		// 인증 안된 유저가 마이페이지로 이동하려고 할 시 login으로 이동
        next('/login');
    } else {
        next();
	}
}

const chkAdmin = (to, from, next) => { 
	const store = useStore();
	const adminLoginFlg = store.state.admin.adminLoginFlg;

	// TODO 관리자 페이지 로그인 시 못들어가는 페이지 좀 더 조사하여 추가할 것
	const noAdminPassFlg = to.path('/admin/login');

	if(!adminLoginFlg && noAdminPassFlg){
		next('/admin/login');
	}
	else if(adminLoginFlg && noAdminPassFlg){
		next('/admin/index');
	}else{
		next();
	}
}


const routes=[
	// path : '경로이름'
	// ,component : '컴포넌트이름'
	{
		path: '/',
		redirect: '/index',
	},
	{
		path: '/social/info',
		component: SocialComponent,
	},
	// {
	// 	path: '/notice/store',
	// 	component: TestComponent
	// },
	{
		path: '/index',
		component : IndexComponet,
	},
	{
		path: '/about'
		,component : AboutComponent,
		beforeEnter: chkAuth,
	},
	{
		path:'/login',
		component: LoginComponet,
		beforeEnter: chkAuth,
	},	
	{
		path:'/logout',
		component: LogoutComponet,
		beforeEnter: chkAuth,
	},
	{
		path:'/registration', // 회원 가입
		component: UserRegistrationComponent,	
		beforeEnter: chkAuth,	
	},
	{
		path:'/user/withdraw',  // 회원 탈퇴
		component: UserWithdrawComponet,
		beforeEnter: chkAuth,
	},	 
	{
		path:'/reset-password',  // 비밀번호 찾기 페이지
		component: PasswordRecoverComponent,
		beforeEnter: chkAuth, 
	},	 
	{
		path:'/password-reset',  // 비밀번호 변경 페이지
		component: PasswordChangeComponent,
		beforeEnter: chkAuth,
	},
	{
		path:'/account-recover',  // 아이디 찾기 페이지
		component: AccountRecoverComponent,
		beforeEnter: chkAuth,
	},	 
	{
		path:'/account-recover/result',  // 아이디 찾기 결과 페이지
		component: AccountRecoverResultComponent,
		beforeEnter: chkAuth,
	},
	{
		path:'/user',   // 마이페이지
		component: MypageComponent,
		beforeEnter: chkAuth,
		children : [
			{
				path:'mypage', // 내 정보
				component:MypageAuthComponet,
			},
			{
				path:'mypage/update', // 내 정보 수정
				component:MypageAuthUpadateComponet,
			},
			{
				path:'mypage/password/update', // 내 정보 수정
				component:MypageAuthPasswordUpadateComponet,
			},
			{
				path:'purchade', // 마이페이지 구매 내역
				component:MypagePuchadeComponent,
			},
			{
				path:'reservation', // 마이페이지 예약 내역
				component: MypageReservationComponet,
			},	
			{
				path: 'passwordcheck',
				component: UserPasswordCheckComponent,
				beforeEnter: chkAuth,
			},
			{
				path:'reservation', // 마이페이지 예약 내역
				component: MypageReservationComponet,
			},
			{
				path:'wishlist', // 찜목록 내역
				component: MypageWishlistComponent,
			},		
		]
	},
	{
		path: '/community',     // 커뮤니티
		component:CommunityComponet,
		beforeEnter: chkAuth,
		children : [
			{
				path : 'notice',  // 공지 사항
				component: CommunityNoticeComponent,
			},
			{
				path:'notice/:id',
			  	component: CommunityNoticeDetailComponet,	
			  
			},	
			{
				path : 'event',  // 이벤트
				component: CommunityEventComponet,
			},
			{
				path : 'album', // 앨범
				component: CommunityPhotoAlbumComponet,
			},
			{
				path: 'comment', // 댓글
				component: CommunityCommentComponet,
			},
			{
				path: 'detail', // 상세
				component: CommunityDetailComponet,
			},
			{
				path: 'insert', // 작성
				component: CommunityInsertComponet,
			},
			{
				path: 'update', // 수정 출력잘됨
				component: CommunityUpdateComponet,
			},
			{
				path:'free',  // 자유
				component: CommunityFreeComponet,
			},
			{
				path: '/community/store',
				name: 'FreeStore',
				component: CommunityFreeStoreComponent,
			},
			{
				path: '/community/free/:id',
				name : 'FreeDetail',
				component: CommunityFreeDetailComponent,
			}
		]
	},
	// 문의사항 보드
	{
		path: '/inquiries',
		component: InquiryComponent,
		beforeEnter: chkAuth,
	},
	// 문의사항 상세
	{
		path: '/inquiries/:id',
		component: InquiryDetailComponent,
		beforeEnter: chkAuth,
	},
	// 문의사항 작성
	{
		path: '/inquiries/create',
		component: InquiryCreateComponent,
		beforeEnter: chkAuth,
	},
	{	
		path: '/shops',           // 샵 (상품)
		component:ShopComponent,
		beforeEnter: chkAuth
	}
	,{
		path: '/shops/:id', // 샵 상세
		component: ShopDetailComponet,
		beforeEnter: chkAuth
	}
	,{
		path:'/posts/:theme'   // 포스트 (펫브리즈고)
		,component: PostComponet,
		beforeEnter: chkAuth,
	},		
	{
		path:'/posts/:theme/:id' // 포스트 상세 페이지
		,component:PostDetailComponet,
		beforeEnter: chkAuth,
	},
	// {
	// 	path:'/admin'
	// 	,component: AdminFormComponent
	// 	,children:[
	// 		// 관리자 메인 페이지
	// 		{
	// 			path : 'index'
	// 			,component: AdminIndexComponent
	// 		}
	// 		// 유저 관리 페이지
	// 		,{
	// 			path : 'users'
	// 			,component: AdminUserComponent
	// 		}
	// 		// 유저 상세 페이지
	// 		,{
	// 			path : 'users/:id'
	// 			,component: AdminUserDetailComponent
	// 		}
	// 		// 관리자 관리 페이지
	// 		,{
	// 			path : 'lists'
	// 			,component: AdminListComponent
	// 		}
	// 		// 관리자 등록 페이지
	// 		,{
	// 			path : 'lists/create'
	// 			,component: AdminCreateComponent
	// 		},
	// 		// 포스트 관리 페이지
	// 		{
	// 			path : 'posts'
	// 			,component: AdminPostsComponent
	// 		},
	// 		// 포스트 상세 페이지
	// 		{
	// 			path : 'posts/:id'
	// 			,component: AdminPostsDetailComponent
	// 		},
	// 		// 포스트 생성 페이지
	// 		{
	// 			path : 'posts/create'
	// 			,component: AdminPostCreateComponent
	// 		},
	// 		// 포스트 수정 페이지
	// 		{
	// 			path : 'posts/edit/:id'
	// 			,component: AdminPostEditComponent
	// 		},
	// 		// 공지사항 목록 페이지
	// 		{
	// 			path : 'notices'
	// 			,component: AdminNoticeComponent
	// 		}
	// 		// 공지사항 상세 페이지
	// 		,{
	// 			path : 'notices/:id'
	// 			,component: AdminNoticeDetailComponent
	// 		}
	// 		// 공지사항 작성 페이지
	// 		,{
	// 			path : 'notices/create'
	// 			,component: AdminNoticeCreateComponent
	// 		}
	// 		// 공지사항 수정 페이지
	// 		,{
	// 			path : 'notices/edit/:id'
	// 			,component: AdminNoticeEditComponent
	// 		}
	// 		// 관리자 로그인 페이지
	// 		,{
	// 			path : 'login'
	// 			,component: AdminLoginComponent
	// 		}
	// 	]
	// }
];

const router = createRouter({
	history: createWebHistory()
	,routes
});

export default router;