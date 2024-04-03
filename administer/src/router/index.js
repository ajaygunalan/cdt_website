import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

// import Layout from '@/layout'

export const constantRoutes = [
  {
    path: '/login',
    component: () => import('@/views/login/index')
  },
  {
    path: '/userRegister',
    component: () => import('@/views/login/userRegister')
  },

  {
    path: '/404',
    component: () => import('@/views/404'),
  },

  {
    path: '/index',
    component: () => import('@/views/index/index')
  },
  // {
  //   path: '/',
  //   component: Layout,
  //   redirect: '/index',
  //   children: [{
  //     path: 'index',
  //     name: '首页',
  //     component: () => import('@/views/index/index'),
  //     meta: { title: '首页', noCache: true }
  //   }]
  // },

  // 404 page must be placed at the end !!!
  { path: '*', redirect: '/404' }
]

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
