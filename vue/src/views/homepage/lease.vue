<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="homeClick">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>可租赁</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<ul class="tabs">
			<li @click="lease" :class="index == 0?'actives':''">
				<span>全部</span>
			</li>
			<li @click="ChangeMenu(item.id)" :class="index == item.id?'actives':''" v-for="item in classif" :key="item.id"> 
				<span>{{item.name}}</span>
			</li>
		</ul>
		<div class="list">
			<div v-for="item in list" :key="item.id" class="bar">
				<div class="lf" @click="detailsClick(item.id)">
					<div class="pic">
						<img :src="item.logoimage">
					</div>
					<div class="pro">
						<div class="title">
							<span>{{item.title}}</span>
						</div>
						<div class="price">
							<span class="num">￥{{item.price}}</span>
							<span>/次</span>
						</div>
					</div>
				</div>
				<div class="rf">
					<img class="add" src="../../assets/images/homepage/add.png" @click="AddCar(item.id)">
				</div>
			</div>
		</div>
		<!-- 购物车 -->
		<div class="car" @click="shop_carClick">
			<img src="../../assets/images/homepage/car.png" alt="">
			<div class="sp">
				<span>{{total}}</span>
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
  name: 'lease',
  data () {
    return {
			id:'',
			index:0,
			list:[],
			car:[],
			classif:[],
			total:0,
			hb_val:'',//航班号
    }
  },
  methods: {
// 		back: function() {
// 			this.$router.go(-1);
//     },
		homeClick: function() {
			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')  
			let jichangname = localStorage.getItem('start_shop')
			let endchangname = localStorage.getItem('end_shop')
			let ids = localStorage.getItem('ids') 
			let eid = localStorage.getItem('destination_')
      this.$router.push("/?cityd=" + cityd +"&endcity=" + endcity +"&jichangname=" + jichangname +"&endchangname=" +endchangname +"&ids=" +ids +"&eid=" +eid +"&hb_val=" + this.hb_val);
		},
		detailsClick: function() {
      this.$router.push("details");
		},
		shop_carClick: function() {
      this.$router.push("/shop_car");
		},
		//产品详情
		detailsClick: function(id) {
      this.$router.push("details?id="+ id +"&hb_val=" +this.hb_val); 
		},
		//全部
		lease: function(id) {
			let self = this;
			let types ='';
			this.ChangeMenu(types)
      let url = "/api/index/zu?shop_id=" +this.id +"&type=" +types ;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.list = res.data;
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		// 设备分类 
		classify: function() {
			let self = this;
			let url = "/api/equipment/category"; 
			self.httpGet(url, function(res) {
				if (res.code == 1) {
					self.classif = res.data
				} else {
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
						icon: "error"
					});
				}
			});
		},
		// 分类列表
		ChangeMenu: function(index) {
      this.index = index;
			let self = this;
			let type = index;
			let url = "/api/index/zu?shop_id=" +this.id +"&type=" +type;
			self.httpGet(url,function(res) {
				if (res.code == 1) {
					self.list = res.data;
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
		AddCar: function(id) {
			let self = this;

			let cityd = localStorage.getItem('start_city')
			let endcity = localStorage.getItem('endcity')
			let start_shop = localStorage.getItem('ids')
			let destination_ = localStorage.getItem('destination_')
			let hbnumber = localStorage.getItem('hbnumber')
			let hbtime = localStorage.getItem('hbtime')

			let url = "/api/shop_car/index?shopid=" + this.id 
																							+ "&eid=" + id 
																							+"&num="+1
																							+"&start_city=" + cityd  //出发地城市
																							+"&destination_city=" + endcity //目的地地城市
																							+"&start_shop=" + start_shop //出发地城市id
																							+"&destination_shop=" + destination_ //目的地城市id
																							+"&hbnumber=" + hbnumber //航班号
																							+"&hbtime=" + hbtime; //出发时间
			// self.total=0
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.shop_car()
				} else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		// 购物车列表  
		shop_car: function(flag) {
			let self = this;
			let url = "/api/shop_car/car"; 
			self.httpGet(url, function(res) {
				if (res.code == 1) {
					self.car = res.data
						let sum  = 0;
						for(var i =0;i<self.car.length;i++){
							sum=sum+self.car[i].num;
							self.total= sum;
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
  },
  created() {
		this.shop_car();
		this.id= this.$route.query.id;
		this.lease();
		this.classify();
		//航班号
		this.hb_val = this.$route.query.hb_val; 
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
	font-size: 0;
  overflow-x: scroll; 
	white-space: nowrap;
}
.tabs::-webkit-scrollbar {display:none}
.tabs li{
	height:100%;
	padding: 0 .28rem;
	text-align: center;
	line-height: .8rem;
	display: inline-block;
	margin-left: .2rem;
}
.tabs li:first-child{
	margin-left: 0;
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
	height:2.20rem;
	box-shadow: 0 1px 5px  rgba(0,0,0,.1);
	border-radius: 3px;
	background: #FFF;
	padding: 0 .30rem;
	display: flex;
	/* justify-content: space-between; */
	align-items: center;
	margin-bottom: .2rem;
	position: relative;
}
.list .bar:last-child{ 
	margin-bottom: 0;
}
.list .bar .lf{
	width:93%;
	height:100%;
	display: flex;
	align-items: center;
}
.list .bar .lf .pic{
	width:2.5rem;
	height:1.8rem;
	overflow: hidden;
}
.list .bar .lf .pic img{
	width:100%;
	height:100%;
}
.list .bar .lf .pro{
	width:57%;
	margin-left: .2rem;
}
.list .bar .lf .pro .title span{
	font-size: .28rem;
}
.list .bar .lf .pro .price{
	margin-top: .1rem;
}
.list .bar .lf .pro .price .num{
	font-size: .25rem;
	color: #eb6100;
}
.list .bar .rf{
	width:7%;
	height:100%;
	position: absolute;
	right: .3rem;
	display: flex;
	justify-content: flex-end;
	align-items: center;
	z-index: 9999;
}
.list .bar .rf .add{
	width:.46rem;
	height:.48rem;
}
 /* .add{
	width:.46rem;
	height:.48rem;
	display: flex;
	align-items: center;
	position: absolute;
	right: .3rem;
  top: 20%;
  transform: translate(-50%,-50%);
  
}
.add{
	width:.46rem;
	height:.48rem;
} */
.car{
	width:1.08rem;
	height:1.08rem;
	background: #4bacff;
	border-radius: 50%;
	position: fixed;
	right: .3rem;
	bottom:11%;
	/* opacity: .75; */
	display: flex;
	justify-content: center;
	align-items: center;
	z-index: 9999999;
}
.car img{
	width:.53rem;
	height:.50rem;
	position: relative;
}
.car .sp{
	position: absolute;
	width:.4rem;
	height:.4rem;
	background: red;
	z-index: 9999999999;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	right:.1rem;
	top:.2rem;
}
.car .sp span{
	color:#FFF;
	font-size: .15rem;
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

