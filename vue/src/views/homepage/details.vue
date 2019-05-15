<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>详情</span>
      <div class="right"> 
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="pro-img">
				<img :src="details.logoimage">
		</div>
		<div class="xx">
			<span class="name">{{details.title}}</span>
			<div class="price">
				<span>租赁：<span class="org">￥{{details.price}}</span>/次</span>
				<span>押金：<span class="org">￥{{details.depositprice}}</span>/个</span>
			</div>
			<div class="price">
				<span>库存：<span class="org">{{details.stock}}</span>&nbsp;件</span>
			</div>
		</div>
		<div class="center">
			<div>
				<span v-html="details.content"></span>
			</div>
		</div>
		<div class="guige">
			<img v-for="(item,index) in details.detailimages" :key="index" :src="item">
		</div>
    <!-- 空DIV 底部 -->
    <div class="hight-l"></div>
    <div class="btn">
			<div class="car" @click="Oclicks()">
				<span>加入购物车</span>
			</div>
			<div class="order" @click="Oclick()">
				<span>立即下单</span>
			</div>
		</div>
		<!-- 购物车弹窗 -->
    <div class="mebs" v-if="shous">
      <div class="boxts">
				<div class="top">
					<div class="pro">
						<div class="pic">
							<img :src="details.logoimage">
						</div>
						<span>￥{{details.price*car_num}}</span>
					</div>
					<div class="del" @click="vanishs()">
						<img src="../../assets/images/commn/del.png">
					</div>
				</div>
				<div class="fg">
					<div class="xian"></div>
				</div>
				<div class="xz">
					<span class="txt">租赁数量</span>
					<div class="num">
						<div class="minus" @click="car_num>1?car_num--:''">
							<span>-</span>
						</div>
						<span class="sz">{{car_num}}</span>
						<div class="add" @click="car_num<stock?car_num++:''">
							<span>+</span>
						</div>
					</div>
				</div>
				<div class="btn_car" @click="AddCar()">
					<span>加入购物车</span>
				</div>
      </div>
    </div>
		<!-- 立即购买弹窗 -->
    <div class="meb" v-if="shou">
      <div class="boxt">
				<div class="top">
					<div class="pro">
						<div class="pic">
							<img :src="details.logoimage">
						</div>
						<span>￥{{details.price*buy_num}}</span>
					</div>
					<div class="del" @click="vanish()">
						<img src="../../assets/images/commn/del.png">
					</div>
				</div>
				<div class="fg">
					<div class="xian"></div>
				</div>
				<div class="xz">
					<span class="txt">租赁数量</span>
					<div class="num">
						<div class="minus" @click="buy_num>1?buy_num--:''">
							<span>-</span>
						</div>
						<span class="sz">{{buy_num}}</span>
						<div class="add" @click="buy_num<stock?buy_num++:''">
							<span>+</span>
						</div>
					</div>
				</div>
				<div class="btn_car" @click="notarize()">
					<span>确定</span>
				</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'index',
  data () {
    return {
			car_num: 1,//购物车
			buy_num: 1,//立即购买
			logoimage:"",
			hb_val:"",
			title:"",
			price :"",
			depositprice :"",
			id:"",
			details:"",
			shou: false,//立即购买
			shous: false,//购物车
			order_num:"",//订单编号
			stock:"", //库存
			cityd:"",  
			endcity:"",
			start_shop:"",
			destination_:"",
			hbnumber:"",
			hbtime:"",
			jichangname:"",
			endchangname:"",
    }
  },
  methods: {
		back: function() {
			this.$router.push("/?cityd=" +this.cityd 
																	 +"&endcity=" +this.endcity 
																	 +"&ids=" +this.start_shop 
																	 + "&eid=" + this.destination_ 
																	 +"&hb_val=" + this.hb_val 
																	 +"&hbtime=" +this.hbtime 
																	 +"&jichangname=" +this.jichangname 
																	 +"&endchangname=" +this.endchangname);
    },
		// 购物车
		vanishs: function() {
      this.shous = false;
		},
		Oclicks: function() {
      this.shous = true;
		},
		// 立即购买
		vanish: function() {
      this.shou = false;
		},
		// 绑定手机号
		set_phoneClick: function() {
      this.$router.push("/set_phone");
		},
		Oclick: function() {
      this.shou = true;
		},
		orderClick: function(logoimage,title,price,depositprice,buy_num,id,order_num) {
			this.$router.push("order_form?logoimage=" +this.logoimage 
																								+"&title=" +this.title 
																								+"&price=" +this.price 
																								+"&depositprice=" +this.depositprice 
																								+"&eid=" +this.id  
																								+"&buy_num=" +this.buy_num
																								+"&order_num=" +this.order_num
																								);
		},
		detail: function(id) {
      let self = this;
      let url = "/api/index/equidetail?eid=" +this.id;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.details = res.data;
					self.logoimage = res.data.logoimage;
					self.title = res.data.title;
					self.price = res.data.price;
					self.depositprice = res.data.depositprice;
					self.stock = res.data.stock;
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		// 加入购物车 
		AddCar: function() { 
			let self = this;
			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')
			let start_shop = localStorage.getItem('ids')
			let destination_ = localStorage.getItem('destination_')
			let hbnumber = localStorage.getItem('hbnumber')
			let hbtime = localStorage.getItem('hbtime')

			let jichangname = localStorage.getItem('start_shop')
			let endchangname = localStorage.getItem('end_shop')

			if((cityd=='' || cityd== undefined) || (endcity=='' || endcity==undefined) ||
				(start_shop=='' || start_shop == undefined) || (destination_=='' || destination_==undefined) ||
				(hbnumber=='' || hbnumber==undefined) || (hbtime=='' || hbtime==undefined)){
					setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" + endchangname  +"&ids=" + start_shop +"&eid="+ destination_ +"&hb_val=" + this.hb_val);
					}, 1500) //延迟时间
					self.$dialog.toast({
						mes: '请补全行程信息！',
						timeout: 1500,
					});
					return 
			}
			let url = "/api/shop_car/index?shopid=" + this.details.shop_id 
																							+ "&eid=" + this.details.id 
																							+"&num="+this.car_num
																							+"&start_city=" + cityd  //出发地城市
																							+"&destination_city=" + endcity //目的地地城市
																							+"&start_shop=" + start_shop //出发地城市id
																							+"&destination_shop=" + destination_ //目的地城市id
																							+"&hbnumber=" + this.hb_val  //航班号
																							+"&hbtime=" + hbtime; //出发时间
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/shop_car");
					}, 1500) //延迟时间
					self.$dialog.toast({ 
						mes: '添加成功！',
						icon: "success",
						timeout: 1500
					});
        } else if (res.data.code == 202){
					setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" + endchangname  +"&ids=" + start_shop +"&eid="+ destination_ +"&hb_val=" + this.hb_val);
					}, 1500) //延迟时间
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		//确认订单 
		notarize: function() {
			let self = this;
			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')
			let start_shop = localStorage.getItem('ids')
			let destination_ = localStorage.getItem('destination_')
			let hbnumber = localStorage.getItem('hbnumber')
			let hbtime = localStorage.getItem('hbtime')

			let jichangname = localStorage.getItem('start_shop')
			let endchangname = localStorage.getItem('end_shop')
			if((cityd=='' || cityd== undefined) || (endcity=='' || endcity==undefined) ||
				(start_shop=='' || start_shop == undefined) || (destination_=='' || destination_==undefined) ||
				(hbnumber=='' || hbnumber==undefined) || (hbtime=='' || hbtime==undefined)){
					setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" + endchangname  +"&ids=" + start_shop +"&eid="+ destination_ +"&hb_val=" + this.hb_val);
					}, 1500) //延迟时间
					self.$dialog.toast({
						mes: '请补全行程信息！',
						timeout: 1500,
					});
					return
			}


			let url = "/api/index/order?shopid=" + this.details.shop_id 
																					 + "&eid=" + this.details.id 
																					 +"&num="+this.buy_num 
																					 +"&start_city=" + cityd  //出发地城市
																					 +"&destination_city=" + endcity //目的地地城市
																					 +"&start_shop=" + start_shop //出发地城市id
																					 +"&destination_shop=" + destination_ //目的地城市id
																					 +"&hbnumber=" + this.hb_val  //航班号
																					 +"&hbtime=" + hbtime; //出发时间
			self.httpGet(url, function(res) { 
				console.log(1111,res)
				if (res.code == 1) {
					self.order_num = res.data
					setTimeout(function () {
						self.orderClick()
					}, 1500) 
					self.$dialog.toast({ 
						mes: res.msg,
						icon: "success",
						timeout: 1500
					});
				} else if (res.data.code == 202){ 
					setTimeout(function () {
							//要延时执行的代码
							self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" + endchangname  +"&ids=" + start_shop +"&eid="+ destination_ +"&hb_val=" + this.hb_val);
						}, 1500) //延迟时间
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
					});
				}else if(res.data.code == 201){
					setTimeout(function () {
						self.set_phoneClick()
					}, 1500) 
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
					});
				}else if(res.data.code == 204){
					setTimeout(function () {
						//要延时执行的代码
						self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" + jichangname +"&endchangname=" + endchangname  +"&ids=" + start_shop +"&eid="+ destination_ +"&hb_val=" + this.hb_val);
					}, 1500) //延迟时间
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
					});
				}
			});
		},
  },
  created() {
		this.id = this.$route.query.id;
		this.detail(this.id)
		//航班号
		this.hb_val = this.$route.query.hb_val;
		this.cityd = localStorage.getItem('start_city') //出发城市  undefined
		this.endcity = localStorage.getItem('endcity') //目的地城市
		this.start_shop = localStorage.getItem('ids')  //出发门店id
		this.destination_ = localStorage.getItem('destination_') //目的地门店id
		this.hbnumber = localStorage.getItem('hbnumber') //航班号
		this.hbtime = localStorage.getItem('hbtime') //起飞时间

		this.jichangname = localStorage.getItem('start_shop')
		this.endchangname = localStorage.getItem('end_shop')
	}
}
</script>


<style scoped>
.homepage{
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
.pro-img{
	width:100%;
	/* height:4rem; */
	/* overflow: hidden; */
}
.pro-img img{
	width:100%;
	/* height:100%; */
}
.xx{
	width:100%;
	/* height:1.5rem; */
	background: #FFF;
	padding: .20rem .30rem;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	border-top:1px solid #f2f2f2;
	border-bottom:1px solid #f2f2f2;
}
.xx .name{
	font-size: .32rem;
}
.xx .price{
	margin-top: .02rem;
}
.xx .price span{
	font-size: .27rem;
}
.xx .price span:nth-child(2){
	margin-left: .5rem;
}
.xx .price .org{
	color:#ff7800;
}
.center{
	width:100%;
	padding: .2rem .3rem;
}
.center div{
	width:100%;
}
.guige{
	width:100%;
}
.guige img{
	width:100%;
}
.hight-l {
  height: .5rem;
}
.btn{
	width:100%;
	height:1rem;
	position: fixed;
	bottom: 0;
	z-index: 99999;;
	display: flex;
	justify-content: space-between;
}
.btn .car,.btn .order{
	width:50%;
	height:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.btn .car span,.btn .order span{
	color: #FFF;
	font-size: .30rem;
}
.btn .car{
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
}
.btn .order{
	background:-webkit-linear-gradient(left,#ff7200,#fb9e53);
	background:-o-linear-gradient(right,#ff7200,#fb9e53);
	background:-moz-linear-gradient(right,#ff7200,#fb9e53);
	background:linear-gradient(to right,#ff7200,#fb9e53);
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
.boxts,.boxt {
  background: #FFF;
  width: 100%;
  height: 5rem;
  position: fixed;
  padding: .3rem .3rem;
  bottom: 0;
  right: 0;
  z-index: 9999999;
  display: flex;
  flex-direction: column;
  align-items: center;
	border-top-left-radius: 7px;
  border-top-right-radius: 7px;
}
.boxts .top,.boxt .top{
	width:100%;
	display: flex;
	justify-content: space-between;
}
.boxts .top .pro,.boxt .top .pro{
	display: flex;
	align-items: center;
}
.boxts .top .pro .pic,.boxt .top .pro .pic{
	width:2rem;
	height:1.5rem;
	overflow: hidden;
	border-radius: 2px;
}
.boxts .top .pro .pic img,.boxt .top .pro .pic img{
	width:100%;
	height:100%;
}
.boxts .top .pro span,.boxt .top .pro span{
	color:#ff7800;
	font-size: .30rem;
	margin-left: .1rem;
}
.boxts .top .del,.boxt .top .del{
	width:100%;
	display: flex;
	justify-content: flex-end;
}
.boxts .top .del img,.boxt .top .del img{
	width:.35rem;
	height:.27rem;
}
.boxts .fg,.boxt .fg{
	width:100%;
	height:.4rem;
	display: flex;
	justify-content: center;
	align-items: center;
	border-bottom:1px solid #e5e5e5;
}
.boxts .xz,.boxt .xz{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .3rem;
}
.boxts .xz .txt,.boxt .xz .txt{
	font-size: .32rem;
}
.boxts .xz .num,.boxt .xz .num{
	display: flex;
	align-items: center;
}
.boxts .xz .num .add,.boxts .xz .num .minus,
.boxt .xz .num .add,.boxt .xz .num .minus
{
	width:.50rem;
	height:.50rem;
	border-radius: 3px;
	border:1px solid #CCC;
	text-align: center;
	line-height: .40rem;
}
.boxts .xz .num .add span,.boxts .xz .num .minus span,
.boxt .xz .num .add span,.boxt .xz .num .minus span
{
	font-size: .40rem;
}
.boxts .xz .num .sz,.boxt .xz .num .sz{
	font-size: .27rem;
	margin-left: .15rem;
	margin-right: .15rem;
}
.boxts .btn_car,.boxt .btn_car{
	width:90%;
	height:.8rem;
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	margin-top: .6rem;
	border-radius: 3px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.boxts .btn_car span,.boxt .btn_car span{
	color:#FFF;
	font-size: .30rem;
}
</style>
<style>
element.style{
	width:30%!important;
}
</style>
