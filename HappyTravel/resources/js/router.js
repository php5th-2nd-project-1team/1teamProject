import {createWebHistory, createRouter } from 'vue-router';

const routes=[
	{
		// path : '경로이름'
		// ,component : '컴포넌트이름'
	}
];

const router = createRouter({
	history: createWebHistory()
	,routes
});

export default router;