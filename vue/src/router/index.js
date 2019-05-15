import Vue from 'vue'
import Router from 'vue-router'
import homePage from '@/views/homepage/homepage' //首页
import lease from '@/views/homepage/lease' //可租赁
import serve from '@/views/homepage/serve' //服务点
import destination_serve from '@/views/homepage/destination_serve' //目的地服务点
import city from '@/views/homepage/city' //城市
import end_city from '@/views/homepage/end_city' //目的地城市


import serve_details from '@/views/homepage/serve_details' //服务点
import details from '@/views/homepage/details' //商品详情
import order_form from '@/views/homepage/order_form' //确认订单


import mine from '@/views/minepage/mine' //个人中心
import myOrder from '@/views/minepage/myOrder' //我的订单
import order_details from '@/views/minepage/order_details' //订单详情
import shop_car from '@/views/minepage/shop_car' //购物车
import friend from '@/views/minepage/friend' //邀请好友
import my_discounts from '@/views/minepage/my_discounts' //我的优惠券
import FAQ from '@/views/minepage/FAQ' //常见问题
import feedback from '@/views/minepage/feedback' //意见反馈
import about from '@/views/minepage/about' //关于我们
import my_news from '@/views/minepage/my_news' //我的消息
import message from '@/views/minepage/message' //消息详情
import set from '@/views/minepage/set' //设置
import set_phone from '@/views/minepage/set_phone' //修改手机号
import amend_psd from '@/views/minepage/amend_psd' //修改密码
import car_order from '@/views/minepage/car_order' //购物车确认订单
import identity from '@/views/minepage/identity' //身份认证




import login from '@/views/loginpage/login' //登录
import register from '@/views/loginpage/register' //注册
import forget_psd from '@/views/loginpage/forget_psd' //忘记密码
import verify_phone from '@/views/loginpage/verify_phone' //手机验证




Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'homePage',
      component: homePage,
      meta: {
          keepAlive: true
      }
    },
    {
      path: '/details',
      name: 'details',
      component: details
    },
    {
      path: '/lease',
      name: 'lease',
      component: lease
    },
    {
      path: '/order_form',
      name: 'order_form',
      component: order_form
    },
    {
      path: '/serve',
      name: 'serve',
      component: serve
    },
    {
      path: '/destination_serve',
      name: 'destination_serve',
      component: destination_serve
    },
    {
      path: '/serve_details',
      name: 'serve_details',
      component: serve_details
    },
    {
      path: '/city',
      name: 'city',
      component: city
    },
    {
      path: '/end_city',
      name: 'end_city',
      component: end_city
    },
    {
      path: '/mine',
      name: 'mine',
      component: mine
    },
    {
      path: '/myOrder',
      name: 'myOrder',
      component: myOrder
    },
    {
      path: '/order_details',
      name: 'order_details',
      component: order_details
    },
    {
      path: '/shop_car',
      name: 'shop_car',
      component: shop_car
    },
    {
      path: '/friend',
      name: 'friend',
      component: friend
    },
    {
      path: '/my_discounts',
      name: 'my_discounts',
      component: my_discounts
    },
    {
      path: '/FAQ',
      name: 'FAQ',
      component: FAQ
    },
    {
      path: '/identity',
      name: 'identity',
      component: identity
    },
    {
      path: '/feedback',
      name: 'feedback',
      component: feedback
    },
    {
      path: '/about',
      name: 'about',
      component: about
    },
    {
      path: '/my_news',
      name: 'my_news',
      component: my_news
    },
    {
      path: '/message',
      name: 'message',
      component: message
    },
    {
      path: '/set',
      name: 'set',
      component: set
    },
    {
      path: '/car_order',
      name: 'car_order',
      component: car_order
    },
    {
      path: '/set_phone',
      name: 'set_phone',
      component: set_phone
    },
    {
      path: '/amend_psd',
      name: 'amend_psd',
      component: amend_psd
    },
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/register',
      name: 'register',
      component: register
    },
    {
      path: '/forget_psd',
      name: 'forget_psd',
      component: forget_psd
    },
    {
      path: '/verify_phone',
      name: 'verify_phone',
      component: verify_phone
    }
  ]
})
