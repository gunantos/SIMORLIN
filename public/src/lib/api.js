import request from './request'
var contenType = 'application/json'

export function get(path, params = {}) {
    return request({
        url: path,
        params: params,
        method: 'get',
        headers: {
            'Content-Type': contenType
        }
    })
}

export function post(path, data = {}) {
    return request({
        url: path,
        method: 'post',
        data,
        headers: {
            'Content-Type': contenType
        }
    })
}

export function post(path, data = {}) {
    return request({
        url: path,
        method: 'post',
        data,
        headers: {
            'Content-Type': contenType
        }
    })
}

export function post(path, data = {}) {
    return request({
        url: path,
        method: 'post',
        data,
        headers: {
            'Content-Type': contenType
        }
    })
}

export function post(path, data = {}) {
    return request({
        url: path,
        method: 'post',
        data,
        headers: {
            'Content-Type': contenType
        }
    })
}