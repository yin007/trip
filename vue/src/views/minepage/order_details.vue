<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>订单详情</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="note" :style ="note">
			<div class="state">
				<div class="pic">
					<!-- 待支付 -->
					<img src="../../assets/images/minepage/daizhifu.png" alt="" v-if="details.status==1">
					<!-- 待领取 -->
					<img src="../../assets/images/minepage/dailingqu.png" alt="" v-if="details.status==2">
					<!-- 租赁中 -->
					<img src="../../assets/images/minepage/zulinzhong.png" alt="" v-if="details.status==3">
					<!-- 退款中 -->
					<img src="../../assets/images/minepage/tui.png" alt="" v-if="details.status==4">
					<!-- 已完成 -->
					<img src="../../assets/images/minepage/yiwancheng.png" alt="" v-if="details.status==5">
					<!-- 已取消 -->
					<img src="../../assets/images/minepage/qx.png" alt="" v-if="details.status==6">
				</div>
				<span v-if="details.status==1">待支付</span>
				<span v-if="details.status==2">待领取</span>
				<span v-if="details.status==3">租赁中</span>
				<span v-if="details.status==4">退款中</span>
				<span v-if="details.status==5">已完成</span>
				<span v-if="details.status==6">已取消</span>
			</div>
		</div>
		<div class="site">
			<div class="pic">
				<img src="../../assets/images/homepage/qi.png">
			</div>
			<div class="xx">
				<div class="top">
					<span class="name">{{site.start_shop_name}}</span>
					<a :href="'tel:'+site.phone" class="ph">
						<span class="phone">{{site.phone}}</span>
						<img src="../../assets/images/homepage/dh.png">
					</a>
				</div>
				<div class="location">
					<span>{{site.address}}</span> 
				</div>
			</div>
		</div>
		<div class="xian">
			<div class="s"></div>
		</div>
		<div class="site">
			<div class="pic">
				<img src="../../assets/images/homepage/zhong.png">
			</div>
			<div class="xx">
				<div class="top">
					<span class="name">{{site.destination_shop_name}}</span>
					<a :href="'tel:'+site.destination_shop_phone" class="ph">
						<span class="phone">{{site.destination_shop_phone}}</span>
						<img src="../../assets/images/homepage/dh.png">
					</a>
				</div>
				<div class="location">
					<span>{{site.destination_shop_address}}</span>
				</div>
			</div>
		</div>
		<div class="info">
			<div class="hbh">
				<img src="../../assets/images/homepage/fly.png"> 
				<span>航班号：{{site.hbnumber}}</span>
			</div>
			<div class="time">
				<img class="fly" src="../../assets/images/homepage/times.png">
				<span>起飞时间：{{site.hbtime}}</span>
			</div>
		</div>
		<div class="fg"></div>
		<div class="order">
			<div class="center" v-for="item in details.goods" :key="item.id">
				<div class="pic">
					<img class="xzs" :src="item.logoimage">
				</div>
				<div class="rf">
					<div class="title">
						<span class="name">{{item.title}}</span>
						<span class="num">X{{item.num}}</span>
					</div>
					<div class="price">
						<span>￥{{item.price}}</span>
					</div>
				</div>
			</div>
			<div class="ofg"></div>
			<div class="yf ds" v-if="details.coupon_money!=0">  
				<span>优惠</span>
				<span class="org">-￥{{details.coupon_money}}</span>
			</div>
			<div class="yf">
				<span>押金</span>
				<span class="org">￥{{details.depositprice}}</span>
			</div>
			<div class="yf">  
				<span>实付款</span>
				<span class="org">￥{{details.allprice}}</span>
			</div>
		</div>
		<div class="fg"></div>
		<div class="information">
			<div class="infos"> 
				<span>订单信息</span>
			</div>
			<div class="numb">
				<span>订单编号：{{details.order_sn}}</span>
				<span v-if="details.createtime!=null">下单时间：{{details.createtime*1000 | date}}</span>
				<span v-if="details.paytime!=null">付款时间：{{details.paytime*1000 | date}}</span>
				<span v-if="details.starttime!=null">领取时间：{{details.starttime*1000 | date}}</span>
				<span v-if="details.endtime!=null">归还时间：{{details.endtime*1000 | date}}</span>
			</div>
		</div>
		<!-- 空DIV 底部 -->
    <div class="hight-l" v-if="details.status==1 || details.status==2 || details.status==3"></div>
		<div class="btn" v-if="details.status==1 || details.status==2 || details.status==3">
			<!-- 去支付 -->
			<div class="zf" @click="pays()" v-if="details.status==1">
				<span>确认付款</span>
			</div>
			<!-- 去领取 -->
			<div class="lq" @click="gethold()" v-if="details.status==2">
				<span>确认领取</span>
			</div>
			<!-- 去归还 -->
			<div class="gh" @click="repay()" v-if="details.status==3">
				<span>确认归还</span>
			</div>
		</div>
	</div>
</template>

<script>
import wx from "weixin-js-sdk";
import moment from 'moment';
import 'moment/locale/zh-cn'
moment.locale('zh-cn')
export default {
  name: 'myOrder',
  data () {
    return {
			site:'',//地址
			details:'',
			order_sn:'',
			order_num:'',
			note: {
        backgroundImage: "url(" + require("../../assets/images/minepage/bjs.png") + ")",
        backgroundRepeat: "no-repeat",
        backgroundSize: "100% 2.26rem",
      },
    }
	},
	filters:{
		date(val){
			return moment(val).format(("YYYY-M-D H:mm"))
		},
		formatDate(time) { 
      return moment(time).format("Do")
    }
	},
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		//详情数据
		orderdetail: function(order_sn) {
      let self = this;
      let url = "/api/order/orderdetail?order_sn=" +this.order_sn;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.details = res.data;
					self.order_num = res.data.order_sn;
					console.log(66666,self.order_num)
					self.getaddress(self.order_num)
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		// 地址
		getaddress: function(order_num) {
			let self = this;
			console.log(333333335,order_num)
      let url = "/api/order/orderconfirm?order_sn=" + self.order_num;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.site = res.data
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		//去领取
		gethold:function(order_sn) {
      let self = this;
      let url = "/api/order/orderreceive?order_sn=" +this.order_sn;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					setTimeout(function () {
							self.orderdetail(this.order_sn)
						}, 1500) 
						self.$dialog.toast({ 
							mes: res.msg,
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
		//归还设备  
		repay: function(order_sn) {
      let self = this;
      let url = "/api/order/orderend?order_sn=" +this.order_sn;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					setTimeout(function () {
							self.orderdetail(this.order_sn)
						}, 1500) 
						self.$dialog.toast({ 
							mes: res.msg,
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
		pays: function(order_sn) {
      let self = this;
      let url = "/api/wechat_pay/wxpayjs?order_sn=" +self.order_sn;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					wx.config({
						debug: false,  
						appId: res.data.appId, 
						timestamp: res.data.timestamp,  
						nonceStr: res.data.nonceStr, 
						signature: "0391d095c8903f6202993ceef28e593978684bc5",
						jsApiList: [
							'chooseWXPay'
						] 
					});
					wx.chooseWXPay({
						timestamp: res.data.timeStamp, 
						nonceStr: res.data.nonceStr, 
						package: res.data.package, 
						signType: res.data.signType, 
						paySign: res.data.paySign, 
						success: function (res) {
							self.orderdetail(this.order_id)
						}
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
		let that = this;
		that.order_sn = that.$route.query.order_sn;
		that.orderdetail(that.order_sn);
	}
}
</script>


<style scoped>
.lease{
	background: #fff;
	min-height: 100vh;
}
.site{
	width:100%;
	padding: .15rem .30rem;
	background: #FFF;
	display: flex;
	align-items: center;
}
.site .pic{
	height:100%;
	width:10%;
	display: flex;
	align-items: center;
	justify-content: flex-start;
}
.site .pic img{
	width:.5rem;
	height:.5rem;
}
.info{
	width:100%;
	padding: 0 .30rem;
	display: flex;
	display: flex;
	flex-direction: column;
	background: #fff;
}
.info .hbh{
	padding: .2rem 0 0 0;
	border-top:1px solid #f2f2f2;
}
.info .hbh img{
	width:.35rem;
	height:.20rem;
	margin-right: .1rem;
}
.info .time img{
	width:.35rem;
	height:.35rem;
	margin-right: .1rem;
}
.info .time{
	padding: .1rem 0 .2rem 0;
}
.info .hbh,.info .time{
	width:100%;
	display: flex;
	align-items: center;
}
.xian{
	width:100%;
	padding: 0 .30rem;
	background: none; 
}
.xian .s{
	width:100%;
	height:1px;
	background: #f2f2f2; 
}
.fg{
	width:100%;
	height:.15rem;
	background: #f2f2f2;
}
.xx{
	width:91%;
	height:100%;
	display: flex;
	flex-direction: column;
	padding: .20rem 0;
	margin-left: .2rem;
}
.xx .top{
	width:100%;
	display: flex;
	justify-content: space-between;
}
.xx .top .name{
	font-size: .28rem;
}
.xx .top .ph span{
	font-size: .28rem;
}
.xx .top .ph{
	display: flex;
	align-items: center;
}
.xx .top .ph img{
	width:.35rem;
	height:.35rem;
	margin-left: .05rem
}
.xx .top .ph span{
	font-size: .27rem;
}
.xx .location{
	width:100%;
	margin-top: .1rem; 
}
.xx .location span{
	font-size: .27rem;
	color: #666;
}
/* nameph */
.site .box .txt span{
	font-size: .27rem;
	color:#666;
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
	height:1.7rem;
	padding: .49rem .30rem;
	position: relative;
}
.note .state{
	display: flex;
	justify-content: flex-start;
	align-items: center;
}
.note .state .pic{
	width:.68rem;
	height:.68rem;
	overflow: hidden;
}
.note .state .pic img{
	width:100%;
	height:100%;
}
.note .state span{
	color:#FFF;
	font-size: .28rem;
	margin-left: .1rem;
}

.order{
	width:100%;
	background: #FFF;
	padding: 0  .30rem .3rem .30rem;
}
.order .center{
	width:100%;
	padding: .30rem 0;
	display: flex;
	align-items: center;
	/* border-bottom: 1px solid #f2f2f2; */
}
.order .ofg{
	width:100%;
	height:1px;
	background: #f2f2f2;
}
.order .center .pic{
	width:2rem;
	height:1.5rem;
	overflow: hidden;
}
.order .center .pic img{
	width:100%;
	height:100%;
}
.order .center .rf{
	display: flex;
	flex-direction: column;
	width:68%;
	margin: .1rem;
}
.order .center .rf .title{
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.order .center .rf .title span{
	font-size: .28rem;
}
.order .center .rf .price{
	margin-top: .1rem;
}
.order .center .rf .price span{
	color: #ff7800;
	font-size: .27rem;
}
.order .yf{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .15rem;
}

.order .yf span{
	font-size: .25rem;
}
.order .yf .org{
	color: #ff7800;
}
.information{
	width:100%;
	padding: 0 .30rem;
	background: #FFF;
}
.information .infos{
	width:100%;
	padding: .15rem 0;
	border-bottom: 1px solid #f2f2f2;
}
.information .infos span{
	font-size: .28rem;
}
.information .numb{
	width:100%;
	padding: .2rem 0 .08rem 0;
	display: flex;
	flex-direction: column;
}
.information .numb span{
	margin-bottom: .12rem;
	font-size: .26rem;
}
.hight-l {
  height: 1.2rem;
}
.btn{
	width: 100%;
	height: 1rem;
	display: flex;
	padding: 0 .30rem;
	justify-content: space-between;
	position: fixed;
	bottom: 0;
	background: #fff;
	padding-left: 5%;
	z-index: 9;
	box-shadow: darkgrey 1px 16px 20px 3px ;
	display: flex;
	justify-content:flex-end;
	align-items: center;
}
.btn .zf,.btn .gh,.btn .lq{
	width:1.6rem;
	height:.6rem;
	display: flex;
	justify-content: center;
	align-items: center;
	background: #3ba5ff;
	border-radius: 5px;
}
.btn .zf span{
	color: #fff;
	font-size: .27rem;
}
.btn .lq span{
	color: #fff;
	font-size: .27rem;
}
.btn .gh span{
	color: #fff;
	font-size: .27rem;
}
</style>

