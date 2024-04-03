import request from '@/utils/request'

export function getData(user_id, upload_date) {
  return request({
    url: '/admin/data/getData',
    method: 'get',
    params: {
      user_id,
      upload_date
    }
  })
}

export function del(user_id, id) {
  return request({
    url: '/admin/data/delete',
    method: 'post',
    data: {
      user_id,
      id
    }
  })
}

export function getGPSData(user_id, id) {
  return request({
    url: '/admin/data/getGPSData',
    method: 'get',
    params: {
      user_id,
      id
    }
  })
}

export function download() {
  return request({
    url: '/admin/data/download',
    method: 'post',
  })
}
