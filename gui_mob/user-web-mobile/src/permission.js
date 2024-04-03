import router from './router'
import store from './store'
import { getToken } from '@/utils/auth'

const whiteList = ['/login', '/userRegister']

router.beforeEach(async(to, from, next) => {
  const hasToken = getToken()
  if (hasToken) {
    if (to.path === '/login') {
      next({ path: '/index' })
    } else {
      if (store.getters.userInfo.id) {
        next()
      } else {
        try {
          await store.dispatch('user/getInfo')
          next({ ...to, replace: true })
        } catch (error) {
          await store.dispatch('user/logout')
          next('/login')
        }
      }
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      next()
    } else {
      next('/login')
    }
  }
})
