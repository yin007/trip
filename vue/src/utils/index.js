import axios from 'axios';
const apiUrl = "";

export default {
    install(Vue) {
        Vue.prototype.httpGet = function(url, success) {
            axios({
                    method: "get",
                    url: apiUrl + url
                })
                .then(res => {
                    success(res);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };
        // POST
        Vue.prototype.httpPost = function(url, data, success) {
            axios({
                    method: "post",
                    data: data,
                    url: apiUrl + url
                })
                .then(res => {
                    success(res);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };
        //PUT
        Vue.prototype.httpPut = function(url, data, success) {
            axios({
                    method: "put",
                    data: data,
                    url: apiUrl + url
                })
                .then(res => {
                    success(res.data);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };
    }

};