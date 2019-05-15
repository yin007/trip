<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>关于我们</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
		<div class="top">
			<div class="pic">
				<img :src="info.logoimage" alt="">
			</div>
		</div>
		<div class="box">
			<div class="name">
				<span>平台介绍</span>
			</div>
			<div class="txt">
				<span>
					{{info.content}}
				</span>
			</div>
			<div class="name">
				<span>联系我们</span>
			</div>
			<div class="ad"> 
				<span>地址：{{info.address}}</span>
				<span class="phone">电话：{{info.phone}}</span>
			</div>
		</div>
  </div>
</template>

<script>
export default {
  name: 'index',
  data () {
    return {
			info:''
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		about: function() {
			let self = this;
			let url = "/api/other/my"; 
			self.httpGet(url, function(res) {
				console.log(1111,res)
				if (res.code == 1) {
					self.info = res.data 
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
		this.about();
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
.top{
	width:100%;
	height:2.47rem;
	background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAD3CAIAAACrXFItAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkMDc0ZTE5OS0yNTQwLTQyYzEtOGUwMS1iY2YzMWZiZTI0Y2EiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjJGOEI4MEM1OUM2MTFFOTk1MkFGREZEQ0U0NzhDREIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjJGOEI4MEI1OUM2MTFFOTk1MkFGREZEQ0U0NzhDREIiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpjYWRhYTY3Yy01OWE2LTQwNWQtYWQzMC1kY2MyNzdiNWM2ZTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ZDA3NGUxOTktMjU0MC00MmMxLThlMDEtYmNmMzFmYmUyNGNh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);
	background-size: 100% 100%;
	display: flex;
	justify-content: center;
	align-items: center;
}
.top .pic{
	width:1.40rem;
	height:1.4rem;
	overflow: hidden;
	border-radius: 5px;
}
.top .pic img{
	width:100%;
	height:100%;
}
.box{
	width:100%;
	padding: 0 .30rem;;
	box-shadow:  0 1px 5px rgba(219,219,218,.9);
	display: flex;
	flex-direction: column;
}
.box .name{
	width:100%;
	display: flex;
	align-items: center;
	height:.8rem;
	border-bottom: 1px solid #f2f2f2;
}
.box .name span{
	font-size: .28rem;
}
.box .txt{
	width:100%;
	padding: .2rem 0 0 0;
}
.box .ad{
	width:100%;
	padding: .2rem 0;
	display: flex;
	flex-direction: column;
}
.box .ad .phone{
	margin-top: .1rem;
}
</style>
