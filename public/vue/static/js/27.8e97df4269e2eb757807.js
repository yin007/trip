webpackJsonp([27],{j9gd:function(t,i,s){"use strict";Object.defineProperty(i,"__esModule",{value:!0});var n={name:"index",data:function(){return{hb_val:"",ids:"",jichangname:"",cityd:"",start_city:"",spell:["#","热","A","B",,"C","D","E","F","G","H","J","K","L","M","N","Q","S","T","W","X","Y","Z"],re_list:["北京","上海","深圳","武汉"],cityA:["安庆"],cityB:["北京","保亭","保定","北海","宝鸡"],cityC:["成都","重庆","长沙","澄迈","承德","滁州","长春","常德","常州"],cityD:["大连","东莞","定安","大理","德阳","达州","丹东"],cityE:["鄂州"],cityF:["佛山","福州"],cityG:["广州","贵阳","桂林","赣州"],cityH:["杭州","惠州","海口","合肥","衡水","黄冈","邯郸","呼和浩特","淮安","黄石","哈尔滨","湖州","汉中"],cityJ:["济南","嘉兴","晋中","江门","金华","吉林","吉安","九江"],cityK:["昆明","开封","昆山"],cityL:["临沂","陵水","廊坊","临高","乐东","龙岩","乐山","洛阳","兰州","柳州","凉山"],cityM:["眉山","绵阳","马鞍山"],cityN:["南京","南通","南充","南昌","宁波","南宁"],cityQ:["青岛","琼海","琼中","泉州","清远","秦皇岛"],cityS:["上海","深圳","苏州","石家庄","沈阳","三亚","绍兴","上饶"],cityT:["天津","唐山","太原","台州"],cityW:["武汉","温州","廊坊","无锡","文昌","万宁","五指山","威海","芜湖"],cityX:["厦门","西安","滁州","西双版纳","咸宁","邢台","咸阳","新乡","襄阳","许昌"],cityY:["烟台","银川","宜昌","盐城","岳阳"],cityZ:["中山","珠海","郑州","镇江","张家口","漳州","株洲","湛江","淄博"]}},methods:{back:function(){this.$router.go(-1)},homeClick:function(t){localStorage.getItem("start_city");var i=localStorage.getItem("start_shop"),s=localStorage.getItem("ids");this.$router.push("/?endcity="+t+"&cityd="+this.cityd+"&jichangname="+i+"&ids="+s)}},created:function(){this.hb_val=this.$route.query.hb_val,this.ids=localStorage.getItem("ids"),this.jichangname=localStorage.getItem("start_shop"),this.cityd=localStorage.getItem("start_city");var t=this;(new BMap.Geolocation).getCurrentPosition(function(i){t.start_city=i.address.city,t.start_city=t.start_city.substring(0,t.start_city.length-1),t.destination_city=t.start_city;i.address.province},function(i){t.start_city="定位失败"},{provider:"baidu"})}},c={render:function(){var t=this,i=t.$createElement,n=t._self._c||i;return n("div",{staticClass:"homepage"},[n("div",{staticClass:"top_tab"},[n("div",{staticClass:"left",on:{click:t.back}},[n("img",{staticClass:"xzs",attrs:{src:s("ohgX")}})]),t._v(" "),n("span",[t._v("选择城市")]),t._v(" "),n("div",{staticClass:"right"})]),t._v(" "),n("div",{staticClass:"hight-r"}),t._v(" "),t._m(0),t._v(" "),n("div",{staticClass:"rm_list"},[n("div",{staticClass:"bar",on:{click:function(i){return t.homeClick(t.start_city)}}},[n("span",[t._v(t._s(t.start_city))])])]),t._v(" "),t._m(1),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.re_list,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(2),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityA,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(3),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityB,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(4),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityC,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(5),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityD,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(6),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityE,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(7),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityF,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(8),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityG,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(9),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityH,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(10),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityJ,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(11),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityK,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(12),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityL,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(13),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityM,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(14),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityN,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(15),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityQ,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(16),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityS,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(17),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityT,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(18),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityW,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(19),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityX,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(20),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityY,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),t._m(21),t._v(" "),n("div",{staticClass:"rm_list"},t._l(t.cityZ,function(i){return n("div",{key:i.index,staticClass:"bar",on:{click:function(s){return t.homeClick(i)}}},[n("span",[t._v(t._s(i))])])}),0),t._v(" "),n("div",{staticClass:"spell"},t._l(t.spell,function(i){return n("div",[n("span",[t._v(t._s(i))])])}),0)])},staticRenderFns:[function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("当前定位")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("热门城市")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("A")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("B")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("C")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("D")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("E")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("F")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("G")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("H")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("J")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("K")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("L")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("M")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("N")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("Q")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("S")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("T")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("W")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("X")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("Y")])])},function(){var t=this.$createElement,i=this._self._c||t;return i("div",{staticClass:"zm"},[i("span",[this._v("Z")])])}]};var a=s("VU/8")(n,c,!1,function(t){s("zQE5")},"data-v-1feb9213",null);i.default=a.exports},zQE5:function(t,i){}});
//# sourceMappingURL=27.8e97df4269e2eb757807.js.map