webpackJsonp([14],{"4kXm":function(s,e){},JRJU:function(s,e){},"X+1U":function(s,e,t){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a={name:"myOrder",data:function(){return{oldpassword:"",newpassword:"",newpasswords:""}},methods:{back:function(){this.$router.go(-1)},amend_pad:function(){var s=this;if(""!=s.oldpassword)if(""!=s.newpassword)if(""!=s.newpasswords)if(s.newpassword==s.newpasswords){var e="/api/user/resetpwd?oldpassword="+s.oldpassword+"&newpassword="+s.newpassword;s.httpGet(e,function(e){1==e.code?(setTimeout(function(){s.$router.push("/login")},1500),s.$dialog.toast({mes:"修改成功！",icon:"success",timeout:1500})):s.$dialog.toast({mes:e.message,icon:"error",timeout:1500})})}else s.$dialog.toast({mes:"两次输入密码不一致，请确认！",icon:"error",timeout:1500});else s.$dialog.toast({mes:"请再次输入新登录密码",icon:"error",timeout:1500});else s.$dialog.toast({mes:"请输入新登录密码",icon:"error",timeout:1500});else s.$dialog.toast({mes:"请输入原登录密码",icon:"error",timeout:1500})}},created:function(){}},o={render:function(){var s=this,e=s.$createElement,a=s._self._c||e;return a("div",{staticClass:"lease"},[a("div",{staticClass:"top_tab"},[a("div",{staticClass:"left",on:{click:s.back}},[a("img",{staticClass:"xzs",attrs:{src:t("ohgX")}})]),s._v(" "),a("span",[s._v("修改密码")]),s._v(" "),a("div",{staticClass:"right"})]),s._v(" "),a("div",{staticClass:"hight-r"}),s._v(" "),a("div",{staticClass:"box"},[a("div",{staticClass:"step1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:s.oldpassword,expression:"oldpassword"}],attrs:{type:"password",placeholder:"请输入原登录密码"},domProps:{value:s.oldpassword},on:{input:function(e){e.target.composing||(s.oldpassword=e.target.value)}}})]),s._v(" "),a("div",{staticClass:"step1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:s.newpassword,expression:"newpassword"}],attrs:{type:"password",placeholder:"请输入新登录密码"},domProps:{value:s.newpassword},on:{input:function(e){e.target.composing||(s.newpassword=e.target.value)}}})]),s._v(" "),a("div",{staticClass:"step1"},[a("input",{directives:[{name:"model",rawName:"v-model",value:s.newpasswords,expression:"newpasswords"}],attrs:{type:"password",placeholder:"请再次输入新登录密码"},domProps:{value:s.newpasswords},on:{input:function(e){e.target.composing||(s.newpasswords=e.target.value)}}})]),s._v(" "),a("div",{staticClass:"tj",on:{click:s.amend_pad}},[a("span",[s._v("提交")])])])])},staticRenderFns:[]};var r=t("VU/8")(a,o,!1,function(s){t("4kXm"),t("JRJU")},"data-v-dba58304",null);e.default=r.exports}});
//# sourceMappingURL=14.16d3ba11a51d43c5bc5c.js.map