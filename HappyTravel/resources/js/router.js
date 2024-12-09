import {createWebHistory, createRouter } from 'vue-router';
import IndexComponet from '../views/components/IndexComponet.vue';
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
// ----------------------------------------------------------------------

// commuity
// ----------------------------------------------------------------------
import CommunityComponet from '../views/components/community/CommunityComponet.vue';
import CommunityNoticeComponent from '../views/components/community/CommunityNoticeComponent.vue';
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
// ----------------------------------------------------------------------

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
		path:'/login',
		component: LoginComponet,
	},	
	{
		path:'/logout',
		component: LogoutComponet,
	},
	{
		path:'/registration', // 회원 가입
		component: UserRegistrationComponent,		
	},
	{
		path:'/user/withdraw',  // 회원 탈퇴
		component: UserWithdrawComponet,
	},	 
	{
		path:'/user/mypage',   // 마이페이지
		component: MypageComponet,
		children : [
			{
				path:'auth/update',  // 마이페이지 회원정보 수정
				component:MypageAuthUpadateComponet,
			},
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
		path: '/community',     // 커뮤니티
		component:CommunityComponet,
		children : [
			{
				path : 'notice',  // 공지 사항
				component: CommunityNoticeComponent,
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
		,component: PostComponet
	},		
	{
		path:'/post/detail' // 포스트 상세 페이지
		,component:PostDetailComponet
	},
];

const router = createRouter({
	history: createWebHistory()
	,routes
});

export default router;