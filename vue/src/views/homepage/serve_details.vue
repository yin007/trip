<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>门店详情</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="box">
			<div class="step1">
				<span class="name">{{info.shopname}}-{{info.name}}</span>
				<span class="time">06:00-24:00恭候您的光临</span>
			</div>
			<div class="step2">
				<img src="../../assets/images/homepage/dw.png">
				<span>{{info.address}}</span>
			</div>
			<div class="step3">
				<img src="../../assets/images/homepage/phone.png">
				<span>{{info.phone}}</span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  name: 'serve',
  data () {
    return {
			id:"",
			info:"",
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		serve_detail: function(id) {
			let self = this;
			let url = "/api/shop/index?shop_id=" + this.id;
			// debugger
      self.httpGet(url,function(res) {
        if (res.code == 1) {
					self.info = res.data
					localStorage.setItem("shopname", res.data.shopname);
					localStorage.setItem("name", res.data.name);
					localStorage.setItem("address", res.data.address);
					localStorage.setItem("shop_phone", res.data.phone);
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
		this.serve_detail(this.id);
	}
}
</script>


<style scoped>
.lease{
	background: #FFF;
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
.box{
	width:100%;
	padding: 0 .30rem;
}
.box .step1,.box .step2,.box .step3{
	width:100%;
	padding: .30rem 0;
	border-bottom: 1px solid #f2f2f2;
}
.box .step1{
	display: flex;
	flex-direction: column;
	padding: .30rem .1rem;
}
.box .step1 .name{
	font-size: .30rem;
}
.box .step1 .time{
	font-size: .26rem;
	color: #666;
}
.box .step2,.box .step3{
	display: flex;
	align-items: center;
}
.box .step2 img{
	width:.35rem;
	height:.44rem;
}
.box .step2 span{
	color: #999;
	font-size: .28rem;
	margin-left: .1rem;
}
.box .step3 img{
	width:.45rem;
	height:.45rem;
}
.box .step3 span{
	color: #999;
	font-size: .28rem;
	margin-left: .1rem;
}
</style>

