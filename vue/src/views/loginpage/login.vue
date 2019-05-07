<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>登录</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
    <div class="box">
      <div class="step1">
				<img src="../../assets/images/loginpage/phone.png">
        <input type="number" maxlength="11" placeholder="请输入手机号" v-model="mobile">
      </div>
      <div class="step2">
				<img src="../../assets/images/loginpage/mima.png">
        <input type="password" placeholder="请输入密码" v-model="password">
      </div>
      <div class="tj" @click="pasdlogin()">
        <span>提交</span>
      </div>
			<div class="menu">
				<span @click="registerClick()">注册</span>
				<span @click="forgetClick()">忘记密码？</span>
			</div>
    </div>
		<!-- <div class="weixin" @click="verifyClick()">
			<div class="pic">
				<img src="../../assets/images/loginpage/weixin.png">
			</div>
			<span>微信登录</span>
		</div> -->
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
			mobile:'',
			password:'',
      start1:false,
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		registerClick: function() {
      this.$router.push("register");
		},
		forgetClick: function() {
      this.$router.push("forget_psd");
		},
		verifyClick: function() {
      this.$router.push("verify_phone");
		},
		//密码登录
    pasdlogin() {
      if(this.mobile==''){
        self.$dialog.toast({
					mes: '请输入手机号',
					icon: "error",
					timeout: 1500
        });
        return
			}
			let reg_str = /^1\d{10}$/;
      if (!reg_str.test(this.mobile)) {
        self.$dialog.toast({
					mes: '请输入正确手机号',
					icon: "error",
					timeout: 1500
				});
        return;
      }
      if(this.password==''){
        self.$dialog.toast({
					mes: '请输入密码',
					icon: "error",
					timeout: 1500
				});
        return
      }
      if(this.password.length<6||this.password.length>20){
         self.$dialog.toast({
					mes: '密码长度为6-20之间',
					icon: "error",
					timeout: 1500
				});
        return
      }
      let self = this;
      let url = "/api/user/login?mobile="+this.mobile + "&password=" +this.password;
      self.httpGet(url, function(res) {
				if (res.code == 1) {
					localStorage.setItem("userid", res.data.id);
					localStorage.setItem("openid", res.data.openid);
					localStorage.setItem("phone", res.data.mobile);
					setTimeout(function () {
							//要延时执行的代码
							self.$router.push("/");
						}, 1500) //延迟时间
						self.$dialog.toast({ 
							mes: '登录成功',
							icon: "success",
							timeout: 1500
						});
				} else{
					self.$dialog.toast({
						mes: res.message,
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
  height:5.20rem;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  display: flex;
  flex-direction: column;
  padding: .74rem .89rem .3rem .89rem;
	margin-top: .05rem;
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
  margin-top: .25rem;
  position: relative;
}
.tj{
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
.tj span{
  color:#FFF;
	font-size: .30rem;
}
.menu{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .1rem;
}
.menu span{
	color:#666;
	font-size: .24rem;
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
.wx{
	width:100%;
	padding: 0 .30rem;
	margin-top: 3rem;
	/* border:1px solid red; */
}
.wx .tit{
	width:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.wx .tit span{
	font-size: .28rem;
	margin-left: .2rem;
	margin-right: .2rem;
	color:#ccc;
}
.wx .tit .lf {
	width: 1.2rem;
	height:1px;
	background: #CCC;
}
.wx .tit .rf {
	width: 1.2rem;
	height:1px;
	background: #CCC;
}
.weixin{
	width:100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	margin-top: 3rem;
}
.weixin .pic{
	width:.66rem;
	height:.54rem;
	overflow: hidden;
}
.weixin img{
	width:100%;
	height:100%;
}
.weixin span{
	color: #666;
	margin-top: .05rem;
}
</style>

