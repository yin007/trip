<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>绑定手机号</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<!-- <div class="note" :style ="note">
      <span class="title">当前手机号</span>
      <span>{{oldphone}}</span>
		</div> -->
    <div class="box">
      <div class="step1">
        <input type="number" maxlength="11" placeholder="请输入手机号" v-model="newphone">
      </div>
      <div class="step2">
        <input type="number" placeholder="请输入手机验证码" v-model="captcha">
        <div class="hq">
					<yd-sendcode slot="right" 
            v-model="start1" 
            @click.native="sendCode1" 
            type="warning"
          ></yd-sendcode> 
				</div>
      </div>
      <div class="tj" @click="setphone()">
        <span>提交</span>
      </div>
    </div>
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
      oldphone:'',
      newphone:'',
      captcha:'',//验证码
      start1:false,
			note: {
        backgroundImage: "url(" + require("../../assets/images/minepage/bjs.png") + ")",
        backgroundRepeat: "no-repeat",
        backgroundSize: "100% 2.26rem",
      },
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
    //验证码获取
    sendCode1() {
      let self = this;
      if(self.newphone==''){
        self.$dialog.toast({
            mes: '请输入新手机号',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      let reg_strs = /^1\d{10}$/;
      if (!reg_strs.test(self.newphone)) {
        self.$dialog.toast({
            mes: '请输入正确手机号',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      self.$dialog.loading.open("发送中...");
      let url = "/api/sms/send?mobile="+this.newphone + "&event=4";
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          setTimeout(() => {
            self.start1 = true;
            self.$dialog.loading.close();
            self.$dialog.toast({
              mes: res.msg,
              icon: "success",
              timeout: 1500
            });
          }, 1000);
        } else {
          self.$dialog.loading.close();
          self.$dialog.toast({
            mes: res.msg,
            icon: "error",
            timeout: 1500
          });
        }
      });
    },
    // 修改手机号 
		setphone: function() { 
      let self = this;
      if(self.newphone==''){
        self.$dialog.toast({
            mes: '请输入新手机号',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      let reg_strs = /^1\d{10}$/;
      if (!reg_strs.test(self.newphone)) {
        self.$dialog.toast({
            mes: '请输入正确手机号',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      if(this.captcha==''){
        self.$dialog.toast({
            mes: '请输入验证码',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      let url = "/api/user/changemobile?newphone=" + this.newphone;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
          setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/mine");
					}, 1500) //延迟时间
					self.$dialog.toast({ 
						mes: '修改成功！',
						icon: "success",
						timeout: 1500 
					});
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
  },
  created() {
    this.oldphone =localStorage.getItem('phone')
    this.oldphone = this.oldphone.substr(0,3)+"****"+this.oldphone.substr(7);
  }
}
</script>


<style scoped>
.lease{
	background: #fff;
}
/* 顶部tab */
.top_tab {
  width:100%;
	height:1rem;
  padding:0 .3rem;
  background: #FFF;
  display: flex;
	position: fixed;
  justify-content: space-between;
  align-items: center;
	z-index: 99999999999999;
	border-bottom:1px solid #f2f2f2;
}
.top_tab span {
  color: #000;
  font-size: .30rem;
	font-weight: bold;
}
.top_tab .left img {
  width: 0.26rem;
	height: 0.35rem;
	margin-top: .1rem;
}
/* 顶部空 */
.hight-r {
  height: 1rem;
}
.note{
	width:100%;
	height:2.26rem;
	padding: .49rem .30rem;
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
}
.note span{
  color:#FFF;
  font-size: .28rem;
}
.note .title{
  margin-bottom: .2rem;
}
.box{
  width:100%;
  /* height:5.20rem; */
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  display: flex;
  flex-direction: column;
  padding: .74rem .89rem;
}
.step1,.step2,.step3{
  width:100%;
  height:.83rem;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  padding: 0 .2rem;
}
.step1 input,.step3 input{
  width:100%;
  height:100%;
  border:none;
  font-size: .27rem;
}
.step2{
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: .27rem;
}
.step2 input{
  width:70%;
  height:100%;
  border:none;
}
.step1{
   margin-top: .25rem;
}
.step2{
  margin-top: .25rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  /* position: relative; */
}
.step2 .hq{
  width:2rem;
  height:.55rem;
  color:#42a8ff;
  border-radius: 5px;
  line-height: .55rem;
  text-align: center;
  /* position: absolute;
  right: 0; */

  /* height:100%;
  display: flex;
  justify-content: center;
  align-items: center; */
}
.tj{
  width:100%;
	height:.8rem;
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	margin-top: 1.05rem;
	border-radius: 3px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.tj span{
  color:#FFF;
	font-size: .30rem;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
	color: #666; 
  font-size: .27rem;
} 
input:-moz-placeholder, textarea:-moz-placeholder { 
	color: #666; 
  font-size: .27rem;
} 
input::-moz-placeholder, textarea::-moz-placeholder { 
	color: #666;
  font-size: .27rem; 
} 
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	color: #666; 
  font-size: .27rem;
} 
</style>
<style>
.yd-btn-warning:not(.yd-btn-loading) {
  background: none!important;
}
.yd-btn-warning {
  color:#42a8ff!important;
}
.yd-btn-disabled{
  color:#333!important;
  background: none!important;
}
</style>

