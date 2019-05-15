<template>
  <div class="homepage">
		<!-- 轮播图 -->
		 <div class="box">
     <yd-slider autoplay="3000" pagination-activecolor="#1868b3">
				<yd-slider-item v-for="(item,index) in banner" :key="index">
					<img :src="item">
				</yd-slider-item>
      </yd-slider>
    </div>
		<!-- 信息填写 --> 
		<div class="info">
			<div class="bar">
				<div class="lf">	
					<div class="city" @click="cityClick()">	
						<img class="dw" src="../../assets/images/homepage/dw.png">
						<span>{{start_city}}</span>
						<img class="xz" src="../../assets/images/commn/nexts.png">
					</div>
					<div class="shop" @click="startClick()">	
						<span :class="start!= '请选择当地服务点'?'actives':'ts'">{{start}}</span>
					</div>
				</div>
				<div class="cate">
					<span>出发地</span>
				</div>
			</div>
			<div class="bar">
				<div class="lf">
					<div class="city" @click="end_cityClick()">	
						<img class="dw" src="../../assets/images/homepage/dw.png">
						<span>{{destination_city}}</span>
						<img class="xz" src="../../assets/images/commn/nexts.png">
					</div>
					<div class="shop" @click="destinationClick()">
						<span  :class="end != '请选择当地服务点'?'actives':'ts'">{{end}}</span>
					</div>
				</div>
				<div class="cate">
					<span>目的地</span>
				</div>
			</div>
			<div class="bar" id="bars">
				<div class="lf">
					<span class="hbh">航&nbsp;班&nbsp;号</span>
					<div class="shop" @click="Oclicks(1)">
						<img class="xz" src="../../assets/images/commn/nexts.png">
						<input type="text" placeholder="请选择或输入航班号" v-model="hb_val"  @input="Oclicks(0)" >
					</div>
				</div>
				<img class="fly" src="../../assets/images/homepage/fly.png">
				<!-- 航班下拉 -->
				<ul class="flight" v-if="shous">
					<li @click="vanishs(hbidx)" v-for="(item , hbidx) in hb" :key="item.id">
						<span>{{item.hbnumber}}</span>
					</li>	
				</ul>
			</div>
			<yd-cell-group>
				<yd-cell-item arrow>
					<span slot="left">起飞时间&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<yd-datetime  v-model="hbtime" slot="right" :callback="timeof"></yd-datetime>
				</yd-cell-item>
			</yd-cell-group>
			<div class="btn" @click="lease()">
				<span>立即租赁</span>
			</div>
			<div class="gg">
				<img class="xzs" src="../../assets/images/homepage/gonggao.png">
				<div class="gonggao"><span>公告：</span></div>
				<yd-rollnotice autoplay="2000">
					<yd-rollnotice-item  v-for="item in notice" :key="item.id">{{item.title}}</yd-rollnotice-item>
				</yd-rollnotice>
			</div>
		</div>
		<!-- 为您推荐 -->
		<div class="recommend">
			<div class="title">
				<div class="lf"></div>
				<span class="tj">为您推荐</span>
				<div class="rf"></div>
			</div>
			<div class="product">
				<div v-for="item in recommend" :key="item.id" class="pro" @click="detailsClick(item.id)">
					<div class="pic">
						<img :src="item.logoimage">
					</div>
					<div class="txt">
						<div class="title"><span>{{item.title}}</span></div>
						<div class="num">
							<div class="jg">
								<span class="org">￥{{item.price}}元</span>
								<span>/次</span>
							</div>
							<div class="ku">
								<span>库存<span class="org">&nbsp;{{item.stock}}&nbsp;</span>件</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tuijian">
				<!-- router-link :to='"/lease"' -->
				<div class="sd" @click="lease()">
					<span>更多</span>
					<img src="../../assets/images/commn/gengduo.png" alt="">
				</div>
			</div>
		</div>
    <!-- 空DIV 底部 -->
    <div class="hight-l"></div> 
    <!-- 底部导航 -->
		<div class="d_tab">
			<div class="lf">
				<div>
					<img src="../../assets/images/homepage/home.png" alt="">
					<span>首页</span>
				</div>
			</div>
			<div class="rf">
				<div @click="mineClick()">
					<img src="../../assets/images/homepage/mine-h.png" alt="">
					<span>我的</span>
				</div>
			</div>
		</div>
  </div>
</template>

<script>
import BMap from 'BMap'
export default {
  name: 'index',
  data () {
    return {
			hb_val:'请选择或输入航班号',//航班号
			shous: false,
			start_shop:'',
			id:'',
			start:'请选择当地服务点',//出发城市服务点
			end:'请选择当地服务点',//目的地城市服务点 
			hbnumber:'',
			name:'',
			banner:[],
			recommend:[],
			notice:[],
			start_city:'',//出发地城市
			destination_city:'',//目的地城市
			start_shop_id:'',//出发地门店id
			destination_:'',//目的地门店ID
			hbtime: '',//出发时间
			time:'',
			hb:[],//航班号
    }
	},
  methods: {
		//航班号 航班弹窗消失
		vanishs: function(idx) {
			// debugger
			this.shous = false;
			this.hb_val=this.hb[idx].hbnumber;
			// 航班号存入缓存
			localStorage.setItem("hbnumber", this.hb_val);  
		},
		//航班弹窗出现  
		Oclicks: function(flag) {
			this.shous = flag;
			this.hb_val= this.hb_val;
		},
		//出发地城市
		cityClick: function() {
      this.$router.push("city?hb_val=" +this.hb_val); 
		},
		//目的地城市
		end_cityClick: function() {
      this.$router.push("end_city?hb_val=" +this.hb_val); 
		},
		//出发时间  缓存
		timeof:function(){
			localStorage.setItem("hbtime", this.hbtime);
		},
		//个人中心
		mineClick: function() {
      this.$router.push("mine?hb_val=" +this.hb_val +"&hbtime=" +this.hbtime); 
		},
		//产品分类
		detailsClick: function(id) {
      this.$router.push("details?id="+ id +"&hb_val=" +this.hb_val); 
		},
		//产品分类
		leaseClick: function(id) {
      this.$router.push("lease?id="+this.id +"&hb_val=" +this.hb_val); 
		},
		// 出发地门店选择
		startClick:function(start_city) {
      this.$router.push("serve?city=" +this.start_city +"&hb_val=" +this.hb_val);
		},
		// 目的地门店选择
		destinationClick:function(destination_city) {
			let self = this;
			if(this.start_city==this.destination_city){
				self.$dialog.toast({
					mes: '出发地城市与目的地城市不能相同！',
					timeout: 1500
        });
        return
			}
      this.$router.push("destination_serve?city=" +this.destination_city +"&hb_val=" +this.hb_val);
		},
		// 首页信息
		homepage: function(start_city) {
			// debugger
			let self = this;
			let url = "/api/index/index?city=" + start_city;			
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
					self.banner = res.data.banner;
					self.recommend = res.data.equipment;
					self.notice = res.data.announcement
				} else {
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
						icon: "error"
					});
				}
			});
		},
		//航班号
		hbclick: function(start_city,destination_city) {
			let self = this;
			let url = "/api/index/hb?start_city="+ start_city + "&destination_city="+ destination_city; 
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
					self.hb = res.data;
				} else {
					self.$dialog.toast({
						mes: res.msg,
						timeout: 1500,
						icon: "error"
					});
				}
			});
		},
		//地点 
		address: function() {
      let self = this;
      let url = "/api/index/address?city=" +this.city;
      self.httpGet(url,function(res) {
        if (res.code == 1) {	
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
		},
		//立即租赁 
		lease() {
			let self = this;
      if(this.start=='请选择当地服务点'){
        self.$dialog.toast({
					mes: '请选择出发地服务点',
					timeout: 1500
        });
        return
			}
			if(this.end=='请选择当地服务点'){
        self.$dialog.toast({
					mes: '请选择目的地服务点',
					timeout: 1500
        });
        return
			}
      if(this.hb_val==''){
        self.$dialog.toast({
					mes: '请选择航班号',
					timeout: 1500
				});
        return
      }
			if(this.hbtime==''){
        self.$dialog.toast({
					mes: '请输入出发时间',
					timeout: 1500
				});
        return
			}
			// localStorage.setItem("start_city", this.start_city);
			// localStorage.setItem("destination_city", this.destination_city);
			// localStorage.setItem("start_shops", this.id);
			// localStorage.setItem("destination_", this.destination_);
			// localStorage.setItem("hbnumber", this.hbnumber);
			// localStorage.setItem("hbtime", this.hbtime);
      this.leaseClick()
		},
		pds(){
			if(this.start==undefined || this.start=='undefined'){
				this.start='请选择当地服务点'
			}
			if(this.end==undefined || this.end=='undefined'){
				this.end='请选择当地服务点'
			}
			if(this.hb_val==undefined || this.hb_val=='undefined' || this.hb_val==null){
				this.hb_val=''
			}
		},
		// 获取当前时间 
		 CurentTime()
    { 
			let now = new Date();
			let year = now.getFullYear();       
			let month = now.getMonth() + 1;     
			let day = now.getDate();            
			let hh = now.getHours();            
			let mm = now.getMinutes();        
			let ss = now.getSeconds();           
			this.time = year + "-";
			if(month < 10)
					this.time += "0";
			this.time += month + "-";
			if(day < 10)
					this.time += "0";
			this.time += day + " "; 
			if(hh < 10)
				this.time += "0";
			this.time += hh + ":";
			if (mm < 10) this.time += '0'; 
			this.time += mm; 
			this.hbtime = this.time;
		}
  },
  created() {
		

		//航班号
		this.hb_val = this.$route.query.hb_val;

		//出发城市的门店
		this.start = this.$route.query.jichangname;
		localStorage.setItem("start_shop", this.start); 

		//出发门店的id
		this.id = this.$route.query.ids; 
		localStorage.setItem("ids", this.id); 
		
		//目的地城市的门店
		this.end = this.$route.query.endchangname;
		localStorage.setItem("end_shop", this.end);

		//目的地门店的id
		this.destination_ = this.$route.query.eid;
		localStorage.setItem("destination_", this.destination_);

		//出发时间
		this.hbtime = this.$route.query.hbtime

		let that = this; 
		
		//从路由传参中接收出发城市
		that.start_city = that.$route.query.cityd; 
		//将出发城市存入缓存
		localStorage.setItem("start_city", that.start_city);

		//从路由传参中接收目的地城市
		that.destination_city = that.$route.query.endcity; 
		//将目的地城市存入缓存
		localStorage.setItem("endcity", that.destination_city);
		
		//获取当前城市
		let cur_city ='';
		const geolocation = new BMap.Geolocation();
		geolocation.getCurrentPosition(function getinfo(position){
				cur_city = position.address.city;   
				//去掉后缀市
				cur_city = cur_city.substring(0,cur_city.length-1);

				//判断当前出发城市是否为undefined
				if(that.start_city == undefined || that.start_city == 'undefined'){
					that.start_city = cur_city;
					//将出发城市存入缓存
					localStorage.setItem("start_city", that.start_city);
				}

			 	//判断当前目的地城市是否为undefined
				if(that.destination_city == undefined || that.destination_city == 'undefined'){
					that.destination_city = cur_city;
					//将目的地城市存入缓存
					localStorage.setItem("endcity", that.destination_city);
				}

				//将出发城市与目的地城市传入航班号接口获取相应航班
				that.hbclick(that.start_city,that.destination_city);

				//将出发城市传入首页数据接口，按照出发地城市随机推荐当前出发地城市店面的产品，根据切换不同出发地城市更新推荐产品
				that.homepage(that.start_city);

		}, function(e) {
				that.start_city = "定位失败"
		}, {provider: 'baidu'});
	
		//判断出发店目的地店初始值函数
		that.pds();

		// 当前时间
		that.CurentTime();
	}
	
}
</script>


<style scoped>
.homepage{
	background: #f2f2f2;
}
/* 航班号下拉框 */
#bars{
	position: relative;
}
#bars .flight{
	width:100%;
	background: #fff;
	padding: 0 .3rem;
	display: flex;
	flex-direction: column;
	justify-content: flex-end;
	position: absolute;
	top: .8rem;
	left: 0;
	z-index: 9999999;
	border-bottom-left-radius: 5px;
	border-bottom-right-radius: 5px;
	box-shadow: .01rem .01rem .06rem #ddd;
}
#bars .flight li{
	width:100%;
	height:.7rem;
	display: flex;
	justify-content: center;
	align-items: center;
}
#bars .flight li span{
	font-size: .25rem;
	color: #333;
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
	z-index: 99999999999999;
}
.top_tab span {
  color: #000;
  font-size: .30rem;
	font-weight: bold;
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
	color: #3ba5ff
}
.d_tab .rf div span{
	color: #666
}
/* 顶部空 */
.hight-r {
  height: 1rem;
}
/* 轮播图盒子 */
.box{
	width:100%;
}
/* 航班信息 */
.info{
	width:95%;
	height:6.8rem;
	background: #FFF;
	margin: 0 auto;
	border-radius: 5px;
	position:relative;
	z-index:99;
	margin-top:-.9rem;
	padding: 0 .3rem;
	overflow: hidden;
}
.info .bar{
	width:100%;
	height:.8rem;
	border-bottom: 1px solid #eee;
	margin-top: .3rem;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.info .bar .lf{
	display: flex;
	align-items: center;
	height:100%;
}
.info .bar .lf .hbh{
	font-size: .28rem;
}
.info .bar .lf .city{
	display: flex;
	align-items: center;
	height:100%;
}
.info .bar .lf .city .dw{
	width:.35rem;
	height:.44rem;
}
.info .bar .lf .city span{
	font-size: .28rem;
	margin-left: .1rem;
}
.info .bar .lf  .shop{
	display: flex;
	align-items: center;
	height:100%;
}
.info .bar .lf  .city .xz{
	width:.24rem;
	height:.13rem;
	margin-left: .2rem;
	margin-top: .03rem;
}
.info .bar .lf .shop .xz{
	width:.24rem;
	height:.13rem;
	margin-left: .2rem;
	margin-top: .03rem;
}
.info .bar .lf .shop input{
	height:100%;
	border:none;
	margin-left: .2rem;
	font-size: .28rem;
}
.info .bar .lf  .shop .ts{
	font-size: .28rem;
	color:#CCC;
	margin-left: .2rem;
}
.info .bar .lf  .shop .actives{
	font-size: .28rem;
	color: #000;
	margin-left: .2rem;
}
.info .bar .cate{
	width:1rem;
	height:.40rem;
	display: flex;
	justify-content: center;
	align-items: center;
	background: #3ba5ff;
	border-radius: 10px;
	margin-right: 0;
}
.info .bar .cate span{
	color: #FFF;
	font-size: .22rem;
}
.info .bar .fly{
	width:.35rem;
	height:.20rem;
}
/* 立即租赁 */
.info .btn{
	width:95%;
	height:.80rem;
	background: #3ba5ff;
	margin: 0 auto;
	border-radius: 5px;
	display: flex;
	justify-content: center;
	align-items: center;
	margin-top: .6rem;
}
.info .btn span{
	font-size: .30rem;
	color:#FFF;
}
/* 公告 */
.info .gg{
	display: flex;
	align-items: center;
	margin-top: .20rem;
}
.info .gg .gonggao{
	margin-left: .3rem;
	width:1rem;
}
.info .gg img{
	width:.43rem;
	height:.40rem;
}
/* 推荐 */
.recommend{
	width:100%;
	background: #FFF;
	padding: .38rem .30rem;
	margin-top: .2rem;
}
.recommend .title{
	width:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.recommend .title .tj{
	font-size: .34rem;
	margin-left: .2rem;
	margin-right: .2rem;
}
.recommend .title .lf {
	width: 1.2rem;
	height:1px;
	background: #CCC;
}
.recommend .title .rf {
	width: 1.2rem;
	height:1px;
	background: #CCC;
}
.recommend .product{
	width:100%;
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
	padding: .38rem 0 0 0;
}
.recommend .product .pro{
	width:49%;
	background: #f2f2f2;
	height:4rem;
	margin-bottom: .16rem;
	display: flex;
	flex-direction: column;
	overflow: hidden;
}
.recommend .product .pro .pic{
	width:100%;
	height:3rem;
	overflow: hidden;
}
.recommend .product .pro .pic img{
	width:100%;
	height:100%;
}
.recommend .product .pro .txt{
	width:100%;
	height:1rem;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: space-between;
	padding: .15rem .2rem;
}
.recommend .product .pro .txt .title{
	width:100%;
	text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
	display: flex;
	justify-content: flex-start;
	align-items: center;
}
.recommend .product .pro .txt .title span{
	font-size: .28rem;
}
.recommend .product .pro .txt .num{
	width:100%;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.recommend .product .pro .txt .num span{
	font-size: .25rem;
}
.recommend .product .pro .txt .num .org{
	color:#ff7800;
}
/* .recommend .product .pro .txt div:nth-child(1){
	width:100%;
	text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
	display: flex;
	align-items: center;
}
.recommend .product .pro .txt div:nth-child(1) span{
	font-size: .28rem;
}
.recommend .product .pro .txt div:nth-child(2) span{
	font-size: .25rem;
}
.recommend .product .pro .txt div:nth-child(2){
	width:100%;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.recommend .product .pro .txt div:nth-child(2) .jg{
	display: flex;
}
.recommend .product .pro .txt div:nth-child(2) .jg .price{
	color:#ff7800;
}
.recommend .product .pro .txt div:nth-child(2) .ku{
	display: flex;
	justify-content: flex-end;
}
.recommend .product .pro .txt div:nth-child(2) .ku .org{
	color:#ff7800;
}
.recommend .product .pro .txt div:nth-child(2) .ku .num{
	display: flex;
} */
.recommend .product .pro:nth-child(2n){
	margin-bottom: 0;
}
.recommend .tuijian{
	width:100%;
	padding: .2rem 0;
	display: flex;
	justify-content: center;
}
.recommend .tuijian .sd{
	display: flex;
	align-items: center;
}
.recommend .tuijian .sd span{
	color: #37a3ff;
}
.recommend .tuijian .sd img{
	width:.40rem;
	height:.40rem;
	margin-left: .1rem;
}
.hight-l {
  height: 1rem;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
	font-size: .28rem;
	color:#CCC;
} 
input:-moz-placeholder, textarea:-moz-placeholder { 
	font-size: .28rem;
	color:#CCC; 
} 
input::-moz-placeholder, textarea::-moz-placeholder { 
	font-size: .28rem;
	color:#CCC;
} 
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	font-size: .28rem;
	color:#CCC;
} 
</style>
<style>
.yd-tab-nav .yd-tab-active:before {
  width: 30%;
  margin-left: -17%;
  background-color: #000;
}
.yd-tab-panel-item {
  padding: 10px 15px;
}
.yd-tabbar-txt{
  font-size:.20rem!important;
}
.yd-tabbar-icon img{
	width:.43rem!important;
	height:.43rem!important;
}
.yd-slider-pagination-item{
	margin-bottom:1.5rem;
}
.yd-slider-pagination-item-active {
  width: 6px !important;
	background: #37a3ff!important;
	margin-bottom:1.5rem;
}
.yd-tabbar-fixed{
	z-index:999!important;
}
.yd-cell-item{
	padding-left: 0!important;
	margin-top: .12rem!important;
	border-bottom: 1px solid #eee!important;
}
.yd-cell-right{
	padding-right: .1rem!important;
}
.yd-cell-left{
	color: #000!important;
}
.yd-cell-right .yd-datetime-input{
	font-size: .25rem;
	color:#CCC;
}
.yd-datetime-head>a:last-child{
	color:#37a3ff!important;
}
.yd-cell-right .yd-datetime-input{
	color:#000!important;
}
</style>
