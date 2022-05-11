import Client from '../plugins/axios'
const resource = '/api';

export function getCatDong(data) {
    return Client({
        url: resource + '/catdong',
        method: 'get',
        params: data
    })
}
export function createCatDong(data) {
    return Client({
        url: resource + '/catdong',
        method: 'post',
        params: data
    })
}
export function updateCatDong(id, data) {
    return Client({
        url: resource + '/catdong/' + id,
        method: 'put',
        params: data
    })
}
export function deleteCatDong(id) {
    return Client({
        url: resource + '/catdong/' + id,
        method: 'delete',
    })
}