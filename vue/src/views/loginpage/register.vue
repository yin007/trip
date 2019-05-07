<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>注册会员</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
    <div class="box">
      <div class="step1">
				<img src="../../assets/images/loginpage/shouji.png">
        <input type="number" maxlength="11" placeholder="请输入手机号" v-model="mobile">
      </div>
      <div class="step2">
				<img src="../../assets/images/loginpage/duanxin.png">
        <input type="number" placeholder="请输入手机验证码" v-model="captcha">
				<div class="hq">
					<yd-sendcode slot="right" 
            v-model="start1" 
            @click.native="sendCode1" 
            type="warning"
          ></yd-sendcode> 
				</div>
      </div>
			<div class="step1">
				<img src="../../assets/images/loginpage/mima.png">
        <input type="password" placeholder="请输入6-8位数字、字母和符号" v-model="password">
      </div>
			<div class="step1">
				<img src="../../assets/images/loginpage/mima.png">
        <input type="password" placeholder="请再次输入密码" v-model="password2">
      </div>
    </div>
		<div class="box2">
			<div class="step1">
				<img src="../../assets/images/loginpage/shouji.png">
        <input type="number" placeholder="请输入推荐人手机号（选填）" v-model="tuiphone">
      </div>
		</div>
		<div class="tj">
			<div class="zc" @click="sendCode3()">
				<span>注册</span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
      mobile:'',
      captcha:'',//验证码
      tuiphone:'',//推荐人号码
      password:'',
      password2:'',
      start1:false,
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
    //验证码获取
    sendCode1() {
      let self = this;
      let reg_str = /^1\d{10}$/;
      if (!reg_str.test(this.mobile)) {
        self.$dialog.toast({
            mes: '请输入正确手机号',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      self.$dialog.loading.open("发送中...");
      let url = "/api/sms/send?mobile="+this.mobile + "&event=1";
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
    // 判断验证码是否正确  
    sendCode2() {
      let self = this;
      let reg_str = /^1\d{10}$/;
      if (!reg_str.test(this.mobile)) {
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
      let url = "/api/sms/check?mobile="+this.mobile + "&event=1" +"&captcha=" +this.captcha;
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          // setTimeout(() => {
          //   self.$dialog.toast({
          //     mes: res.msg,
          //     icon: "success",
          //     timeout: 1500
          //   });
          // }, 1000);
        } else {
          self.$dialog.toast({
            mes: res.msg,
            icon: "error",
            timeout: 1500
          });
          return
        }
      });
    },
    //注册会员 
     sendCode3() {
      let self = this;
      let reg_str = /^1\d{10}$/;
      if (!reg_str.test(this.mobile)) {
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
      this.sendCode2()
      if(this.password==''){
        self.$dialog.toast({
            mes: '请输入密码',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      if(this.password2==''){
        self.$dialog.toast({
            mes: '请再次输入密码',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      if(this.password!=this.password2){
        self.$dialog.toast({
            mes: '两次输入密码不一致',
            icon: "error",
            timeout: 1500
          });
        return;
      }
      let url = "/api/user/register?mobile="+this.mobile +"&password=" +this.password +"&tuiphone=" +this.tuiphone;
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          setTimeout(() => {
            self.$dialog.toast({
              mes: res.msg,
              icon: "success",
              timeout: 1500
            });
          }, 1000);
        } else {
          self.$dialog.toast({
            mes: res.msg,
            icon: "error",
            timeout: 1500
          });
        }
      });
    },
  },
  created() {}
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
.box{
  width:100%;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  display: flex;
  flex-direction: column;
  padding: 0 .89rem;
	margin-top: .05rem;
}
.step1{
	margin-top: .2rem;
}
.step1,.step2{
  width:100%;
  height:.9rem;
  border-bottom: 1px solid #eee;
  padding: 0 .2rem;
	display: flex;
	align-items: center;
	border-radius: 3px;
}
.step1 img,.step2 img{
	width:.45rem;
	height:.45rem;
}
.step1 input{
  width:100%;
  height:100%;
  border:none;
}
.step2 input{
  width:70%;
  height:100%;
  border:none;
}
.step2{
  margin-top: .2rem;
  position: relative;
	display: flex;
	align-items: center;
}
.step2 .hq{
  width:2rem;
  height:.55rem;
  color:#42a8ff;
  border-radius: 5px;
  line-height: .55rem;
  text-align: center;
  position: absolute;
  right: 0;
}
.box2{
	width:100%;
	box-shadow: 0 1px 5px  rgba(0,0,0,.1);
	padding: 0 .89rem;
	margin-top: 1.5rem;
}
.box2 .step1{
	width:100%;
  height:.9rem;
  border-bottom: 1px solid #eee;
  padding: 0 .2rem;
	display: flex;
	align-items: center;
	border-radius: 3px;
}
.box2 .step1 img{
	width:.45rem;
	height:.45rem;
}
.box2 .step1 input{
	width:100%;
  height:100%;
  border:none;
}
.tj{
  width:100%;
	padding: 0 .89rem;
}
.tj .zc{
	width:100%;
	height:.8rem;
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	margin-top: .8rem;
	border-radius: 3px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.tj .zc span{
  color:#FFF;
	font-size: .30rem;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input:-moz-placeholder, textarea:-moz-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input::-moz-placeholder, textarea::-moz-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
</style>
<style>
.yd-btn-warning:not(.yd-btn-loading) {
  background: none!important;
}
.yd-btn-warning {
  color:#42a8ff!important;
}
</style>

