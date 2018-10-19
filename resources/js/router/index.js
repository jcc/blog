import Vue from 'vue'
import Router from 'vue-router'
import beforeEach from './beforeEach'
import { routes as dashboard } from '../dashboard/index'

Vue.use(Router);

const AppRoute = {
  path: '/',
  component: () => import('../App.vue'),
  children: [...dashboard],
};

const routes = [AppRoute];

const router = new Router({
  routes,
  linkActiveClass: 'active',
  linkExactActiveClass: 'active',
  mode: 'history',
});

router.beforeEach(beforeEach);

export default router
