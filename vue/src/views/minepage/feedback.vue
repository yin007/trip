<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>意见反馈</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="box">
     <textarea name="" placeholder="您有什么意见或者建议，快来告诉我吧！" id="" cols="30" rows="10" v-model="content"></textarea>
		 <div class="qd" @click="feedback()">
				<span>确定</span>
			</div>
		</div>
  </div>
</template>

<script>
// import Vue from 'vue';
// import { Confirm, Alert, Toast, Notify, Loading } from 'vue-ydui/dist/lib.rem/dialog';
// Vue.prototype.$dialog = {
//     confirm: Confirm,
//     alert: Alert,
//     toast: Toast,
//     notify: Notify,
//     loading: Loading,
// };
export default {
  name: 'index',
  data () {
    return {
			content:'',
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		feedback: function() {
      let self = this;
			if(self.content==''){
        self.$dialog.toast({
          mes: '意见不能为空',
          timeout:2000,
        });
        return
			}
			// if(self.content==''){
      //   self.$dialog.notify({
      //     mes: '意见不能为空',
      //     timeout:2000,
      //   });
      //   return
      // }
			let url = "/api/other/content?content="+this.content; 
			self.httpPost(url,{}, function(res) {
				if (res.code == 1) {
					setTimeout(function () {
							//要延时执行的代码
							self.$router.push("/mine");
						}, 1500) //延迟时间
          self.$dialog.toast({ 
						mes: '提交成功！',
						icon: "success",
						timeout: 1500
					});
				} 
			});
    }
  },
  created() {
		
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
  /* box-shadow: .01rem .01rem .06rem #ddd; */
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
	display: flex;
	flex-direction: column;
}
.box textarea{
	width:100%;
  box-shadow:  0 1px 5px rgba(219,219,218,.9);
	height:4rem;
	padding: .2rem .2rem;
	border:none;
	margin-top: .1rem;
	border-radius: 3px;
}
.box .qd{
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
.box .qd span{
	color:#FFF;
	font-size: .30rem;
}
</style>
