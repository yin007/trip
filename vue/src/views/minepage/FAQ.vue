<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>常见问题</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV --> 
    <div class="hight-r"></div>
     <div v-for="item in list" :key="item.id">
      <div class="box">
        <div class="boxt">
          <div class="title">
            <span>{{item.title}}</span>
          </div>
          <div class="solve">
            <span>
              {{item.content}}
            </span>
          </div>
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
			list:[]
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
    getFAQ: function() {
			let self = this;
			let url = "/api/other/wenti"; 
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
		this.getFAQ()
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
  border-bottom:1px solid #f2f2f2;
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
  margin-top: .2rem;
}
.box .boxt{
  width:100%;
  box-shadow:  0 1px 5px rgba(219,219,218,.9);
  background: #FFF;
  border-radius: 3px;
}
.box .boxt .title{
	width:100%;
	height:.8rem;
	border-bottom: 1px solid #f2f2f2;
	display: flex;
	align-items: center;
  padding: 0 .20rem;
}
.box .boxt .solve{
  width:100%;
  padding: .30rem .20rem;
}
</style>
