import request from '@/utils/request'

export function getData(upload_date) {
  return request({
    url: '/api/data/getData',
    method: 'get',
    params: {
      upload_date
    }
  })
}

export function del(id) {
  return request({
    url: '/api/data/delete',
    method: 'post',
    data: {
      id
    }
  })
}

export function getGPSData(id) {
  return request({
    url: '/api/data/getGPSData',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function addGPSData(data) {
  return request({
    url: '/api/data/addGPSData',
    method: 'post',
    data: data
  })
}