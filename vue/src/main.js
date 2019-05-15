// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import axios from 'axios';
import router from './router'
import moment from 'moment'

import 'moment/locale/zh-cn'

moment.locale('zh-cn')



export{formatDate}    
Vue.config.productionTip = false

//导入YDUI
import YDUI from 'vue-ydui'; 
import 'vue-ydui/dist/ydui.rem.css';
import 'vue-ydui/dist/ydui.flexible.js';
Vue.use(YDUI);



//封装的请求数据的组件
import Utils from "./utils";
Vue.use(Utils);




Vue.config.productionTip = false;
router.beforeEach((to, from, next) => {
  let token = to.query.token || sessionStorage.getItem('token') || "";
  sessionStorage.setItem('token', token);
  if (token) {
    sessionStorage.setItem('token', token);
    next();
  } else {
    window.location.href = "https://wechat.thinkwindtech.com/api/wechat/login";
    next();
  }
});
axios.defaults.timeout = 60000
axios.interceptors.request.use(config => {
  config.headers['token'] = sessionStorage.getItem('token') || "";
  // localStorage.getItem('userid')
  config.headers['userid'] = sessionStorage.getItem('token') || "";
  return config
}, error => {
  return Promise.reject(error)
})
axios.interceptors.response.use(res => {
  return res.data
}, error => {
  return Promise.reject(error)
})
new Vue({
  el: '#app',
  router,
  components: {
    App
  },
  template: '<App/>'
})


