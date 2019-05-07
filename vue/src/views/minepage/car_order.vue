<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>确认订单</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<!-- 地址 -->
		<!-- <div class="site">
			<div class="pic">
				<img src="../../assets/images/homepage/dw.png">
			</div>
			<div class="xx">
				<div class="top">
					<span class="name">{{site.name}}</span>
					<span class="phone">{{site.phone}}</span>
				</div>
				<div class="location">
					<span>{{site.address}}</span>
				</div>
			</div>
		</div> -->
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
		<!-- 订单信息 -->
		<div class="pro" v-for="item in list" :key="item.id">
			<div class="cp">
				<div class="pic">
					<img :src="item.logoimage">
				</div>
				<div class="rf">
					<div class="title">
						<span>{{item.title}}</span>
						<span>X{{item.num}}</span>
					</div>
					<div class="price">
						<span>￥{{item.price}}</span>
					</div>
					<div class="cash">
						<span>押金：</span>
						<span class="ya_pri">￥{{item.depositprice}}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="xian">
			<div></div>
		</div>
		<div class="shuju">
			<div class="discounts">
				<span>优惠券</span>
				<div class="rf_">
					<span v-if="yhj_price>0">优惠<span class="org">&nbsp;{{yhj_price}}&nbsp;</span>元</span>
					<img src="../../assets/images/commn/nexts.png" @click="Oclicks()">
				</div>
			</div> 
			<div class="bar">
				<span>商品租金</span>
				<span class="org">+￥{{commodity_je}}</span>
			</div>
			<div class="bar">
				<span>押金</span>
				<span class="org">+￥{{cash_ya}}</span>
			</div> 
			<div class="bar">
				<span>优惠</span>
				<span class="org">-￥{{yhj_price}}</span>
			</div>
		</div>
		<div class="btn">
			<div class="sum">
				
				<span>合计：<span class="org">￥{{commodity_je + cash_ya -yhj_price}}</span></span>
			</div>
			<div class="qr" @click="pay()">
				<span>确认订单</span>
			</div>
		</div>
			<!-- 优惠券弹窗 -->
    <div class="mebs" v-if="shous">
      <div class="boxts">
				<div class="title">
					<div class="lf"></div>
					<span>优惠券</span>
					<div class="rf" @click="vanishs(0)">
						<img src="../../assets/images/commn/del.png">
					</div>
				</div>
				<div class="ts" v-if="press.length>0">
					<!-- <span>已选择推荐优惠，使用优惠券一张，共抵扣￥{{yhj_price}}元</span> -->
				</div>
				<div class="list">
					<div v-for="(item , index ) in press" :key="item.id" class="bar">
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
						<div class="xz" @click="ChangeMenu(index)" :class="yhj_index == index?'actives':''">
						</div>
					</div>
					<div class="qs" v-if="press.length==0">
						<div class="pic">
							<img src="../../assets/images/commn/qs.png" alt="">
						</div>
						<span>暂无可用优惠券~</span>
					</div>
				</div>
				<div class="qd" @click="vanishs(1)">
					<span>确定</span>
				</div>
      </div>
    </div>
		<!-- 空DIV 底部 -->
    <div class="hight-l"></div> 
  </div>
</template>

<script>
import wx from "weixin-js-sdk";
export default {
  name: 'order_form',
  data () {
    return {
			// sunm:0,
			// index:0,
			yhj_index:100,
			shous: false,
			// buy_num: 1,
			// logoimage:"",
			// title:"",
			price :"",
			// depositprice :"",
			// shopname :"",
			// name :"",
			address :"",
			// shop_phone :"",
			// eid:'',
			order_num:'',
			commodity_je:0,//商品金额
			cash_ya:20,//押金
			yhj_price:0,//优惠券
			yhj_id:'',//优惠券id
			total:0,//总金额
			list:[],
			curYUJ:0, 
			isd:'',
			site:'',//地址
			note: {
        backgroundImage: "url(" + require("../../assets/images/homepage/juan.png") + ")",
        backgroundRepeat: "no-repeat",
        backgroundSize: "100% 1.75rem",
			},
			press:[],
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1); 
			localStorage.removeItem('list')
    },
		vanishs: function(flag) {
			this.shous = false;
			if(flag)
			{
				this.curYUJ = this.yhj_price;
			}
		},
		Oclicks: function() {
      this.shous = true;
		},
		ChangeMenu: function(index) {
			this.yhj_index = index;
			this.yhj_price = this.press[this.yhj_index].price;
			this.yhj_id = this.press[this.yhj_index].id;
			console.log(11118888,this.yhj_price)
		},
		// 优惠卷
		discounts: function() {
     let self = this;
			let url = "/api/coupon/index?type=" +0; 
			self.httpGet(url,function(res) {
				if (res.code == 1) {
					self.press = res.data;
					if(res.data.length>0)
					{
						self.curYUJ = res.data[0].price;
					}
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
      let url = "/api/order/orderconfirm?order_sn=" + this.order_num;
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
		// 订单页
		myOrderClick: function() {
			this.$router.push("myOrder"); 
		},
		// 支付
		pay: function(order_num,yhj_id) {
      let self = this;
      let url = "/api/wechat_pay/wxpayjs?order_sn=" +this.order_num + "&coupon_record_id=" +this.yhj_id;
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
							self.myOrderClick()
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
		let ids = localStorage.getItem('ids')
		this.order_num = this.$route.query.order_num;
		this.discounts();
		this.list = JSON.parse(localStorage.getItem("list"));
		let sum  = 0;
		let ya = 0;
		for(var i=0;i<this.list.length;i++){
			sum = sum+(this.list[i].price*this.list[i].num)
			this.commodity_je= sum;
			ya = ya+(this.list[i].depositprice*this.list[i].num)
			this.cash_ya= ya;
		}
		
		
		console.log(11111,this.list)
		// this.ChangeMenu(0);
		this.getaddress(this.order_num)
	}
}
</script>


<style scoped>
.homepage{
	background: #fff;
	min-height:100vh;
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
	z-index: 99999;
  box-shadow: .01rem .01rem .06rem #ddd;
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
.site{
	width:100%;
	padding: .15rem .30rem;
	background: #FFF;
	display: flex;
	align-items: center;
	/* border-bottom: 1px solid #f2f2f2;;  */ 
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
.pro{
	width:100%;
	padding: .2rem .30rem;
	background: #FFF;
	display: flex;
	flex-direction: column;
	
}
.pro:last-child{
	border-bottom: none;
}
.pro .cp{
	width:100%;
	display: flex;
	align-items: center;
	border-bottom: 1px solid #f2f2f2;
}
.pro .cp:last-child{
	border-bottom: none;
}

.pro .cp .pic{
	width:2rem;
	height:1.5rem;
	overflow: hidden;
}
.pro .cp .pic img{
	width:100%;
	height:100%;
}
.pro .cp .rf{
	margin-left: .2rem;
}
.pro .cp .rf{
	width:70%;
}
.pro .cp .rf .title{
	display: flex;
	justify-content: space-between;
}
.pro .cp .rf .title span{
	font-size: .28rem;
}
.pro .cp .rf .price{
	font-size: .27rem;
	margin-top: .1rem;
}
.pro .cp .rf .price span{
	color:#ff7800;
}
.pro .cp .rf .cash .ya_pri{
	color:#ff7800;
}
.pro .xz{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .3rem;
}
.pro .xz .txt{
	font-size: .28rem;
}
.pro .xz .num{
	display: flex;
	align-items: center;
}
.pro .xz .num .add,.pro .xz .num .minus
{
	width:.45rem;
	height:.45rem;
	border-radius: 3px;
	border:1px solid #CCC;
	text-align: center;
	line-height: .35rem;
}
.pro .xz .num .add span,.pro .xz .num .minus span{
	font-size: .40rem;
}
.pro .xz .num .sz,.pro .xz .num .sz{
	font-size: .27rem;
	margin-left: .15rem;
	margin-right: .15rem;
}
.shuju .discounts{
	width:100%;
	margin-top: .2rem;
	display: flex;
	align-items: center;
	justify-content: space-between;
	border-bottom:1px solid #f2f2f2;
	padding: 0 0 .2rem 0;
}
.shuju .discounts span{
	font-size: .27rem;
}
.shuju .discounts .rf_{
	display: flex;
	align-items: center;
}
.shuju .discounts .rf_ img{
	width:.24rem;
	height:.13rem;
	margin-left: .1rem;
}
.org{
	color: #ff7800;
}
.xian{
	width:100%;
	padding:0 .3rem;
	display:flex;
	justify-content: center;
}
.xian div{
	width:100%;
	height:1px;
	background:#f2f2f2;
}
.shuju{
	width:100%;
	padding:0 .3rem .2rem .3rem;
	display:flex;
	flex-direction: column;
	box-shadow: 0 1px 10px  #f2f2f2;
}
.bar{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .2rem;
}
.bar span{
	font-size: .27rem;
}
.btn{
	width:100%;
	background: #FFF;
	height:1rem;
	position: fixed;
	bottom: 0;
	display: flex;
	justify-content: space-between;
	box-shadow: darkgrey 1px 16px 20px 3px ;
}
.btn .qr,.btn .sum{
	width:50%;
	height:100%;
}
.btn .sum{
	padding: .30rem .30rem;
	display: flex;
	align-items: center;
}
.btn .sum span{
	font-size: .28rem;
}
.btn .qr{
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	display: flex;
	justify-content: center;
	align-items: center;
}
.btn .qr span{
	color:#FFF;
	font-size: .28rem;
}

/* 购物车弹窗 */
.mebs, .meb{
	width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.4);
  z-index: 999999;
}
.boxts{
  background: #FFF;
  width: 100%;
  position: fixed;
  padding: 0  .3rem .5rem .3rem;
  bottom: 0;
  right: 0;
  z-index: 9999999;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.boxts .title{
	width:100%;
	height:.9rem;
	border-bottom: 1px solid #f2f2f2;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.boxts .title .lf{
	width:.6rem;
}
.boxts .title .rf{
	width:.35rem;
	height:.27rem;
	overflow: hidden;
}
.boxts .title span{
	font-size: .30rem;
}
.boxts .title .rf img{
	width:100%;
	height:100%;
}
.boxts .ts{
	width:100%;
	padding: .2rem .2rem;
	display: flex;
	justify-content: center;
	align-items: center;
}
.boxts .ts span{
	color: #666;
	font-size: .23rem;
}
.boxts .list{
	width:100%;
	height:5.45rem;
	overflow: hidden; 
	overflow-y: scroll; 
}
.boxts .list .bar{
	width:100%;
	height:1.75rem;
	padding: 0 .30rem 0 0;
	box-shadow: 0 1px 10px   #f2f2f2;
	display:flex;
	justify-content: space-between;
	align-items: center;
	margin-top: .1rem;
}
.boxts .list .bar:nth-child(1){
	margin-top: 0;
}
.boxts .list .bar .lf{
	width:2.24rem;
	height:100%;
	display: flex;
	align-items: center;
}
.boxts .list .bar .lf .pic{
	width:100%;
	height:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.boxts .list .bar .lf .pic span{
	color: #FFF
}
.boxts .list .bar .lf .pic .fh{
	font-size: .65rem;
	margin-top: .4rem;
}
.boxts .list .bar .lf .pic .num{
	font-size: 1.1rem;
}
.boxts .list .bar .xx{
	width:calc(100% - (2.24rem +.6rem));
	height:100%;
	display: flex;
	flex-direction: column;
	margin-left: .1rem;
	/* display: flex; */
	justify-content: center;
	/* border:1px solid red; */
}
.boxts .list .bar .xx .txt{
	font-size: .30rem;
}
.boxts .list .bar .xx .time{
	margin-top: .05rem;
	color: #999;
}
.boxts .list .bar .xz{
	width:.38rem;
	height:.39rem;
	/* border:1px solid red; */
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAACXBIWXMAAAsTAAALEwEAmpwYAAAG3mlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkMDc0ZTE5OS0yNTQwLTQyYzEtOGUwMS1iY2YzMWZiZTI0Y2EiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpkNzQ1NDViZC05OTBkLTkzNGQtOTAzNS1hMDU4YWRmYmY5NzEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ZDdlYjVlYWUtZGUwOS05OTQ2LWI0ZGQtOGQwZTc0MjkzZWFkIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChNYWNpbnRvc2gpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOS0wNC0xMVQxMzo0NjoxMCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTktMDQtMTFUMTM6NTQ6MDcrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTktMDQtMTFUMTM6NTQ6MDcrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpjYWRhYTY3Yy01OWE2LTQwNWQtYWQzMC1kY2MyNzdiNWM2ZTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ZDA3NGUxOTktMjU0MC00MmMxLThlMDEtYmNmMzFmYmUyNGNhIi8+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmM0ZWMyMDAwLTUxYjktNDU0NC04YjM1LWQzY2I0OGU3YWY1YSIgc3RFdnQ6d2hlbj0iMjAxOS0wNC0xMVQxMzo1NDowNyswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpkN2ViNWVhZS1kZTA5LTk5NDYtYjRkZC04ZDBlNzQyOTNlYWQiIHN0RXZ0OndoZW49IjIwMTktMDQtMTFUMTM6NTQ6MDcrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5hlzwPAAAEa0lEQVRYhc3YW6hUVRgH8N8ZjcpSwgTNUFOjUlO8URSU2UNEF0srgi4WGbsio6jIyG5iZgURloGuMixMCFJTqYcevBAlYqWRWpbXBDN6MKwsCzs9rLXP7DPNjHOO50h/GPb61vW/96z1rf/3NTU3N/s/omuthhBCvXG9cTYuw2CchR6p7SB2YwfWYDt+6jBiNXARJmFiItQIdmAZlmJdRxMbhmdwI5oq2vZiH/5I9snoi37JHoxH8Qjexwxs6QhiM/AkSsn+GyvxEb7GN/i1Ykx3DMFwXIVrcQJuwg14TnzRmmiqtflDCH0xL02a4x3MwZcNvFARo/EgJhfqVuJe8Ws3RiyEMFDcuP1T1TpMbQehSoxCwNhk/yAeoF2VHUuVFSGEPvi4QGoeLu8AUrAR47Ag2f3TWn2OSgyLRVcAr+A+/NkBpHIcwt14PdlnpzVrEwshzMb4ZM7Dwx1IqBJT8VYqj8fzxcaWPRZCGIbNqf4L5X3QmegibpEROCK6pW20/mJFxnceB1ISmVtTuQteyhtKEEIYgwmpbnGWZZsdP2xW3mMTMKaFGG5LzyOY1YkkhuBb0Yd1K9TPSmu3cCmFEHqIdx+syLJsayeRGoFPcC6uQa9C21asSOWJ6FHCSAxIlR92EqnT8V56Eq+jvRV98rUHYGRX0eHBP1jfCaROE7/Uecl+GjOr9Cs68HElDErGfuzsYFInYbm4t+DVGqTgO/yYyoNKyn/j3izLDnUgqSYswaXJXiRe5LXwu3h3woASeibjtxoDeqtylzWAD0TJk5O6vYExOYee1e7KIvriK1F3XdwGUnOV/eIG3NWGsYh+7EAqn1ql/Uzxi/XCp7ingTnn4/5UXoNLRHHZCHIOB0pi4AD9QgjdKjpuEJXA4WTPwwt1Jp6GLJW3i/HB4drdW+EUZam1u6R8Evson9AiFoh7JT8Y0/C2KJWLeLxAeg+uUP43GsE5OCOVd5awNhklXFhj0CrREed+brIo+gYW7Nmp/LMaqvQoGF0ory1hk/iGcHWdgd/jSjEIIUqUJZguymXiqbpeeXu0Bfnae7CplGXZQTHugwkhhKF1Bv+SJpiT7FFixHMi/hL/vs/aQWqo8ilehoO5u1iUnl3EL3A0PCRK7iJu1oaAtgLT09otXIoKdrky6+HKarYeJuEBvKGKbm8Q54t+kqgwrqO1gn2iUH5X+Q3qYamo19tLqktai6jHHssbWohlWbYFLyZzhOgoOxvz01pEWb0tb/hPwBtCWKUcKc0V/6rOwGtipASrxdi1BdXuyltEry0NfFNrGXys6JbmzEltT2u2QqMpgs/Fq2bjMZJqf4oAsizbJebCVqaqsaLCXJgmbw+hhWmOnNTKtEbVG6Ke7Nknuo+ZouyGO8RraQmm4AIx5VSJ7qltSuq7Po0lOuIZae6qmR7qp6GK5jA8K+a22pq4y9GcSD4lhnB10WhGcYuYdKuW6uxXhUQRnZrqzLEu/V5OxMan5wCtk8N7EqHV6bm/jev4F0ZBGeCWYteDAAAAAElFTkSuQmCC);
	background-size: 100% 100%;
}
.boxts .list .bar .actives{
	width:.38rem;
	height:.39rem;
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAnCAYAAABjYToLAAAACXBIWXMAAAsTAAALEwEAmpwYAAAHamlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkMDc0ZTE5OS0yNTQwLTQyYzEtOGUwMS1iY2YzMWZiZTI0Y2EiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpiYWU0Mjg2MS02NWI0LWM1NDctYmI5ZC1kOTRkYTlhNzc1NDEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M2YzZDBiYzctNmVjOC0yNTRhLWFiY2MtNmIxYWY1ZjEyNzhiIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChNYWNpbnRvc2gpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOS0wNC0xMVQxMzo0NjoxMCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTktMDQtMTFUMTM6NTU6MDIrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTktMDQtMTFUMTM6NTU6MDIrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpjYWRhYTY3Yy01OWE2LTQwNWQtYWQzMC1kY2MyNzdiNWM2ZTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ZDA3NGUxOTktMjU0MC00MmMxLThlMDEtYmNmMzFmYmUyNGNhIi8+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmM0ZWMyMDAwLTUxYjktNDU0NC04YjM1LWQzY2I0OGU3YWY1YSIgc3RFdnQ6d2hlbj0iMjAxOS0wNC0xMVQxMzo1NDowNyswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDozZjNkMGJjNy02ZWM4LTI1NGEtYWJjYy02YjFhZjVmMTI3OGIiIHN0RXZ0OndoZW49IjIwMTktMDQtMTFUMTM6NTU6MDIrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+eG1wLmRpZDowRTE1RDNGNTVDMUQxMUU5ODM1QzhBMThDQzgxMzIwMjwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pu4YgN4AAAMsSURBVFiFzdhPqFRlGMfxz5xuZCnEIIFUC7GNWklh6BSB/8KwhUVGEd1Ni7A/aAUVRFmLVC5k4Y3CEqGFg1QYJBbdFtfIWtyFiyLSIKIWmQtvGepGME6L95w7Z86dOXPmzr0z/Tbzvu953vd8mfd5n/c5TyWOY/9HDbV7UKu3nXMLtmAdluBGVHI2Mf7Ab/gOn+CHbsAq7f6xFmCP4FHc380LMvoKH+LjMsZRCZtlOIKPeoCCe5M1juDWXsG2C1uwuQegvDYnaz5bZFQE9h5GceUsQqWqYC8+aMfQ0sdqdYcFB++HvsR9+cFptLW6d/QPCjZhX36wCaxWtxXb+kWU0ZOCP09paitrdYvxq3IndS70rxABfpGD2GNwUHAF3k47lTiO1erW4uuBITVrLb5J/6Hn+vzyA/i8zbOXoLL6YLwIv+OqPkE9hfeT9iQW5p5fxpIIDw0I6h5c08JmCFsibOwT1LYM1CocxtVtbNcNCUd0rrUV+5P2BnyheJeWR6jOMdSODNSd+KwDFFQjzC8wuIxTPUCNYGfSvlsISQtKzJsfYV6BwQO4Ga/MEOrlpL0eY8ofsnmdIv1fQpq8G290AbUnA7VKSA6LdmaaIlwqeD6mkW2+hldLrLkbLybtDTiu3PZldSnChQKDa4V86bakv0tw5nZ6S2Pbyzp6K12IcKaD0Q04phFWdmo4dFYjeCFpd+PorXQmwokShlV8i5VJf4eGD6VQM3X0VjoxhHE8XsJ4oeDEG3EygVkknOqeHL2FxiurD8ZVIUEsG2gv4i78mBsvE9HL6DxuiiaGncOhLiYuEA7EmszYGjN39Lw+xWSaKC7HTzNY5Fjyu34WgFLdju+zOf+o3AfBALQPT9Oc47+OvweCE3Re5uqbApsY9g8eHgBQqsdwLu003ZUTw8b1P/8nXGFN3wDTLvGJYaOKr53Z1ohw6TepqD72DN6dY6jnheLKNHWq9mwSgu9s67RQjtrbzqBTPjYmZBa7hIjfqy7iTazA0SLDbkqdS/EEHsTiLoFOC3XY/fi5zIRuwFJVcYdQ01qJ63GdUHsgFEfO4k/hPj0qZDCTZYBS/QdpC7Tghf2doQAAAABJRU5ErkJggg==);
	background-size: 100% 100%;
}
.boxts .qd {
	width:100%;
	height:.80rem;
	display: flex;
	justify-content: center;
	align-items: center;
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	border-radius: 3px;
	margin-top: .5rem;
}

.boxts .qd span{
	color:#FFF;
	font-size: .30rem;
}
.list .qs{
	width:100;
	display: flex;
	flex-direction: column;
	align-items: center;
	padding: 1rem 0;
}
.list .qs .pic{
	width:2.78rem;
	height:2.80rem;
	overflow: hidden;
}
.list	.qs .pic img{
	width:100%;
	height:100%;
}
.list	.qs span{
	color:#666;
	margin-top: .1rem;
	font-size: .27rem;
}
.hight-l {
  height: 1rem;
}
</style>
