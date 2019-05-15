<template>
  <div class="homepage">
    <!-- 顶部导航 -->
    <div class="top_tab">
      <div class="left" @click="back">
        <img class="xzs" src="../../assets/images/commn/back.png">
      </div>
      <span>选择城市</span>
      <div class="right">
      </div>
    </div>
     <!-- 空DIV -->
    <div class="hight-r"></div>
    <!-- 当前定位城市 -->
    <div class="zm">
      <span>当前定位</span>
    </div>
    <div class="rm_list">
			<div class="bar" @click="homeClick(start_city)">
        <span>{{start_city}}</span>
      </div>
    </div>
    <!-- 热门城市 -->
		<div class="zm">
      <span>热门城市</span>
    </div>
    <div class="rm_list">
      <div class="bar" v-for="item in re_list" :key="item.index" @click="homeClick(item)">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- A -->
    <div class="zm">
      <span>A</span>
    </div>
    <div class="rm_list">
      <div  class="bar" v-for="item in cityA" :key="item.index" @click="homeClick(item)">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- B -->
    <div class="zm">
      <span>B</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityB" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- C -->
    <div class="zm">
      <span>C</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityC" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- D -->
    <div class="zm">
      <span>D</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityD" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- E -->
    <div class="zm">
      <span>E</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityE" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- F -->
    <div class="zm">
      <span>F</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityF" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- G -->
    <div class="zm">
      <span>G</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityG" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- H -->
    <div class="zm">
      <span>H</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityH" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- J -->
    <div class="zm">
      <span>J</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityJ" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- K -->
    <div class="zm">
      <span>K</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityK" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- L -->
    <div class="zm">
      <span>L</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityL" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- M -->
    <div class="zm">
      <span>M</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityM" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- N -->
    <div class="zm">
      <span>N</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityN" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- Q -->
    <div class="zm">
      <span>Q</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityQ" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- S -->
    <div class="zm">
      <span>S</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityS" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- T -->
    <div class="zm">
      <span>T</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityT" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- W -->
    <div class="zm">
      <span>W</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityW" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- X -->
    <div class="zm">
      <span>X</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityX" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- Y -->
    <div class="zm">
      <span>Y</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityY" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- Z -->
    <div class="zm">
      <span>Z</span>
    </div>
    <div class="rm_list">
      <div @click="homeClick(item)"  class="bar" v-for="item in cityZ" :key="item.index">
        <span>{{item}}</span>
      </div>
    </div>
    <!-- 右侧字母 -->
    <div class="spell">
      <div v-for="item in spell"> 
        <span>{{item}}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'index',
  data () {
    return {
      hb_val:'',
      ids:'',
      jichangname:'',
      // endchangname:'',
      cityd:'',
      start_city:'',
      spell:['#','热','A','B',,'C','D','E','F','G','H','J','K','L','M','N','Q','S','T','W','X','Y','Z'],
      re_list:[
        '北京','上海','深圳','武汉',
      ],
      cityA:[
        '安庆'
      ],
      cityB:[
        '北京','保亭','保定','北海','宝鸡'
      ],
      cityC:[
        '成都','重庆','长沙','澄迈','承德','滁州','长春','常德','常州'
      ],
      cityD:[
        '大连','东莞','定安','大理','德阳','达州','丹东'
      ],
      cityE:[
        '鄂州'
      ],
      cityF:[
        '佛山','福州'
      ],
      cityG:[
        '广州','贵阳','桂林','赣州'
      ],
      cityH:[
        '杭州','惠州','海口','合肥','衡水','黄冈','邯郸','呼和浩特','淮安','黄石','哈尔滨','湖州','汉中'
      ],
      cityJ:[
        '济南','嘉兴','晋中','江门','金华','吉林','吉安','九江'
      ],
      cityK:[
        '昆明','开封','昆山'
      ],
      cityL:[
        '临沂','陵水','廊坊','临高','乐东','龙岩','乐山','洛阳','兰州','柳州','凉山'
      ],
      cityM:[
        '眉山','绵阳','马鞍山'
      ],
      cityN:[
        '南京','南通','南充','南昌','宁波','南宁'
      ],
      cityQ:[
        '青岛','琼海','琼中','泉州','清远','秦皇岛'
      ],
      cityS:[
        '上海','深圳','苏州','石家庄','沈阳','三亚','绍兴','上饶'
      ],
      cityT:[
        '天津','唐山','太原','台州'
      ],
      cityW:[
        '武汉','温州','廊坊','无锡','文昌','万宁','五指山','威海','芜湖'
      ],
      cityX:[
        '厦门','西安','滁州','西双版纳','咸宁','邢台','咸阳','新乡','襄阳','许昌'
      ],
      cityY:[
        '烟台','银川','宜昌','盐城','岳阳'
      ],
      cityZ:[
        '中山','珠海','郑州','镇江','张家口','漳州','株洲','湛江','淄博'
      ],
    }
  },
  methods: {
		back: function() {
			this.$router.go(-1);
    },
		homeClick: function(city) {
      let cityd = localStorage.getItem('start_city') 
      let jichangname = localStorage.getItem('start_shop')
      let ids = localStorage.getItem('ids') 
     
      this.$router.push("/?endcity=" +city +  "&cityd"+ cityd +"&jichangname=" + jichangname +"&ids=" +ids  +"&hb_val=" + this.hb_val);
    },
		
  },
  created() {
     //航班号
    this.hb_val = this.$route.query.hb_val;
    //出发地门店id
    this.ids = localStorage.getItem("ids");
    //出发地门店
    this.jichangname = localStorage.getItem('start_shop')
    
    //出发地城市
    this.cityd = localStorage.getItem('start_city')

    let that = this;

		const geolocation = new BMap.Geolocation();
		geolocation.getCurrentPosition(function getinfo(position){
				that.start_city = position.address.city;   
				that.start_city = that.start_city.substring(0,that.start_city.length-1);
				that.destination_city = that.start_city;
				let province = position.address.province;    //获取省份信息
		}, function(e) {
				that.start_city = "定位失败"
		}, {provider: 'baidu'});

	}
}
</script>


<style scoped>
.homepage{
	background: #f2f2f2;
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
.zm{
  width:100%;
  padding: .15rem .3rem;
}
.zm span{
  color:#999;
}
.rm_list{
  width: 100%;
  background: #FFF;
  border-top:1px solid #eee;
  border-bottom:1px solid #eee;
  padding: 0 .3rem;
}
.rm_list .bar{
  width:100%;
  height:.9rem;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #eee;
}
.rm_list .bar:last-child{
  border-bottom: none;
}
.rm_list .bar span{
  color: #666;
  font-size: .27rem;
}
.spell{
  position: fixed;
  right:.3rem;
  top:2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.spell div span{
  color:#666;
}
</style>

