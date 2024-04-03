import request from '@/utils/request'

export function login(email, password) {
  return request({
    url: '/admin/admin/login',
    method: 'post',
    data: {
      email: email,
      password: password
    }
  })
}

export function myDetail() {
  return request({
    url: '/admin/admin/detail',
    method: 'get'
  })
}

export function register(data) {
  return request({
    url: '/admin/admin/register',
    method: 'post',
    data: data
  })
}
