<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>购物车</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="list" >
			<!-- <div v-for="item in list" :key="item.id"> -->
			<div v-for="(item , index ) in list"  :key="item.id">
				<div class="bar">
					<div class="top">
						<div class="lf">
								<img src="../../assets/images/minepage/shop.png" alt="">
								<span>{{item.name}}</span>
						</div>
					</div>
					<div class="center">
						<!-- 门店下，所有商品 -->
						<!-- 此处应该还是一个v-for循环，但是由于数据是一维，暂定如此 -->
						<yd-checkbox val=" "
							v-model= item.selected
							shape="circle"
							@change.native="selectedShopSingle(index,item.selected)"
							color="#ff7200">
						</yd-checkbox>
						<div class="pic">
							<img :src="item.logoimage" alt="">
						</div>
						<div class="xx">
							<div class="step1">
								<span class="name">{{item.title}}</span>
								<div class="del" @click="onDel(item.id)">
									<img src="../../assets/images/minepage/deldel.png" alt="">
								</div>
							</div>
							<div class="step2">
								<span class="price">￥{{item.price}}</span>
								<div class="nums">
									<div @click="carNumberChange(index,0,item.id,item.num-1)">-</div>
									<div>{{item.num}}</div>
									<div @click="carNumberChange(index,1,item.id,item.num+1)">+</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 空DIV 底部 -->
    <div class="hight-l"></div>
		<div class="shopfooter" v-if="list.length>0">
      <div class="shopfotleft">
        <div class="leftleft">
					<!-- 所有门店下的所有商品全选中 -->
          <yd-checkbox @change.native="selectedAll(selected)" shape="circle" color="#ff7200" val=" " v-model="selected"></yd-checkbox>
          <div class="shoptidianm">全选</div>
        </div>
        <div class="shopfothj" style="word-break:normal ">
         <span> 合计：￥{{Math.floor(total_prices*100)/100}}</span>
        </div>
      </div>
      <div class="shopfotright" @click="notarize()">去结算({{total}})</div>
    </div>
		<div class="qs" v-if="list.length==0">
			<div class="pic">
				<img src="../../assets/images/commn/qs.png" alt="">
			</div>
			<span>购物车空的哟~</span>
		</div>
	</div>
</template> 

<script>
export default {
  name: 'myOrder',
  data () {
    return {
			list:[],
			// 全选
			allCheck: false,
			total:0,//购物车总数
			total_prices:0,
			selected:false,
			idArr:[],//产品id数组
			numArr:[],//产品id数组
			order_num:"",//订单编号
			lists:[]
    }
  },
  methods: {

		// 绑定手机号
		set_phoneClick: function() {
      this.$router.push("/set_phone");
		},
		carNumberChange: function(idx,flag,id,num) {
			let self = this;
			let url = '/api/shop_car/carnum?id='+ id +"&num=" +num;
			self.httpGet(url, function (res) {
				if (res.code == 1) {}
			})
			if(flag)
			{
				self.list[idx].num++;
			}
			else
			{
				if(self.list[idx].num>1)
					self.list[idx].num--;	
			}

			self.statistics();
		},

		car_orderClick: function() {
      this.$router.push("car_order"); 
		},
		orderClick: function(logoimage,title,price,depositprice,buy_num,id,order_num) {
			this.$router.push("car_order?order_num=" +this.order_num );
		},
		selectedAll:function(selected){
			let i=0;
			let	status = selected;
			for(i=0;i<this.list.length;i++){
					//应该是二维数组但是传过来是一维
					//所有商品选中，置为true
					this.list[i].selected = status;	
			}
			this.statistics();
		},
		statistics:function(){
			let sum = 0,i=0;
			let nums =0;
			let lists = new Array();
			let car_id = new Array();
			// debugger
			for(i=0;i<this.list.length;i++){
					if(this.list[i].selected){
						sum += this.list[i].num*this.list[i].price;	
						nums += this.list[i].num;	
						lists.push(this.list[i]);
						car_id.push(this.list[i].id) ;
						this.numArr.push(this.list[i].num);
					}	
			}
			this.total_prices = sum;
			this.total =nums;
			this.idArr = car_id;
			this.lists = lists;
			localStorage.setItem("list", JSON.stringify(lists));
			console.log(99999999,this.idArr)
		},

		selectedShopSingle:function(idx,selected){
			let self = this;
			let i=0 , sta=0;
			if(selected){
				self.list[idx].selected = true;
			}else{
				self.list[idx].selected = false;
				self.selected = false;
			}
			self.statistics();
			for(i=0;i<self.list.length;i++){
					if(self.list[i].selected)
						sta++;
			}
			if(sta>=self.list.length)
				self.selected = true;
			
		},

		back: function() {
			this.$router.go(-1);
    },
		// 购物车列表  
		shop_car() {
			let self = this;
			let start_shop = localStorage.getItem('ids')
			if(start_shop=='undefined'){
				start_shop=0
			}
			let url = '/api/shop_car/car?shopid='+ start_shop;
			self.httpGet(url, function (res) {
				if (res.code == 1) {
					self.list = res.data
					let i=0;
					for(i=0;i<self.list.length;i++){
							//	应该是二维数组但是传过来是一维？
							self.list[i].selected = false;
							// self.idArr[i] = self.list[i].id;
							
					}
					// this.statistics();
					console.log(111,self.idArr)
				}
			})
		},
		//修改数量
		setnum() {
			let self = this;
			let url = '/api/shop_car/carnum?id='+ id;
			self.httpGet(url, function (res) {
				if (res.code == 1) {
					
				}
			})
		},
		 //删除
		onDel(id){
			let self = this;
			this.$dialog.confirm({
				title: '是否删除？',
				mes: '',
				opts: () => {
					let url = '/api/shop_car/delete?id='+id;
					self.httpGet(url,  function (res) {
						if (res.code == 1) {
							self.shop_car()
							self.$dialog.toast({mes:res.msg});
						}else{
							self.$dialog.toast({mes:res.msg});
						}
					})
				}
			});
		},
		//确认订单   
		notarize: function() {
			let self = this;
			if(localStorage.getItem('list') == null){
				self.$dialog.toast({ 
					mes: '请选择要结算的商品！',
					timeout: 1500
				});
				return
			}
			
			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')
			let start_shop = localStorage.getItem('ids')
			let destination_ = localStorage.getItem('destination_')
			let hbnumber = localStorage.getItem('hbnumber')
			let hbtime = localStorage.getItem('hbtime')

			let jichangname = localStorage.getItem('start_shop')
			let endchangname = localStorage.getItem('end_shop')
			let url = "/api/shop_car/carpay?cid=" + this.idArr;
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
							self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" +endchangname +"&hb_val=" +hbnumber +"&ids=" +start_shop +"&eid="+destination_);
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
				}else if(res.data.code == 203){
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
					});
				}else if (res.data.code == 204){ 
					setTimeout(function () {
							//要延时执行的代码
							self.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" +jichangname +"&endchangname=" +endchangname +"&hb_val=" +hbnumber +"&ids=" +start_shop +"&eid="+destination_);
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
		this.shop_car()
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
.list .bar .center{
	width:100%;
	height:1.9rem;
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
	align-items: center;
}
.list .bar .center .xx .step1 span{
	font-size: .27rem;
}
.list .bar .center .xx .step1 .del{
	width:.48rem;
	height:.48rem;
	overflow: hidden;
}
.list .bar .center .xx .step1 .del img{
	width:100%;
	height:100%;
}
.list .bar .center .xx .step2{
	margin-top: .2rem;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.list .bar .center .xx .step2 span{
	font-size: .25rem;
}
.list .bar .center .xx .step2 .price{
	color: #ff7800;
}
.list .bar .center .xx .step2 .nums{
	display: flex;
	align-items: center;
}
.list .bar .center .xx .step2 .nums{
	display: flex;
  align-items: center;
}
.list .bar .center .xx .step2 .nums > div {
	width: .45rem;
	height: .45rem;
	text-align: center;
	line-height: .42rem;
}
.list .bar .center .xx .step2 .nums div:nth-child(1) {
	border-radius: 100%;
	border: 1px solid #ff7200;
}
.list .bar .center .xx .step2 .nums div:nth-child(3) {
	background: #ff7200;
	color: #fff;
	border-radius: 100%;
}
.list .bar .bt{
	width:100%;
	height:.9rem;
	display: flex;
	justify-content: flex-end;
	padding: 0 .2rem;
	align-items: center;
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
.shopfooter {
	width: 100%;
	height: 1rem;
	display: flex;
	justify-content: space-between;
	position: fixed;
	bottom: 0;
	background: #fff;
	padding-left: 5%;
	z-index: 99;
	box-shadow: darkgrey 1px 16px 20px 3px ;
  }

  .shopfotleft {
    width: 65%;
    display: flex;
    justify-content: space-between;
  }

  .leftleft {
    display: flex;
    align-items: center;
    white-space: nowrap;
  }

  .shopfothj {
    /* line-height: 1rem; */
    font-size: 0.25rem;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
  }

  .shopfothj span {
    color: #ff7200;
  }

  .shopfotright {
    width: 30%;
    text-align: center;
    line-height: 1rem;
    /* background: #e63f3f; */
    color: #fff;
    font-size: 0.3rem;
		background:-webkit-linear-gradient(left,#ff7200,#fb9e53);
		background:-o-linear-gradient(right,#ff7200,#fb9e53);
		background:-moz-linear-gradient(right,#ff7200,#fb9e53);
		background:linear-gradient(to right,#ff7200,#fb9e53);
  }

  .shoprigti {
    font-size: 0.24rem;
    color: #666;
    width: 100%;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
  }
  .diesx{
    overflow: hidden;
  }
  .diesx>div{
    float: left;
    text-overflow: ellipsis;
    width: 86%;
    white-space: nowrap;
    overflow: hidden;
  }
  .diesx span{
    float: right;
  }
  .diesx span img{
    width: 20px;
  }


  .nums {
    display: flex;
    align-items: center;

  }

  .nums > div {
    width: .45rem;
    height: .45rem;
    text-align: center;
    line-height: .42rem;
  }

  .nums div:nth-child(1) {
    border-radius: 100%;
    border: 1px solid #eb6767;
  }

  .nums div:nth-child(3) {
    background: #eb6767;
    color: #fff;
    border-radius: 100%;
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
	.hight-l {
  height: 1rem;
}
</style>

