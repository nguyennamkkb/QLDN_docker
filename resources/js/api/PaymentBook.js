import Client from '../plugins/axios'
const resource = '/api';

export function getListPaymentBook(data) {
    return Client({
        url: resource + '/listpaymentbook',
        method: 'get',
        params: data
    })
}

// export function createBook(data) {
//     return Client({
//         url: resource + '/createBook',
//         method: 'post',
//         params: data
//     })
// }