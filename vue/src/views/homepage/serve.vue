<template>
  <div class="lease"> 
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>门店</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div> 
		<!-- <div class="top">
			<div class="seach">
				<input type="text" placeholder="输入机场名寻找附近门店">
				<div class="pic">
					<img src="../../assets/images/homepage/seach.png" alt="">
				</div>
			</div>
		</div> -->
		<div class="list">
			<!-- <div v-for="item in list" :key="item.id"> -->
				<div  v-for="item in list" :key="item.id" class="bar" @click="homeClick(item.name,item.id)">
					<div class="dw">
						<img class="xzs" src="../../assets/images/homepage/dws.png">
					</div>
					<div class="rf">
						<div class="titie">
							<span>{{item.jichangname}}-{{item.name}}</span>
							<router-link :to='"/serve_details?id="+item.id' class="dian">
								<img src="../../assets/images/homepage/dian.png" alt="">
							</router-link>
						</div>
						<div class="dz">
							<span>{{item.address}}</span>
						</div>
					</div>
				</div>
			<!-- </div> -->
		</div>
		<div class="qs" v-if="list.length==0">
			<div class="pic">
				<img src="../../assets/images/commn/qs.png" alt="">
			</div>
			<span>该地区暂无门店~</span> 
		</div>
	</div>
</template>

<script>
export default {
  name: 'serve',
  data () {
    return {
			city:'',
			eid:'',
			endcity:'',
			cityd:'',
			index:0,
			endchangname:'', 
			list:[]
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1); 
    },
		// router-link :to='"/?jichangname="+item.name +"&ids="+item.id +"&endchangname=" +endchangname +"&cityd="+cityd +"&endcity="+ endcity + "&eid=" +eid'
		homeClick: function(shop,id) {
      let endcity = localStorage.getItem('endcity') 
      let endchangname = localStorage.getItem('end_shop')
      let ids = localStorage.getItem('ids') 
      let eid = localStorage.getItem('destination_')
      this.$router.push("/?jichangname=" + shop +"&ids=" + id  +"&endchangname=" +endchangname +"&cityd=" + this.city +"&endcity=" +endcity + "&hb_val=" + this.hb_val);
    },
		address: function(city) {
      let self = this;
      let url = "/api/index/address?city=" +this.city;
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.list = res.data
        } else {
         
        }
      });
		},
  },
  created() {
		//航班号
		this.hb_val = this.$route.query.hb_val;
		//目的地门店id
		this.eid = localStorage.getItem("destination_"); 
		//目的地城市
		this.endcity = localStorage.getItem('endcity')
		//出发城市
		this.city = this.$route.query.city;
		//目的地门店
		this.endchangname = localStorage.getItem('end_shop')
		this.address()
	}
}
</script>


<style scoped>
.list{
	width:100%;
	padding: 0 .30rem;
	margin-top: .2rem;
}
.list .bar{
	width:100%;
	padding: .10rem 0;
	display: flex;
	align-items: center;
	border-bottom:1px solid #f2f2f2;
}
.list .bar .dw{
	width:.35rem;
	height:.44rem;
	overflow: hidden;
}
.list .bar .dw img{
	width:100%;
	height:100%;
}
.list .bar .rf{
	width:94%;
	height:100%;
	margin-left: .2rem;
}
.list .bar .rf .titie{
	width:100%;
	height:30%;
	display: flex;
	align-items: center;
	justify-content: space-between;  
}
.list .bar .rf .titie span{
	font-size: .28rem;
}
.list .bar .rf .titie .dian{
	width:.40rem;
	height:100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.list .bar .rf .titie .dian img{
	width:.39rem;
	height:.16rem;
}
.list .bar .rf .dz{
	width:100%;
	padding: .2rem 0 0 0;
}
.list .bar .rf .dz span{
	color:#999;
	font-size: .27rem;
}
.lease{
	background: #FFF;
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
	z-index: 9999;
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
/* .top{
	width:100%;
	padding: 0 .30rem;
	display: flex;
	justify-content: center;
}
.top .seach{
	width:100%;
	height:.8rem;
	background: #eee;
	border-radius: 5px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 0 .20rem;
}
.top .seach input{
	width:90%;
	height:100%;
	border:none;
}
.top .seach .pic{
	width:.40rem;
	height:100%;
	overflow: hidden;
	display: flex;
	align-items: center;

}
.top .seach .pic img{
	width:.40rem;
	height:.43rem;
} */
</style>

