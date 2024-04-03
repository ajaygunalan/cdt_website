import request from '@/utils/request'

export function login(email, password) {
  return request({
    url: '/api/user/login',
    method: 'post',
    data: {
      email: email,
      password: password
    }
  })
}

export function myDetail() {
  return request({
    url: '/api/user/detail',
    method: 'get'
  })
}

export function register(data) {
  return request({
    url: '/api/user/register',
    method: 'post',
    data: data
  })
}
