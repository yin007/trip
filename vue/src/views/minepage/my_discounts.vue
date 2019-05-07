<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>我的优惠券</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<ul class="tabs">
			<li @click="ChangeMenu(0)" :class="index == 0?'actives':''">
				<span>未使用</span>
			</li>
			<li @click="ChangeMenu(1)" :class="index == 1?'actives':''">
				<span>已使用</span>
			</li>
			<li @click="ChangeMenu(2)" :class="index == 2?'actives':''">
				<span>已到期</span>
			</li>
		</ul>
		<div class="list">
			<div v-for="item in press" :key="item.id">
				<div class="bar">
					<div class="lf">
						<div class="pic" :style ="note">
							<span class="fh">￥</span>
							<span class="num">{{item.price}}</span>
						</div>
					</div>
					<div class="xx">
						<span class="txt">{{item.title}}</span>
						<span class="time">2019.03.05-2019.05.02</span>
					</div>
					<div class="sy" v-if="item.status==1">
						<img src="../../assets/images/minepage/yishiyong.png" alt="">
					</div>
					<div class="sy" v-if="item.status==2">
						<img src="../../assets/images/minepage/yidaoqi.png" alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="qs" v-if="press.length==0">
			<div class="pic">
				<img src="../../assets/images/commn/qs.png" alt="">
			</div>
			<span>暂无数据~</span>
		</div>
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
			index:0,
			press:[],
			note: {
        backgroundImage: "url(" + require("../../assets/images/homepage/juan.png") + ")",
        backgroundRepeat: "no-repeat",
        backgroundSize: "100% 1.75rem",
			},
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		order_detailsClick: function() {
      this.$router.push("order_details");
		},
		ChangeMenu: function(index) {
      this.index = index;
			let self = this;
			let type = index;
			let url = "/api/coupon/index?type=" +type; 
			self.httpGet(url,function(res) {
				if (res.code == 1) {
					self.press = res.data;
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
		this.ChangeMenu(0)
	}
}
</script>


<style scoped>
.lease{
	background: #fff;
	min-height: 100vh;
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
.tabs{
	width:100%;
	height:.8rem;
	background: #FFF;
	display: flex;
	padding: 0 .30rem;
	justify-content: space-between;
}
.tabs li{
	width:50%;
	height:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.tabs li span{
	font-size: .28rem;
}
.actives{
	color:#37a3ff;
	position: relative;
}
.actives::after{
	position: absolute;
	content: "";
	width:.6rem;
	height:.06rem;
	background: #37a3ff;
	left: 50%;
	transform:translateX(-50%);
	top:.75rem;
} 
/* 列表 */
.list{
	width:100%;
	padding: .30rem .30rem;
	background: #FFF;
	display: flex;
	flex-direction: column;
}
.list .bar{
	width:100%;
	height:1.75rem;
	padding: 0 .30rem 0 0;
	box-shadow: 0 1px 10px   #f2f2f2;
	display: flex;
	align-items: center;
	margin-bottom: .2rem;
	position: relative;
}
 .list .bar .lf{
	display: flex;
	align-items: center;
}
 .list .bar .lf .pic{
	width:2.24rem;
	height:1.75rem;
	display: flex;
	justify-content: center;
	align-items: center;
}
 .list .bar .lf .pic span{
	color: #FFF
}
 .list .bar .lf .pic .fh{
	font-size: .65rem;
	margin-top: .4rem;
}
 .list .bar .lf .pic .num{
	font-size: 1.1rem;
}
 .list .bar .xx{
	display: flex;
	flex-direction: column;
	margin-left: .1rem;
	display: flex;
	justify-content: center;
}
 .list .bar .xx .txt{
	font-size: .30rem;
}
 .list .bar .xx .time{
	margin-top: .05rem;
	color: #999;
}
.list .bar .sy{
	width:1.22rem;
	height:1.20rem;
	overflow: hidden;
	position: absolute;
	top:0;
	right: 0;
}
.list .bar .sy img{
	width:100%;
	height:100%;
}
.qs{
		width:100;
		display: flex;
		flex-direction: column;
		align-items: center;
		padding: 1rem 0;
	}
	.qs .pic{
		width:2.78rem;
		height:2.80rem;
		overflow: hidden;
	}
	.qs .pic img{
		width:100%;
		height:100%;
	}
	.qs span{
		color:#666;
		margin-top: .1rem;
		font-size: .27rem;
	}
</style>

