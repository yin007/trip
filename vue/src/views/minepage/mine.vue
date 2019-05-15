<template>
  <div class="homepage"> 
		<!-- 登录用户信息 -->
		<div class="note" :style ="note">
			<div class="set" @click="setClick()">
				<div class="pic">
					<img src="../../assets/images/minepage/set.png">
				</div>
			</div>
			<div class="user">
				<div class="tx">
					<img :src="user.avatar">
				</div>
				<span class="name">{{user.username}}</span>
				<span class="phone">{{user.mobile}}</span>
			</div>
		</div>
		<!-- 我的订单 -->
		<div class="myorder">
			<span>我的订单</span>
			<div class="r" @click="myOrderClick()">
				<span>更多</span>
				<img src="../../assets/images/minepage/you.png">
			</div>
		</div>
		<div class="gc">
			<div class="step" @click="clickOrder(1)">
				<div class="pic">
					<img src="../../assets/images/minepage/zhifu.png"> 
				</div>
				<span>待支付</span>
			</div>
			<div class="step" @click="clickOrders(2)">
				<div class="pic">
					<img src="../../assets/images/minepage/lingqu.png">
				</div>
				<span>未领取</span>
			</div>
			<div class="step" @click="clickOrderd(3)">
				<div class="pic">
					<img src="../../assets/images/minepage/yq.png">
				</div>
				<span>已领取</span>
			</div>
			<div class="step" @click="clickOrderdt(4)">
				<div class="pic">
					<img src="../../assets/images/minepage/tuikuan.png">
				</div>
				<span>退款中</span>
			</div>
			<div class="step" @click="clickOrderds(5)">
				<div class="pic">
					<img src="../../assets/images/minepage/yilingqu.png">
				</div>
				<span>已完成</span>
			</div>
		</div>
		<!-- 菜单 -->
		<div class="menu">
			<div class="bar" @click="shop_carClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/car.png">
					</div>
					<span>购物车</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="my_discountsClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/juan.png">
					</div>
					<span>我的优惠券</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="my_newsClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/xin.png">
					</div>
					<span>我的消息</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="friendClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/yao.png">
					</div>
					<span>邀请好友</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="feedbackClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/yijian.png">
					</div>
					<span>意见反馈</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="FAQClick()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/wen.png">
					</div>
					<span>常见问题</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="aboutClick">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/about.png">
					</div>
					<span>关于我们</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
			<div class="bar" @click="Oclicks()">
				<div class="lf">
					<div class="pic">
						<img src="../../assets/images/minepage/kefu.png">
					</div>
					<span>联系客服</span>
				</div>
				<div class="rf">
					<img src="../../assets/images/minepage/you.png">
				</div>
			</div>
		</div>
    <!-- 空DIV 底部 -->
    <div class="hight-l"></div>
    <!-- 导航 -->
    <!-- <yd-tabbar fixed active-color="#2b8cf3">
      <yd-tabbar-item title="首页" link="/" >
        <img slot="icon" src="../../assets/images/homepage/home-hui.png">
      </yd-tabbar-item>
      <yd-tabbar-item title="我的" link="#" active>
        <img slot="icon" src="../../assets/images/homepage/mine.png">
      </yd-tabbar-item>
    </yd-tabbar> -->
		<div class="d_tab">
			<div class="lf">
				<div @click="homeClick()">
					<img src="../../assets/images/homepage/home-hui.png" alt="">
					<span>首页</span>
				</div>
			</div>
			<div class="rf">
				<div>
					<img src="../../assets/images/homepage/mine.png" alt="">
					<span>我的</span>
				</div>
			</div>
		</div>
		 <!-- 联系我们弹窗 -->
    <div class="mebs" v-if="shous">
      <div class="boxts">
        <div class="phone">
					<span class="ts">提示</span>
					<span class="num">确定拨打电话{{kf_phone}}吗？</span>
				</div>
				<div class="xz">
					<a :href="'tel:'+kf_phone" class="confirm">
						<span>确定</span>
					</a>
					<div class="abrogate" @click="vanishs()">
						<span>取消</span>
					</div>
				</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'mine',
  data () {
    return {
			index:1,
			user:'',
			kf_phone:'',
			shous: false,
			hb_val:'',
			hbtime:'',
			cityd:'',
			note: {
        backgroundImage: "url(" + require("../../assets/images/minepage/bj.png") + ")",
        backgroundRepeat: "no-repeat",
        backgroundSize: "100% 3.65rem",
      },
    }
  },
  methods: {
		homeClick: function() {
			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')  
			let jichangname = localStorage.getItem('start_shop')
			let endchangname = localStorage.getItem('end_shop')
			let ids = localStorage.getItem('ids') 
			let eid = localStorage.getItem('destination_')
			// let hb_val =localStorage.getItem('hbnumber')       
			// let hbtime =  localStorage.getItem('hbtime') 
      this.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" + jichangname +"&endchangname=" +endchangname +"&ids=" +ids +"&eid=" +eid +"&hb_val=" + this.hb_val +"&hbtime=" + this.hbtime);
		},
		vanishs: function() {
      this.shous = false;
		},
		Oclicks: function() {
      this.shous = true;
		},
		myOrderClick: function() {
      let index = 0;
			this.$router.push("/myOrder?index="+ index);
		},
		shop_carClick: function() {
      this.$router.push("/shop_car");
		},
		friendClick: function() {
      this.$router.push("/friend");
		},
		my_discountsClick: function() {
      this.$router.push("/my_discounts");
		},
		FAQClick: function() {
      this.$router.push("/FAQ");
		},
		feedbackClick: function() {
      this.$router.push("/feedback");
		},
		aboutClick: function() {
      this.$router.push("/about");
		},
		my_newsClick: function() {
      this.$router.push("/my_news");
		},
		setClick: function() {
      this.$router.push("/set");
		},
		clickOrder: function () {
			let index = 1;
			this.$router.push("/myOrder?index="+ index);
		},
		clickOrders: function () {
			let index = 2;
			this.$router.push("/myOrder?index="+ index);
		},
		clickOrderd: function () {
			let index = 3;
			this.$router.push("/myOrder?index="+ index);
		},
		clickOrderdt: function () {
			let index = 4;
			this.$router.push("/myOrder?index="+ index);
		},
		clickOrderds: function () {
			let index = 5;
			this.$router.push("/myOrder?index="+ index);
		},
		// 用户资料 
		getuser: function() {
			let self = this;
			let url = "/api/user/user"; 
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
					self.user = res.data;
				} else {
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
						icon: "error"
					});
				}
			});
		},
		about: function() {
			let self = this;
			let url = "/api/other/my"; 
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
					self.kf_phone = res.data.phone 
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
		this.cityd = localStorage.getItem('start_city')
		//航班号
		this.hb_val = this.$route.query.hb_val;
		//出发时间
		this.hbtime = this.$route.query.hbtime;
		// this.hb_val =localStorage.getItem('hbnumber')       
		this.getuser();
		this.about();
	}
}
</script>


<style scoped>
.homepage{
	background: #f2f2f2;
}
.d_tab{
	width:100%;
	height:1rem;
  padding:0 .3rem;
  background: #FFF;
  display: flex;
	position: fixed;
	bottom: 0;
  box-shadow: .01rem .01rem .06rem #ddd;
	z-index: 9999;
}
.d_tab .lf,.d_tab .rf{
	width:50%;
	height:100%;
	display: flex;
	justify-content: center;
}
.d_tab .lf div img,.d_tab .rf div img{
	width:.43rem;
	height:.43rem;
}
.d_tab .lf div,.d_tab .rf div{
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
.d_tab .lf div span{
	color: #666
}
.d_tab .rf div span{
	color: #3ba5ff
}
/* 顶部tab */
.top_tab {
  width:100%;
	height:1rem;
  padding:0 .3rem;
  background: #FFF;
  display: flex;
	position: fixed;
  justify-content: center;
  align-items: center;
  box-shadow: .01rem .01rem .06rem #ddd;
	z-index: 9999;
}
.top_tab span {
  color: #000;
  font-size: .30rem;
	font-weight: bold;
}
/* 顶部空 */
.hight-r {
  height: 1rem;
}
.note {
  width:100%;
  height: 3.65rem;
  display: flex;  
  flex-direction: column;
  padding: .30rem .30rem;   
  box-sizing: border-box;
}
.note .set{
	width:100%;
	display: flex;
	justify-content: flex-end;
}
.note .set .pic{
	width:.43rem;
	height:.43rem;
	overflow: hidden;
}
.note .set .pic img{
	width:100%;
	height:100%;
}
.note .user{
	width:100%;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}
.note .user .tx{
	width:1.24rem;
	height:1.24rem;
	border-radius: 50%;
	overflow: hidden;
}
.note .user .tx img{
	width:100%;
	height:100%;
}
.note .user .name{
	color:#FFF;
	font-size: .32rem;
	margin-top: .16rem;
}
.note .user .phone{
	color:#FFF;
	font-size: .28rem;
	margin-top: .10rem;
}
.myorder{
	width:100%;
	height:1rem;
	background: #FFF;
	padding: 0 .30rem;
	display: flex;
	justify-content: space-between;
	align-items: center;
	border-bottom: 1px solid #eeeded;
}
.myorder span{
	font-size: .27rem;
}
.myorder .r{
	height:100%;
	display: flex;
	align-items: center;
}
.myorder .r span{
	margin-top: .03rem;
}
.myorder .r img{
	width:.23rem;
	height:.34rem;
	/* margin-left: .01rem; */
}
.gc{
	width:100%;
	height:1.46rem;
	background: #FFF;
	display: flex;
	padding: 0 .30rem;
	justify-content: space-between;
}
.gc .step{
	width:14%;
	height:100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
}
.gc .step .pic{
	width:.47rem;
	height:.50rem;
	overflow: hidden;
}
.gc .step .pic img{
	width:100%;
	height:100%;
}
.gc .step  span{
	font-size: .30rem;
	margin-top: .1rem;
}
/* 菜单 */
.menu{
	width:100%;
	margin-top: .3rem;
	background: #FFF;
	display: flex;
	padding: 0 .30rem;
	flex-direction: column;
	margin-bottom: .3rem;
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
.hight-l {
  height: 1rem;
}
/* 弹窗 */
.mebs {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 99999;
}
.boxts {
  background: #FFF;
  width: 5.97rem;
  height: 2.9rem;
  position: fixed;
  padding: .3rem 0 0 0;
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%);
  z-index: 999999;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
}
.boxts .phone{
	width:100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	height:60%;
	border-bottom:.01rem solid #e5e5e5;
}
.boxts .phone .ts{
	font-size: .33rem;
	margin-top: .1rem;
}
.boxts .phone .num{
	font-size: .28rem;
	color: #666;
	margin-top: .3rem;
}
.boxts .xz{
	width:100%;
  height:40%;
	display: flex;
}
.boxts .xz .confirm,.boxts .xz .abrogate{
	width:50%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.boxts .xz .confirm span,.boxts .xz .abrogate span{
	font-size: .25rem;
}
.boxts .xz .confirm{
	border-right:.01rem solid #e5e5e5;
}
</style>
