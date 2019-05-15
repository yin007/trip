<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>我的订单</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<ul class="tabs">
			<li @click="ChangeMenu(0)" :class="index == 0?'actives':''">
				<span>全部</span>
			</li>
			<li @click="ChangeMenu(1)" :class="index == 1?'actives':''">
				<span>待支付</span>
			</li>
			<li @click="ChangeMenu(2)" :class="index == 2?'actives':''">
				<span>未领取</span>
			</li>
			<li @click="ChangeMenu(3)" :class="index == 3?'actives':''"> 
				<span>已领取</span>
			</li>
			<li @click="ChangeMenu(4)" :class="index == 4?'actives':''"> 
				<span>退款中</span>
			</li>
			<li @click="ChangeMenu(5)" :class="index == 5?'actives':''">
				<span>已完成</span>
			</li>
		</ul>
		<div class="list">
			<div class="bar" v-for="item in list" :key="item.id">
				<div class="top">
					<div class="lf">
						<img src="../../assets/images/minepage/shop.png" alt="">  
						<span>{{item.shop_name}}</span>
					</div>
					<div class="rf">
						<span v-if="item.status==1 || item.stau==1">待支付</span> 
						<span v-if="item.status==2 || item.stau==2">未领取</span>
						<span v-if="item.status==3 || item.stau==3">已领取</span>
						<span v-if="item.status==6">已取消</span>
						<span v-if="item.status==4">退款中</span>
						<img  v-if="(item.status==5 || item.stau==5) || (item.status==6)" @click="del(item.order_sn)" src="../../assets/images/minepage/deldel.png" alt="">
					</div>
				</div>
				<router-link :to='"/order_details?order_sn="+item.order_sn' v-for="itemName in item.goods" :key="itemName.id" class="center">
					<div class="pic">
						<img :src="itemName.logoimage" alt="">
					</div>
					<div class="xx">
						<div class="step1">
							<span class="name">{{itemName.title}}</span>
							<span class="num">X{{itemName.num}}</span>
						</div>
						<div class="step2">
							<span>实付款：<span class="price">￥{{itemName.total}}</span></span>
						</div>
					</div>
				</router-link>
				<div class="bt">
						<div class="qx" v-if="item.status==1 || item.stau==1" @click="abolish(item.order_sn)">
							<span>取消</span>
						</div>
						<router-link :to='"/order_details?order_sn="+item.order_sn' class="btn" v-if="item.status==1 || item.stau==1">
							<span>去支付</span>
						</router-link>
						<router-link :to='"/order_details?order_sn="+item.order_sn' class="btn" v-if="item.status==2 || item.stau==2">
							<span>去领取</span>
						</router-link>
						<router-link :to='"/order_details?order_sn="+item.order_sn' class="btn" v-if="item.status==3 || item.stau==3">
							<span>还设备</span>
						</router-link>
				</div>
				<div class="accomplish" v-if="item.status==5 || item.stau==5">
					<img src="../../assets/images/minepage/wancheng.png" alt="">
				</div>
			</div>
		</div>
		<div class="qs" v-if="list.length==0">
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
			index:'',
			list:[],
			goods:[],
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		order_detailsClick: function() {
      this.$router.push("order_details");
		},
		// 订单列表
		ChangeMenu: function(index) {
      this.index = index;
			let self = this;
			let type = index;
			let url = "/api/order/index?type=" +type; 
			self.httpGet(url,function(res) {
				if (res.code == 1) {
					self.list = res.data;
					for(var i=0; i<self.list.length; i++){
						self.list[i].stau = type;	
					} 
					console.log(1111112,self.list)
				} else {
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
						icon: "error"
					});
				}
			});
		},
		//取消
		abolish(id){
			let self = this;
			this.$dialog.confirm({
				title: '是否取消？',
				mes: '',
				opts: () => {
					let url = '/api/order/ordercancel?order_sn='+id;
					self.httpGet(url,  function (res) {
						if (res.code == 1) {
							self.ChangeMenu(0)
							self.$dialog.toast({mes:res.msg});
						}else{
							self.$dialog.toast({mes:res.msg});
						}
					})
				}
			});
		},
		//删除
		del(id){
			let self = this;
			this.$dialog.confirm({
				title: '是否删除？',
				mes: '',
				opts: () => {
					let url = '/api/order/orderdel?order_sn='+id;
					self.httpGet(url,  function (res) {
						if (res.code == 1) {
							self.ChangeMenu(0)
							self.$dialog.toast({mes:res.msg});
						}else{
							self.$dialog.toast({mes:res.msg});
						}
					})
				}
			});
		},
  },
  created() {
		
		// this.lease();
		this.index = this.$route.query.index;
		this.ChangeMenu(this.index);
		console.log(1111,this.index)
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
	width:14%;
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
	padding: 0 .30rem .30rem .30rem;
	background: #FFF;
	display: flex;
	flex-direction: column;
}
.list .bar{
	width:100%;
	/* height:3.7rem; */
	box-shadow:  0 1px 5px rgba(219,219,218,.9);
	margin-top: .30rem;
	position: relative;
}
.list .bar .top{
	width:100%;
	height:.9rem;
	border-bottom: 1px solid #f2f2f2;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.list .bar .top{
	width:100%;
	padding: 0 .2rem;
}
.list .bar .top .lf{
	display: flex;
	align-items: center;
}
.list .bar .top .lf img{
	width:.48rem;
	height:.48rem;
}
.list .bar .top .lf span{
	margin-left: .01rem;
	font-size: .27rem;
}
.list .bar .top .rf{
	display: flex;
	align-items: center;
}
.list .bar .top .rf span{
	color:#37a3ff;
	font-size: .27rem;
}
.list .bar .top .rf img{
	width:.48rem;
	height:.48rem;
}
.list .bar .center{
	width:100%;
	height:1.9rem;
	/* border-bottom: 1px solid #f2f2f2; */
	padding: 0 .2rem;
	display: flex;
	align-items: center;
}
.list .bar .center .pic{
	width:2rem;
	height:1.5rem;
	border-radius: 5px;
	overflow: hidden;
}
.list .bar .center .pic img{
	width:100%;
	height:100%;
}
.list .bar .center .xx{
	width:68%;
	margin-left: .1rem;
	display: flex;
	flex-direction: column;
}
.list .bar .center .xx .step1{
	display: flex;
	justify-content: space-between;
}
.list .bar .center .xx .step1 span{
	font-size: .27rem;
}
.list .bar .center .xx .step2{
	margin-top: .1rem;
}
.list .bar .center .xx .step2 span{
	font-size: .25rem;
}
.list .bar .center .xx .step2 .price{
	color: #ff7800;
}
.list .bar .bt{
	width:100%;
	height:.9rem;
	display: flex;
	justify-content: flex-end;
	padding: 0 .2rem;
	align-items: center;
	border-top:1px solid #f2f2f2;
}
.list .bar .bt .btn,.list .bar .bt .qx{
	width:1rem;
	height:.47rem;
	background: #ff7a04;
	border-radius: 5px;
	text-align: center;
	line-height: .47rem;
}
.list .bar .bt .btn span,.list .bar .bt .qx span{
	color:#FFF;
}
.list .bar .bt .btn{
	margin-left: .1rem;
}
.list .accomplish{
	position: absolute;
	top:0;
	right: .55rem;
}
.list .accomplish img{
	width:1.36rem;
	height:1.05rem;
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

