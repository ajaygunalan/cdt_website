import request from '@/utils/request'

export function getList() {
  return request({
    url: '/admin/user/getList',
    method: 'get'
  })
}
