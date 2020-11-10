import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import Home from '../views/Home.vue';

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
  },
  {
    path: '/category/:category',
    name: 'category',
    component: () => import(/* webpackChunkName: "category" */ '../views/Category.vue'),
  },
  {
    path: '/video/:video',
    name: 'video',
    component: () => import(/* webpackChunkName: "video" */ '../views/Video.vue'),
  },
];

const router = createRouter({
  history: createWebHistory('/app/'),
  routes,
});

export default router;
