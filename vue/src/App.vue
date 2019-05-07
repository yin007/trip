<template>
  <div id="app">
    <router-view/>
    <!-- <keep-alive >
      <router-view v-if="$route.meta.keepAlive"></router-view>
    </keep-alive>
    <router-view v-if="!$route.meta.keepAlive"></router-view> -->
  </div>
</template>

<script>
import wx from "weixin-js-sdk";
export default {
  name: "App",
  data() {
    return {
      wxConfig: {}
    };
  },
  methods: {
      Sdk: function() {
      let self = this;
      let url = "/api/index/fen";
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          self.wxConfig = {
            debug: false,
            appId: res.data.appId,
            nonceStr: res.data.nonceStr,
            signature: res.data.signature,
            timestamp: res.data.timestamp,
            jsApiList: res.data.jsApiList
          };
          self.fenxiang();
        }
      });
    },
    fenxiang: function() {
      //分享次数
      let self = this;
      wx.config(self.wxConfig);
      wx.ready(() => {
        //分享到朋友圈
        wx.updateTimelineShareData({ 
          title: "Trip途倍趣",
          desc: "Trip途倍趣",
          link: "https://wechat.thinkwindtech.com/api/wechat/login",
          imgUrl:"https://wechat.thinkwindtech.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
          success: function(res) {
           
          },
        });
        //分享给朋友
        wx.updateAppMessageShareData({
        title: "Trip途倍趣",
          desc: "Trip途倍趣",
          link: "https://wechat.thinkwindtech.com/api/wechat/login",
          imgUrl:"https://wechat.thinkwindtech.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
          success: function(res) {
            
          },
        
        });
      });
    }
  },
  created() {
    this.Sdk();
  }
};
</script>
//       Sdk: function() {
//       let self = this;
//       let url = "/api/index/fen";
//       self.httpGet(url, function(res) {
//         if (res.code == 1) {
//           self.wxConfig = {
//             debug: false,
//             appId: res.data.appId,
//             nonceStr: res.data.nonceStr,
//             signature: res.data.signature,
//             timestamp: res.data.timestamp,
//             jsApiList: res.data.jsApiList
//           };
//           wx.config(self.wxConfig);
//           wx.ready(() => {
//             //分享给朋友
//             wx.updateAppMessageShareData({
//               title: "Trip途倍趣",
//               desc: "Trip途倍趣",
//               link: "http://fly.dev.whbpkj.com/api/wechat/login",
//               imgUrl:
//                 "http://fly.dev.whbpkj.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
//               success: function(res) {
//                 self.$dialog.toast({
//                   mes: "分享成功",
//                   timeout: 1500,
//                   icon: "success"
//                 });
//               }
//             });
//             wx.updateTimelineShareData({
//               title: "Trip途倍趣",
//               desc: "Trip途倍趣",
//               link: "http://fly.dev.whbpkj.com/api/wechat/login",
//               imgUrl:"http://fly.dev.whbpkj.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
//               success: function(res) {
//                 self.$dialog.toast({
//                 mes: "分享成功",
//                 timeout: 1500,
//                 icon: "success"
//                 });
//               }
//           });
//         });
          
//         }
//       });
//     },
          


    
//   created() {
//     this.Sdk();
//   }
// }
// </script>

<style>
*{  
  -webkit-touch-callout:none;  /*系统默认菜单被禁用*/  
  -webkit-user-select:none; /*webkit浏览器*/  
  -khtml-user-select:none; /*早期浏览器*/  
  -moz-user-select:none;/*火狐*/  
  -ms-user-select:none; /*IE10*/  
  user-select:none;  
  -webkit-overflow-scrolling: touch;
} 
input,textarea {
  -webkit-user-select:auto; /*webkit浏览器*/
  margin: 0px;
  padding: 0px;
  outline: none;
}
*{ -webkit-tap-highlight-color: rgba(0,0,0,0);-webkit-tap-highlight-color: transparent; /* For some Androids */ }
body {
  background-color: #fff!important;
  padding-bottom: 0.2rem;
  box-sizing: border-box;
}
#app {
   font-family: '微软雅黑';
   background-color: #fff!important;
  }
/* 去掉ios输入框阴影 */
input{
-webkit-appearance: none;
}
  .yd-tabbar-icon img {
  width: 0.6rem;
  height: 0.6rem;
}
.yd-tabbar-txt {
  font-size: 14px;
}
.yd-tabbar-fixed{
  box-shadow: darkgrey 1px 16px 20px 3px ;
  height:1rem;
}
.zanwu{
  width: 35%;
  margin: 0 auto;
  padding-top: 1rem;
}
.zanwu img{
  width: 100%;
}
.zanwu p{
  text-align: center;
  font-size: .28rem;
  color: #999;
}

/* 刷新 */
.shuaxing{
  background: #fff;
  width: .8rem;
  height: .8rem;
  border-radius: 100%;
  position: fixed;
  top: 0;
  left: 50%;
  z-index:3000;
  margin-left: -.4rem; 
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: #dfdfdf 0 0 3px 1px;
  top: 2rem;
}
.shuxing{
  width: .5rem;
}
.act{
  transform: all .5s inherit;
  -webkit-animation: circle 1s infinite linear;
  -webkit-animation: circle 1s infinite linear;
  animation: circle 1s infinite linear;
}

/* @-webkit-keyframes circle {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@-moz-keyframes circle {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
} */
.niubi1{
  transform: translate3d(0,0,0);
}
.niubi2{
  transform: translate3d(0,.8rem,0);
}
</style>
