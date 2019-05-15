<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>我的消息</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="list">
			<router-link :to='"/message?id="+item.id' v-for="item in list" :key="item.id" class="bar">
				<div class="pic">
					<img src="../../assets/images/minepage/xx.png">
				</div>
				<div class="rf">
					<div class="title">
						<span>{{item.title}}</span>
					</div>
					<div class="time">
						<span>{{item.createtime*1000 |date}}</span>
						<span class="state" v-if="item.status==1">已读</span>
						<span class="state" v-if="item.status==0">未读</span>
					</div>
				</div>
			</router-link>
		</div>
  </div>
</template>

<script>
import moment from 'moment';
import 'moment/locale/zh-cn'
moment.locale('zh-cn')
export default {
  name: 'index',
  data () {
    return {
			list:[]
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
		messageClick: function() {
      this.$router.push("/message");
		},
		getnews: function() {
			let self = this;
			let url = "/api/other/message"; 
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
          self.list = res.data
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
		this.getnews()
	}
}
</script>


<style scoped>
.homepage{
	background: #fff;
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
.list{
	width:100%;
	padding: 0 .30rem;
	display: flex;
	flex-direction: column;
	box-shadow: 0 1px 5px  rgba(0,0,0,.1);
}
.list .bar{
	width:100%;
	padding: .30rem 0;
	border-bottom: 1px solid #f2f2f2;
	display: flex;
	align-items: center;
}
.list .bar .pic{
	width:.55rem;
	height:.55rem;
	overflow: hidden;
}
.list .bar .pic img{
	width:100%;
	height:100%;
}
.list .bar .rf{
	display: flex;
	flex-direction: column;
	margin-left: .1rem;
}
.list .bar .rf .title span{
	font-size: .28rem;
}
.list .bar .rf .time{
	margin-top: .05rem;
}
.list .bar .rf .time span{
	color:#999;
}
.list .bar .rf .time .state{
	margin-left: .2rem;
}
</style>
