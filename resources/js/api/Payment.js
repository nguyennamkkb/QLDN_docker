import Client from '../plugins/axios'
const resource = '/api';

export function getListVau(data) {
    return Client({
        url: resource + '/getlistvau',
        method: 'get',
        params: data
    })
}
export function getListTam(data) {
    return Client({
        url: resource + '/getlisttam',
        method: 'get',
        params: data
    })
}
export function getListPaymentCarrier(data) {
    return Client({
        url: resource + '/getlistWorkedCarrier',
        method: 'get',
        params: data
    })
}

export function createBook(data) {
    return Client({
        url: resource + '/createBook',
        method: 'post',
        params: data
    })
}