import Cookies from 'js-cookie'

const key = 'gps-setting'

export function getGPS() {
  return Cookies.get(key)
}

export function setGPS(isStart) {
  return Cookies.set(key, isStart)
}