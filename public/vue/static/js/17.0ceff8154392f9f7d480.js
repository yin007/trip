webpackJsonp([17],{"2K/z":function(s,t){},U2YN:function(s,t,i){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var a=i("fxnj"),e=i.n(a),c=i("PJh5"),n=i.n(c);i("Vz2w");n.a.locale("zh-cn");var o={name:"order_form",data:function(){return{show:1,idx:0,keyong:[],not:[],checkbox1:"",sunm:0,yhj_index:100,shous:!1,buy_num:1,logoimage:"",title:"",price:"",depositprice:"",shopname:"",name:"",address:"",shop_phone:"",yhj_price:0,yhj_id:"",eid:"",order_num:"",curYUJ:0,zong:"",site:"",note:{backgroundImage:"url("+i("JVrM")+")",backgroundRepeat:"no-repeat",backgroundSize:"100% 1.75rem"},notes:{backgroundImage:"url("+i("z85b")+")",backgroundRepeat:"no-repeat",backgroundSize:"100% 1.75rem"},press:[]}},filters:{date:function(s){return n()(s).format("YYYY-M-D H:mm")},formatDate:function(s){return n()(s).format("Do")}},methods:{back:function(){this.$router.go(-1)},vanishs:function(s){this.shous=!1,s&&(this.curYUJ=this.yhj_price)},Oclicks:function(){this.shous=!0},ChangeMenu:function(s){this.yhj_index=s,this.yhj_price=this.press[this.yhj_index].price,this.yhj_id=this.press[this.yhj_index].id,console.log(1111,this.yhj_price,this.yhj_id)},yhj_Oclicks:function(){this.show=1;for(var s=0;s<this.press.length;s++)this.zong>this.press[s].price&&this.keyong.push(this.press[s].price);this.not.length=0,console.log(9999,this.keyong,this.zong)},yhj_vanishs:function(){this.show=0;for(var s=0;s<this.press.length;s++)this.zong<this.press[s].price&&this.not.push(this.press[s].price);this.keyong.length=0,console.log(8888,this.not)},discounts:function(){var s=this;s.httpGet("/api/coupon/index?type=0",function(t){1==t.code?(s.press=t.data,s.yhj_Oclicks(),s.press.length>0&&(s.curYUJ=s.press[0].price)):s.$dialog.toast({mes:t.msg,timeout:1500,icon:"error"})})},getaddress:function(s){var t=this,i="/api/order/orderconfirm?order_sn="+this.order_num;t.httpGet(i,function(s){1==s.code?t.site=s.data:t.$dialog.toast({mes:s.msg,timeout:1500,icon:"error"})})},myOrderClick:function(){this.$router.push("myOrder")},pay:function(s,t){var i=this,a="/api/wechat_pay/wxpayjs?order_sn="+this.order_num+"&coupon_record_id="+this.yhj_id;i.httpGet(a,function(s){1==s.code?(e.a.config({debug:!1,appId:s.data.appId,timestamp:s.data.timestamp,nonceStr:s.data.nonceStr,signature:"0391d095c8903f6202993ceef28e593978684bc5",jsApiList:["chooseWXPay"]}),e.a.chooseWXPay({timestamp:s.data.timeStamp,nonceStr:s.data.nonceStr,package:s.data.package,signType:s.data.signType,paySign:s.data.paySign,success:function(s){i.myOrderClick()}})):i.$dialog.toast({mes:s.msg,timeout:1500,icon:"error"})})}},created:function(){this.discounts(),this.buy_num=this.$route.query.buy_num,this.logoimage=this.$route.query.logoimage,this.title=this.$route.query.title,this.price=this.$route.query.price,this.depositprice=this.$route.query.depositprice,this.zong=this.price*this.buy_num,this.eid=this.$route.query.eid,this.order_num=this.$route.query.order_num,this.shopname=localStorage.getItem("shopname"),this.name=localStorage.getItem("name"),this.address=localStorage.getItem("address"),this.shop_phone=localStorage.getItem("shop_phone"),this.getaddress(this.order_num)}},r={render:function(){var s=this,t=s.$createElement,a=s._self._c||t;return a("div",{staticClass:"homepage"},[a("div",{staticClass:"top_tab"},[a("div",{staticClass:"left",on:{click:s.back}},[a("img",{staticClass:"xzs",attrs:{src:i("ohgX")}})]),s._v(" "),a("span",[s._v("确认订单")]),s._v(" "),a("div",{staticClass:"right"})]),s._v(" "),a("div",{staticClass:"hight-r"}),s._v(" "),a("div",{staticClass:"site"},[s._m(0),s._v(" "),a("div",{staticClass:"xx"},[a("div",{staticClass:"top"},[a("span",{staticClass:"name"},[s._v(s._s(s.site.start_shop_name))]),s._v(" "),a("a",{staticClass:"ph",attrs:{href:"tel:"+s.site.phone}},[a("span",{staticClass:"phone"},[s._v(s._s(s.site.phone))]),s._v(" "),a("img",{attrs:{src:i("eovu")}})])]),s._v(" "),a("div",{staticClass:"location"},[a("span",[s._v(s._s(s.site.address))])])])]),s._v(" "),s._m(1),s._v(" "),a("div",{staticClass:"site"},[s._m(2),s._v(" "),a("div",{staticClass:"xx"},[a("div",{staticClass:"top"},[a("span",{staticClass:"name"},[s._v(s._s(s.site.destination_shop_name))]),s._v(" "),a("a",{staticClass:"ph",attrs:{href:"tel:"+s.site.destination_shop_phone}},[a("span",{staticClass:"phone"},[s._v(s._s(s.site.destination_shop_phone))]),s._v(" "),a("img",{attrs:{src:i("eovu")}})])]),s._v(" "),a("div",{staticClass:"location"},[a("span",[s._v(s._s(s.site.destination_shop_address))])])])]),s._v(" "),a("div",{staticClass:"info"},[a("div",{staticClass:"hbh"},[a("img",{attrs:{src:i("1agC")}}),s._v(" "),a("span",[s._v("航班号："+s._s(s.site.hbnumber))])]),s._v(" "),a("div",{staticClass:"time"},[a("img",{staticClass:"fly",attrs:{src:i("VLJz")}}),s._v(" "),a("span",[s._v("起飞时间："+s._s(s.site.hbtime))])])]),s._v(" "),a("div",{staticClass:"fg"}),s._v(" "),a("div",{staticClass:"pro"},[a("div",{staticClass:"cp"},[a("div",{staticClass:"pic"},[a("img",{attrs:{src:s.logoimage}})]),s._v(" "),a("div",{staticClass:"rf"},[a("div",{staticClass:"title"},[a("span",[s._v(s._s(s.title))]),s._v(" "),a("span",[s._v("X"+s._s(s.buy_num))])]),s._v(" "),a("div",{staticClass:"price"},[a("span",[s._v("￥"+s._s(s.price))])])])]),s._v(" "),a("div",{staticClass:"discounts"},[a("span",[s._v("优惠券")]),s._v(" "),a("div",{staticClass:"rf_"},[s.yhj_price>0?a("span",[s._v("优惠"),a("span",{staticClass:"org"},[s._v(" "+s._s(s.yhj_price)+" ")]),s._v("元")]):s._e(),s._v(" "),a("img",{attrs:{src:i("tbrI")},on:{click:function(t){return s.Oclicks()}}})])]),s._v(" "),a("div",{staticClass:"bar"},[a("span",[s._v("商品租金")]),s._v(" "),a("span",{staticClass:"org"},[s._v("+￥"+s._s(s.price*s.buy_num))])]),s._v(" "),a("div",{staticClass:"bar"},[a("span",[s._v("押金")]),s._v(" "),a("span",{staticClass:"org"},[s._v("+￥"+s._s(s.depositprice*s.buy_num))])]),s._v(" "),a("div",{staticClass:"bar"},[a("span",[s._v("优惠")]),s._v(" "),a("span",{staticClass:"org"},[s._v("-￥"+s._s(s.yhj_price))])])]),s._v(" "),a("div",{staticClass:"btn"},[a("div",{staticClass:"sum"},[a("span",[s._v("合计："),a("span",{staticClass:"org"},[s._v("￥"+s._s(s.price*s.buy_num+s.depositprice*s.buy_num-s.yhj_price))])])]),s._v(" "),a("div",{staticClass:"qr",on:{click:function(t){return s.pay()}}},[a("span",[s._v("确认订单")])])]),s._v(" "),a("div",{staticClass:"hight-l"}),s._v(" "),s.shous?a("div",{staticClass:"mebs"},[a("div",{staticClass:"boxts"},[a("div",{staticClass:"title"},[a("div",{staticClass:"lf"}),s._v(" "),a("span",[s._v("优惠券")]),s._v(" "),a("div",{staticClass:"rf",on:{click:function(t){return s.vanishs(0)}}},[a("img",{attrs:{src:i("KTlb")}})])]),s._v(" "),a("ul",{staticClass:"ts"},[a("li",{class:1==s.show?"acti":"",on:{click:function(t){return s.yhj_Oclicks()}}},[a("span",[s._v("可用优惠券")])]),s._v(" "),a("li",{class:0==s.show?"acti":"",on:{click:function(t){return s.yhj_vanishs()}}},[a("span",[s._v("不可用优惠券")])])]),s._v(" "),1==s.show?a("div",{staticClass:"list"},[s._l(s.press,function(t,i){return a("div",{key:t.id},[s.zong>t.price?a("div",{staticClass:"bar"},[a("div",{staticClass:"lf"},[a("div",{staticClass:"pic",style:s.note},[a("span",{staticClass:"fh"},[s._v("￥"+s._s(t.price))])])]),s._v(" "),a("div",{staticClass:"xx"},[a("span",{staticClass:"txt"},[s._v(s._s(t.title))]),s._v(" "),a("span",{staticClass:"time"},[s._v(s._s(s._f("date")(1e3*t.createtime))+"-"+s._s(s._f("date")(1e3*t.abletime)))])]),s._v(" "),a("div",{staticClass:"xz",class:s.yhj_index==i?"actives":"",on:{click:function(t){return s.ChangeMenu(i)}}})]):s._e()])}),s._v(" "),0==s.keyong.length?a("div",{staticClass:"qs"},[s._m(3),s._v(" "),a("span",[s._v("暂无可用优惠券~")])]):s._e()],2):s._e(),s._v(" "),0==s.show?a("div",{staticClass:"lists"},[s._l(s.press,function(t,i){return a("div",{key:t.id},[s.zong<t.price?a("div",{staticClass:"bar"},[a("div",{staticClass:"lf"},[a("div",{staticClass:"pic",style:s.notes},[a("span",{staticClass:"fh"},[s._v("￥"+s._s(t.price))])])]),s._v(" "),a("div",{staticClass:"xx"},[a("span",{staticClass:"txt"},[s._v(s._s(t.title))]),s._v(" "),a("span",{staticClass:"time"},[s._v(s._s(s._f("date")(1e3*t.createtime))+"-"+s._s(s._f("date")(1e3*t.abletime)))])])]):s._e()])}),s._v(" "),0==s.not.length?a("div",{staticClass:"qs"},[s._m(4),s._v(" "),a("span",[s._v("暂无可用优惠券~")])]):s._e()],2):s._e(),s._v(" "),a("div",{staticClass:"qd",on:{click:function(t){return s.vanishs(1)}}},[a("span",[s._v("确定")])])])]):s._e()])},staticRenderFns:[function(){var s=this.$createElement,t=this._self._c||s;return t("div",{staticClass:"pic"},[t("img",{attrs:{src:i("3Fpk")}})])},function(){var s=this.$createElement,t=this._self._c||s;return t("div",{staticClass:"xian"},[t("div",{staticClass:"s"})])},function(){var s=this.$createElement,t=this._self._c||s;return t("div",{staticClass:"pic"},[t("img",{attrs:{src:i("eXuT")}})])},function(){var s=this.$createElement,t=this._self._c||s;return t("div",{staticClass:"pic"},[t("img",{attrs:{src:i("WloO"),alt:""}})])},function(){var s=this.$createElement,t=this._self._c||s;return t("div",{staticClass:"pic"},[t("img",{attrs:{src:i("WloO"),alt:""}})])}]};var h=i("VU/8")(o,r,!1,function(s){i("2K/z")},"data-v-a70c9d3c",null);t.default=h.exports},z85b:function(s,t){s.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOAAAACvCAYAAADkI9JYAAAACXBIWXMAAAsTAAALEwEAmpwYAAAHamlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkMDc0ZTE5OS0yNTQwLTQyYzEtOGUwMS1iY2YzMWZiZTI0Y2EiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDo0MjdkYTNkOS05ZmIzLTdkNDYtODg4My0zN2I2NDMxMGE4YzUiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M2FiYWU2OTctYTRhMS0wMzQ4LWIxYWUtYTVkOTcwZmI3ZWViIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChNYWNpbnRvc2gpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxOS0wNC0wOFQxNDowMDo0NCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTktMDUtMDlUMTQ6NDk6MzcrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTktMDUtMDlUMTQ6NDk6MzcrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpjYWRhYTY3Yy01OWE2LTQwNWQtYWQzMC1kY2MyNzdiNWM2ZTYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ZDA3NGUxOTktMjU0MC00MmMxLThlMDEtYmNmMzFmYmUyNGNhIi8+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjZkNzllZDZiLTllY2EtMjM0Ny04NmYzLTJhNGZmYzYwOWI5ZCIgc3RFdnQ6d2hlbj0iMjAxOS0wNC0xMVQxMToxMDowNyswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDozYWJhZTY5Ny1hNGExLTAzNDgtYjFhZS1hNWQ5NzBmYjdlZWIiIHN0RXZ0OndoZW49IjIwMTktMDUtMDlUMTQ6NDk6MzcrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPHBob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPHJkZjpCYWc+IDxyZGY6bGk+eG1wLmRpZDowRjNGODcwRDVDMUQxMUU5ODM1QzhBMThDQzgxMzIwMjwvcmRmOmxpPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOkRvY3VtZW50QW5jZXN0b3JzPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PncANggAAATtSURBVHic7d2/i2XlHcfxzwYRq5RBZJUnskU6fxwiYikJQRCLEEj6EMRCRBRS5T+IhUgIKVKKJFhEsFBWLVKEsMwhTaol6AMuVlZWVmoxgyyLs/Pc8Tz3e8l9vWCaud87nObLmZl73jxXTk5Ovg4wS0/yRZL3lmX5/Z0v3rP3y4HjcTPJH5Zl+ft5AxYQ5vhvkkeWZfnqbkM/2NPFwDH5OMlPL1q+xALCDP9cluXLkUELCNt7f3TQAsL2HhodtICwvZ+PDlpA2N61dV2fGBm0gLC9luS1kUELCHNcXdf1bxcNWUCYoyV5Yl3XD9d1vXbe0BXPgsJ0Pcm/k7y5LMu7t7/gUTSYr519PZnEAsKe9ZzdAe98wQLCPD2nz4W+sCzLze8asIAwR09yY1mWX99tyH9BYY5bFy1fYgFhhp7klZFBCwjbu7Usy42RQQsI23tndNACwvb+NzpoAWF7944OWkDYXhsdtICwPUEuFBLkQqEWQS6UEuRCoRZBLhyEHkEulGkR5EKZHkEu7F2PIBdK9AhyoYwgF4r0CHKhjCAXCglyoZAgFwoJcqFQGx20gLA9QS4UEuRCoRZBLpQS5EKhFkEuHIQeQS6UaRHkQpkeQS7sXY8gF0r0CHKhjCAXivQIcqGMIBcKCXKhkCAXCglyoVAbHbSAsD1BLhQS5EKhFkEulBLkQqEWQS4chB5BLpRpEeRCmR5BLuxdjyAXSvQIcqGMIBeK9AhyoYwgFwrtFOTeOvsCtjEc5N6T5MEk9yV5IMnjSZ5J8vTZa1dnXB38n9s5yP0yp59XvJ3kt0l+nOT1s+8Bu2mjg3f7G/CPSR5L8kH8igq72CzI/eLsh70dSwijNg9yX07yj1hCGNEyIch9Mf4mhFFTgtzfxV0QRrQMBLm7LuDNJP/6PlcFR6Tl9CO96+u6vrWu67N3DlzmSZi/xF0QdtGS/CbJG3e+cJkF/Oj7Xg1w6rI94OfxlAyM6tm4iP8syaOXvx44Cj2KeCjRM7GIv/+S74NjMbWI/9El3wfHoGdiEf/0Jd4Dx2RqEf98/AcU7mbaEdU/SfLUju+BYzPtiOo/x90PLjLliOo/JTn3oVLgW210cHQBX0/yXNz9YMRmRfwPk1xP8stYPhi1SRH/apL/JPlZLB/souUSRfxDSX6V5K9JPknyUpKHt74yOBJDRfyVk5OTT29/08QLgmPTc/ow9vPLsnznRxOOqIb5ehxRDWVazjmi2uEsUMgdEObrcUY87F2PIh5K9DgjHso4Ix6K9DgjHso4Ix4KTSvigYtNK+KBi00p4oExbXTQAsL2Nivigd1tfkY8MK5lwhnxwLgpZ8QDY1oGzohXxMN8PYp4KNOiiIfD4w4I8/Uo4mHvehTxUKJHEQ9lFPFQpEcRD2UU8VBIEQ+FFPFQSBEPhdrooAWE7SnioZAiHgq1KOKhlCIeCrUo4uEg9CjioUyLIh4OjzsgzNejiIe961HEQ4keRTyUUcRDkR5FPJRRxEMhRTwUUsRDIUU8FGqjgxYQtqeIh0KKeCjUooiHUop4KNSiiIeD0KOIhzIting4PO6AMF+PIh72rkcRDyV6FPFQRhEPRXoU8VBGEQ+FFPFQSBEPhRTxUKiNDlpA2J4iHgop4qFQiyIeSinioVCLIh4OQo8iHsq0KOLh8LgDwnw9ingo84vzivhvACeFl9E4P071AAAAAElFTkSuQmCC"}});
//# sourceMappingURL=17.0ceff8154392f9f7d480.js.map