<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>邀请好友</span>
      <div class="right"></div>
    </div>
    <!-- 空DIV -->
    <div class="hight-r"></div>
    <div class="pic">
      <img src="../../assets/images/minepage/haoyous.jpg" alt>
    </div>
    <div class="btn" @click="show1 = true">
      <button class="affirm">邀请好友</button>
    </div>
    <!-- 分享弹窗 -->
    <yd-popup v-model="show1" position="bottom" width="100%">
      <div style="background-color:#fff;">
        <div class="fenx">
          <span>请点击右上角分享</span>
          <!-- <div @click="fenxiang()">
            <img src="../../assets/images/minepage/pyq.png" alt>
          </div>
          <div>
            <img src="../../assets/images/minepage/weixin.png">
          </div> -->
        </div>
        <div class="heng"></div>
        <div class="quxiao" @click="show1 = false">取消</div>
      </div>
    </yd-popup>
  </div>
</template>

<script>
import wx from "weixin-js-sdk";
export default {
  name: "index",
  data() {
    return {
      show1: false, //控制分享底部弹窗
      startpoint: "",
      wxConfig: {}
    };
  },
  methods: {
    back: function() {
      this.$router.go(-1);
    },
    handleScroll1(e) {
      this.startpoint = e.changedTouches[0]; //起点
    },
    handleScroll2(e) {
      let self = this;
      var X = e.changedTouches[0].clientX - this.startpoint.clientX;
      var Y = e.changedTouches[0].clientY - this.startpoint.clientY;
      // 滑动具体参考值
      var d = 200;
      if (Math.abs(X) > d) {
        if (X > 0) {
          self.$router.go(-1);
        }
        if (X < 0) {
        }
      }
    },
    back: function() {
      this.$router.go(-1);
    },
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
          wx.config(self.wxConfig);
          wx.ready(() => {
            //分享给朋友
            wx.updateAppMessageShareData({
              title: "Trip途倍趣",
              desc: "Trip途倍趣",
              link: "https://wechat.thinkwindtech.com/api/wechat/login",
              imgUrl:
                "https://wechat.thinkwindtech.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
              success: function(res) {
                self.$dialog.toast({
                  mes: "分享成功",
                  timeout: 1500,
                  icon: "success"
                });
              }
          });
          wx.updateTimelineShareData({
            title: "Trip途倍趣",
            desc: "Trip途倍趣",
            link: "https://wechat.thinkwindtech.com/api/wechat/login",
            imgUrl:"https://wechat.thinkwindtech.com/uploads/20190423/db29a9e6eb8ebf9c96e25cb4a9bd62d5.jpg",
            success: function(res) {
            self.$dialog.toast({
            mes: "分享成功",
            timeout: 1500,
            icon: "success"
          });
        
        }
      });
          });
          
        }
      });
    },
    // 微信分享
    // fenxiang: function() {
    //   //分享次数
    //   let self = this;
    //   wx.config(self.wxConfig);
    //   wx.ready(() => {
    //     //分享给朋友
        
    //   });
    //   //分享到朋友圈
     
    // }
  },
  destroyed: function() {
    console.log("我已经离开了！");
    window.removeEventListener("touchstart", this.handleScroll1, false);
    window.removeEventListener("touchmove", this.handleScroll2, false);
  },
  mounted() {
    window.addEventListener("touchstart", this.handleScroll1);
    window.addEventListener("touchmove", this.handleScroll2);
  },
  created() {
    // this.Sdk();
  }
};
</script>


<style scoped>
.homepage {
  background: #fff;
}
/* 顶部tab */
.top_tab {
  width: 100%;
  height: 1rem;
  padding: 0 0.3rem;
  background: #fff;
  display: flex;
  position: fixed;
  justify-content: space-between;
  align-items: center;
  z-index: 99999;
  box-shadow: 0.01rem 0.01rem 0.06rem #ddd;
}
.top_tab span {
  color: #000;
  font-size: 0.3rem;
  font-weight: bold;
}
.top_tab .left img {
  width: 0.26rem;
  height: 0.35rem;
  margin-top: 0.1rem;
}
/* 顶部空 */
.hight-r {
  height: 1rem;
}
.pic {
  width: 6.11rem;
  height: 9.04rem;
  margin: 0 auto;
  margin-top: 0.8rem;
}
.pic img {
  width: 100%;
  height: 100%;
}
.btn {
  width: 100%;
  display: flex;
  justify-content: center;
  padding: 0.2rem 0.2rem;
  margin-top: 0.2rem;
}
.btn .affirm {
  width: 86%;
  height: 0.75rem;
  background: #3682ef;
  border: none;
  border-radius: 5px;
  font-size: 0.28rem;
  color: #fff;
}
.meb {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 9999999;
}
.boxt {
  background: #f5f5f5;
  width: 100%;
  height: 3.5rem;
  position: fixed;
  left: 50%;
  top: 87%;
  transform: translate(-50%, -50%);
  z-index: 9999999;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
}
.boxt .fx {
  width: 100%;
  padding: 0.23rem 1.7rem;
  box-sizing: border-box;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #fff;
}
.boxt .qx {
  width: 100%;
  height: 0.8rem;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 0.2rem;
}
.boxt .fx .wx,
.boxt .fx .pyq {
  width: 0.92rem;
  height: 0.92rem;
}
.boxt .fx .wx img,
.boxt .fx .pyq img {
  width: 100%;
  height: 100%;
}
.fenx {
  width: 100%;
  height: 1.2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
.fenx span{
  font-size: .30rem;
}
.fenx div {
  text-align: center;
  flex: 1;
}
.fenx img {
  width: 0.54rem;
  height: 0.46rem;
  /* margin-top: 0.3rem; */
}
.heng {
  height: 0.2rem;
  background-color: #e6e6e6;
}
.quxiao {
  font-size: 16px;
  text-align: center;
  line-height: 0.8rem;
  height: 0.8rem;
}
</style>
