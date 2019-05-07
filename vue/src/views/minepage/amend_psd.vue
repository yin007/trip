<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>修改密码</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
    <div class="box">
      <div class="step1">
        <input type="password" placeholder="请输入原登录密码" v-model="oldpassword"> 
      </div>
			<div class="step1">
        <input type="password" placeholder="请输入新登录密码" v-model="newpassword">
      </div>
			<div class="step1">
        <input type="password" placeholder="请再次输入新登录密码" v-model="newpasswords">
      </div>
      <div class="tj" @click="amend_pad">
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
      oldpassword:'',
      newpassword:'',
      newpasswords:'',
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
    // 修改密码   
    amend_pad() {
      let self = this;
      if(self.oldpassword==''){
        self.$dialog.toast({
					mes: '请输入原登录密码',
					icon: "error",
					timeout: 1500
        });
        return
			}
      if(self.newpassword==''){
        self.$dialog.toast({
					mes: '请输入新登录密码',
					icon: "error",
					timeout: 1500
				});
        return
      }
      if(self.newpasswords==''){
        self.$dialog.toast({
					mes: '请再次输入新登录密码',
					icon: "error",
					timeout: 1500
				});
        return
      }
      if(self.newpassword != self.newpasswords){
        self.$dialog.toast({
					mes: '两次输入密码不一致，请确认！',
					icon: "error",
					timeout: 1500
				});
        return
      }
      let url = "/api/user/resetpwd?oldpassword="+self.oldpassword + "&newpassword=" +self.newpassword;
      self.httpGet(url, function(res) {
				if (res.code == 1) {
				  setTimeout(function () {
							//要延时执行的代码
							self.$router.push("/login");
						}, 1500) //延迟时间
						self.$dialog.toast({ 
							mes: '修改成功！',
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
.box{
  width:100%;
  /* height:5.20rem; */
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  display: flex;
  flex-direction: column;
  padding: .5rem .89rem 1rem .89rem;
}
.step1{
  width:100%;
  height:.83rem;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  padding: 0 .2rem;
	margin-top: .2rem;
}
.step1 input{
  width:100%;
  height:100%;
  border:none;
}
/* .step2{
  display: flex;
  align-items: center;
  justify-content: space-between;
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
.step2 .hq{
  width:2rem;
  height:.55rem;
  color:#42a8ff;
  border-radius: 5px;
  line-height: .55rem;
  text-align: center;
  position: absolute;
  right: 0;
} */
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
	color: #9e9e9e; 
} 
input:-moz-placeholder, textarea:-moz-placeholder { 
	color: #9e9e9e; 
} 
input::-moz-placeholder, textarea::-moz-placeholder { 
	color: #9e9e9e; 
} 
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	color: #9e9e9e; 
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

