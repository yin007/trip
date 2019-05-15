<template>
  <div class="lease">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>实名认证</span>
      <div class="right"> 
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
    <div class="box" v-if="statu.id_card==null">
      <div class="step2">
				<!-- <span>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：</span> -->
        <input type="text" placeholder="请输入姓名" v-model="rel_name">
      </div>
      <div class="step2">
				<!-- <span>身份证号：</span> -->
        <input type="number" placeholder="请输入身份证号码" v-model="id_card">
      </div>
      <div class="tj" @click="rz()">
        <span>提交</span>
      </div>
		</div>
		<!-- 已认证状态 -->
		<div class="cad" v-if="statu.id_card!=null">
			<div class="note" :style ="note">
				<div class="sta">
          <span class="ts">您已实名认证</span>
        </div>
        <span class="name">{{(statu.rel_name[0] || '').padEnd(statu.rel_name.length, '*')}}</span>
        <span class="card">{{statu.id_card}}</span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
  name: 'myOrder',
  data () {
    return {
			statu:'',
			rel_name:'',
			id_card:'',
			 note: {
				backgroundImage: "url(" + require("../../assets/images/minepage/bj.png") + ")",
				backgroundRepeat: "no-repeat",
				backgroundSize: "100% 3.65rem",
			},
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		rz: function() {
			let self = this;
			if(self.rel_name==''){
				self.$dialog.toast({ 
					mes: '请输入姓名',
					timeout:2000,
				});
				return
			}
			if(self.id_card==''){
				self.$dialog.toast({
					mes: '请输入身份证号',
					timeout:2000,
				});
				return
			}
			let reg = /^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(1[0-2]))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
			if(reg.exec(self.id_card)===null){
				self.$dialog.toast({
					mes: '身份证号输入有误', 
					timeout:2000,
				});
				return
			}
			let url = "/api/user/bindcard?rel_name="+self.rel_name + "&id_card=" +self.id_card ;
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          setTimeout(() => {
						setTimeout(function () {
							self.getstatus()
						}, 1500) 
            self.$dialog.toast({
              mes: '认证成功！',
              icon: "success",
              timeout: 1500
            });
          }, 1000);
        } else {
          self.$dialog.toast({
            mes: res.msg,
            icon: "error",
            timeout: 1500
          });
        }
      });
    },
		//认证状态 
    getstatus: function() {
      let self = this;
      let url = "/api/user/card";     
      self.httpGet(url, function(res) {
        if (res.code == 1) {
          self.statu = res.data;
        } else {
          self.$dialog.toast({
            mes: res.msg,
            timeout: 1500,
            icon: "error"
          });
        }
      });
    }
  },
  created() {
		this.getstatus()
	}
}
</script>


<style scoped>
.lease{
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
.cad{
	width:100%;
	padding: .3rem .5rem;
}
.cad .note {
	width:100%;
	height: 3.65rem;
	display: flex; 
	flex-direction: column;
	justify-content: center;
	align-items: center;
	padding: .30rem .30rem;
	box-sizing: border-box;
	border-radius: 8px;
}
.cad .note .sta{
	display: flex;
	align-items: center;
}
.cad .note .sta .ts{
	color: #FFF;
	font-size: .35rem;
	font-weight: bold;
}
.cad .note .name,
.cad .note .card{
	color: #FFF;
	font-size: .30rem;
	margin-top: .2rem;
}
.box{
 	width:100%;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  display: flex;
  flex-direction: column;
  padding: .74rem .89rem;
}
.box .step2{
  width:100%;
  height:.83rem;
  box-shadow: 0 1px 5px  rgba(0,0,0,.1);
  padding: 0 .2rem;
	display: flex;
	align-items: center;
	margin-top: .25rem;
}
.step2 span{
	font-size: .28rem;
}
.step2 input{
  width:70%;
  height:100%;
  border:none;
	font-size: .27rem;
}
.step2{
  margin-top: .25rem;
  position: relative;
}
.step2:first-child{
	margin-top: 0;
}
.step2 input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
	font-size: .27rem;
	color:#666;
} 
.step2 input:-moz-placeholder, textarea:-moz-placeholder { 
	font-size: .27rem;
	color:#666; 
} 
.step2 input::-moz-placeholder, textarea::-moz-placeholder { 
	font-size: .27rem;
	color:#666;
} 
.step2 input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	font-size: .27rem;
	color:#666;
} 
.tj{
  width:100%;
	height:.8rem;
	background:-webkit-linear-gradient(left,#61b5ff,#88c7fe);
	background:-o-linear-gradient(right,#61b5ff,#88c7fe);
	background:-moz-linear-gradient(right,#61b5ff,#88c7fe);
	background:linear-gradient(to right,#61b5ff,#88c7fe);
	margin-top: .8rem;
	border-radius: 3px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.tj span{
  color:#FFF;
	font-size: .30rem;
}
.menu{
	width:100%;
	display: flex;
	justify-content: space-between;
	margin-top: .1rem;
}
.menu span{
	color:#666;
	font-size: .24rem;
}
input::-webkit-input-placeholder, textarea::-webkit-input-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input:-moz-placeholder, textarea:-moz-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input::-moz-placeholder, textarea::-moz-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 
input:-ms-input-placeholder, textarea:-ms-input-placeholder { 
	color: #9e9e9e; 
	font-size: .25rem;
} 

</style>

