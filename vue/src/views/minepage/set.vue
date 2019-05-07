<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>设置</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="menu">
			<!-- <div class="bar" @click="amend_psdClick()">
				<div class="lf">
					<span>修改密码</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div> -->
			<div class="bar" @click="set_phoneClick()">
				<div class="lf">
					<span>绑定手机号</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="identityClick()">
				<div class="lf">
					<span>实名认证</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
		</div>
		<!-- <div class="btn" @click="exit()">
			<div>
				<span>退出登录</span>
			</div>
		</div> -->
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		set_phoneClick: function() {
      this.$router.push("/set_phone");
		},
		identityClick: function() {
      this.$router.push("/identity");
		},
		loginClick: function() {
      this.$router.push("/login");
		},
		amend_psdClick: function() {
      this.$router.push("/amend_psd");
		},
		// 退出登录 
		exit: function() {
			let self = this;
			localStorage.removeItem('openid')
			localStorage.removeItem('userid')
			if(localStorage.getItem('userid') == null && localStorage.getItem('openid') == null){
				setTimeout(function () {
					window.location.href = "https://wechat.thinkwindtech.com/api/wechat/login";
				}, 1500) 
				self.$dialog.toast({ 
					mes: '退出成功',
					icon: "success",
					timeout: 1500
				});
			}
		},
  },
  created() {}
}
</script>


<style scoped>
.lease{
	background: #f2f2f2;
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
.menu{
	width:100%;
	background: #FFF;
	display: flex;
	padding: 0 .30rem;
	flex-direction: column;
	box-shadow: 0 1px 5px  rgba(0,0,0,.1);
}
.menu .bar{
	width:100%;
	height:1rem;
	border-bottom:1px solid #eeeded;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.menu .bar .lf{
	height:100%;
	display: flex;
	align-items: center;
}
.menu .bar .lf .pic{
	width:.41rem;
	height:.43rem;
	overflow: hidden;
}
.menu .bar .lf .pic img{
	width:100%;
	height:100%;
}
.menu .bar .lf span{
	font-size: .28rem;
	margin-left: .15rem;
}
.menu .bar .rf img{
	width:.23rem;
	height:.34rem;
	margin-top: .1rem;
}
.btn{
	width:100%;
	padding: .30rem .30rem;
	position: fixed;
	bottom: 0;
}
.btn div{
	width:100%;
	border:1px solid #37a3ff;
	height:1rem;
	display: flex;
	justify-content: center;
	align-items: center;
}
.btn div span{
	color:#37a3ff;
	font-size: .28rem;
}
</style>

