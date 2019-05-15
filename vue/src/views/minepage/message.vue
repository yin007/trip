<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>消息详情</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="time">
			<span>{{details.createtime*1000 | date}}</span>
		</div>
		<div class="xx">
			<div class="pic">
				<img src="../../assets/images/minepage/xx.png">
			</div>
			<div class="kuang"> 
				<span>
					{{details.content}}
				</span>
				<div class="triangle_border_left">
						<span></span>
				</div>
			</div>
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
			id:"",
			details:"",
			time:"",
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
		detail: function(id) {
      let self = this;
      let url = "/api/other/detail";
      self.httpPost(url,{id:id},function(res) {
        if (res.code == 1) {
					self.details = res.data;
					// self.time = res.data.createtime;
					self.time = Date(parseInt(res.data.createtime) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
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
		this.id = this.$route.query.id;
		this.detail(this.id)
	}
}
</script>


<style scoped>
.homepage{
	background: #f2f2f2;
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
.time{
	width:100%;
	display: flex;
	justify-content: center;
	padding: .30rem 0;
}
.time span{
	color:#999;
}
.xx{
	width:100%;
	display: flex;
	/* align-items: center; */
	padding: 0 .30rem;
}
.xx .pic{
	width:.55rem;
	height:.55rem;
	overflow: hidden;
}
.xx .pic img{
	width:100%;
	height:100%;
}
.kuang{
	width:4.36rem;
	/* height:1.65rem; */
	padding: .30rem .30rem;
	background: #FFF;
	margin-left: .3rem;
	border-radius: 5px;
	position:relative;
}
/*向左*/
.triangle_border_left{
	width:0;
	height:0;
	border-width:.2rem .2rem .2rem 0;
	border-style:solid;
	border-color:transparent #fff transparent transparent;/*透明 灰 透明 透明 */
  position: absolute;
	left: -.12rem;
	top:.2rem;
}
</style>
