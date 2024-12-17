import {createWebHistory, createRouter } from 'vue-router';
import IndexComponet from '../views/components/index/IndexComponet.vue';
// auth

// ----------------------------------------------------------------------
import LoginComponet from '../views/components/auth/LoginComponet.vue';
import LogoutComponet from '../views/components/auth/LogoutComponet.vue';
// ----------------------------------------------------------------------

// user

// ----------------------------------------------------------------------
import MypageComponet from '../views/components/user/MypageComponent.vue';
import UserRegistrationComponent from '../views/components/user/UserRegistrationComponent.vue';
import UserWithdrawComponet from '../views/components/user/UserWithdrawComponet.vue';
import MypageAuthUpadateComponet from '../views/components/user/MypageAuthUpadateComponet.vue';
import MypagePuchadeComponent from '../views/components/user/MypagePurchadeComponet.vue';
import MypageReservationComponet from '../views/components/user/MypageReservationComponet.vue';
import UserPasswordCheckComponent from '../views/components/user/UserPasswordCheckComponent';
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
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// shop
import ShopComponent from '../views/components/shop/ShopComponent.vue';
import ShopDetailComponet from '../views/components/shop/ShopDetailComponet.vue';
import ShopClassComponet from '../views/components/shop/ShopClassComponet.vue';
import ShopPackageComponet from '../views/components/shop/ShopPackageComponet.vue';
import ShopMerchComponet from '../views/components/shop/ShopMerchComponet.vue';
// ----------------------------------------------------------------------

// ----------------------------------------------------------------------
// post
import PostDetailComponet from '../views/components/post/PostDetailComponet.vue';
import PostComponet from '../views/components/post/PostComponet.vue';
import AboutComponent from '../views/components/AboutComponent.vue';
// ----------------------------------------------------------------------

import { useStore } from 'vuex';

const chkAuth = (to, from, next) => {
    const store = useStore();
    const authFlg = store.state.auth.authFlg; // 로그인 여부 플레그
	// 비 로그인 시 접근 가능 페이지 플레그
    const noAuthPassFlg = (to.path === '/login' || to.path === '/registration');
	// 로그인 시 접근 가능 페이지
	const AuthPassFlg = (to.path === '/mypage'); 

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


const routes=[
	// path : '경로이름'
	// ,component : '컴포넌트이름'
	{
		path: '/',
		redirect: '/index',
	},
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
		path:'/user/mypage',   // 마이페이지
		component: MypageComponet,
		beforeEnter: chkAuth,
		children : [
			{
				path:'purchade', // 마이페이지 구매 내역
				component:MypagePuchadeComponent,
			},
			{
				path:'reservation', // 마이페이지 예약 내역
				component: MypageReservationComponet,
			},	
		]
	},
	{
		path: '/passwordcheck',
		component: UserPasswordCheckComponent,
		beforeEnter: chkAuth,
	},
	{	path: '/mypage/auth/update',
		component: MypageAuthUpadateComponet,
		beforeEnter: chkAuth,
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
				path:'notice/detail/:id',
			  component:CommunityNoticeDetailComponet,	
			  
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
		]
	},
	{	
		path: '/shop',           // 샵 (상품)
		component:ShopComponent,
		beforeEnter: chkAuth,
		children: [
			{	
				path: 'class',  // 클래스
				component: ShopClassComponet,
			},
			{
				path: 'package', // 패키지
				component: ShopPackageComponet,
			},
			{
				path: 'merch', // 굿즈
				component: ShopMerchComponet,
			},
			{
				path : 'detail', // 상세
				component: ShopDetailComponet,
			},
		]
	},
	{
		path:'/posts'   // 포스트 (펫브리즈고)
		,component: PostComponet,
		beforeEnter: chkAuth,
	},		
	{
		// TODO 3. id 없는거 가져오려 할 시 오류 및 뒤로 이동 (옵션)

		path:'/posts/:id' // 포스트 상세 페이지
		,component:PostDetailComponet,
		beforeEnter: chkAuth,
	},
];

const router = createRouter({
	history: createWebHistory()
	,routes
});

export default router;