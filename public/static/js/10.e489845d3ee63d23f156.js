webpackJsonp([10],{"6kAl":function(a,t,e){"use strict";function o(a){e("dvNx")}Object.defineProperty(t,"__esModule",{value:!0});var s=e("/AfO"),r=e("1DHf"),n=e("rHil"),i=e("mtWM"),d=e.n(i),p=e("t5DY"),l=(s.a,r.a,n.a,{components:{XCircle:s.a,Cell:r.a,Group:n.a},data:function(){return{old_password:"",new_password:"",new_password2:""}},mounted:function(){},methods:{getData:function(){var a=new URLSearchParams,t=this;if(""===t.old_password)return void t.$vux.toast.text("请输入原始密码");if(""===t.new_password)return void t.$vux.toast.text("请输入新密码");if(""===t.new_password2)return void t.$vux.toast.text("请确认新密码");if(t.new_password!==t.new_password2)return void t.$vux.toast.text("两次密码不一致");var e="";e="shopeeker"===localStorage.getItem("userType")?"shopeeker/center/passwordReset":"buyer/center/passwordReset",a.append("old_password",t.old_password),a.append("new_password",t.new_password);var o=d.a.create({baseURL:p.a});o.defaults.headers.common.Authorization="Bearer "+localStorage.getItem("token"),o.post(e,a).then(function(a){200===a.data.code?(t.$vux.toast.text(a.data.message),console.log(a.data),setTimeout(function(){t.$router.push("/login?userType="+localStorage.getItem("userType"))},1500)):(console.log(a.data),t.$vux.toast.text(a.data.message))})}}}),u=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("div",{staticClass:"page"},[e("div",{staticClass:"form"},[e("div",[e("h2",{staticClass:"h"},[a._v("修改密码")]),a._v(" "),e("div",{staticClass:"inputRow"},[e("label",[a._v("原始密码")]),a._v(" "),e("input",{directives:[{name:"model",rawName:"v-model.trim",value:a.old_password,expression:"old_password",modifiers:{trim:!0}}],attrs:{type:"password",placeholder:"请输入密码"},domProps:{value:a.old_password},on:{input:function(t){t.target.composing||(a.old_password=t.target.value.trim())},blur:function(t){a.$forceUpdate()}}})]),a._v(" "),e("div",{staticClass:"inputRow"},[e("label",[a._v("新密码")]),a._v(" "),e("input",{directives:[{name:"model",rawName:"v-model.trim",value:a.new_password,expression:"new_password",modifiers:{trim:!0}}],attrs:{type:"password",placeholder:"请再次输入密码"},domProps:{value:a.new_password},on:{input:function(t){t.target.composing||(a.new_password=t.target.value.trim())},blur:function(t){a.$forceUpdate()}}})]),a._v(" "),e("div",{staticClass:"inputRow"},[e("label",[a._v("确认密码")]),a._v(" "),e("input",{directives:[{name:"model",rawName:"v-model.trim",value:a.new_password2,expression:"new_password2",modifiers:{trim:!0}}],attrs:{type:"password",placeholder:"请再次输入密码"},domProps:{value:a.new_password2},on:{input:function(t){t.target.composing||(a.new_password2=t.target.value.trim())},blur:function(t){a.$forceUpdate()}}})])]),a._v(" "),e("div",{staticClass:"btn_group"},[e("x-button",{staticClass:"btn_theme",attrs:{type:"primary"},nativeOn:{click:function(t){return a.getData(t)}}},[a._v("保存修改")])],1)])])},c=[],v={render:u,staticRenderFns:c},w=v,m=e("VU/8"),f=o,g=m(l,w,!1,f,"data-v-a6929ac4",null);t.default=g.exports},dvNx:function(a,t,e){var o=e("xxYf");"string"==typeof o&&(o=[[a.i,o,""]]),o.locals&&(a.exports=o.locals);e("rjj0")("627ffdcf",o,!0,{})},xxYf:function(a,t,e){var o=e("kxFB");t=a.exports=e("FZ+f")(!1),t.push([a.i,'.h[data-v-a6929ac4]{margin:5% 0 7%}.inputRow[data-v-a6929ac4]{margin:10px 0}.inputRow label[data-v-a6929ac4]{display:block;padding-bottom:5px;font-size:16px}input[data-v-a6929ac4]{background:transparent;height:40px;line-height:40px;width:100%;border-bottom:1px solid #e3e3e3;color:#aaa9ae;font-size:14px}.btn_group[data-v-a6929ac4]{padding:20px 0}.btn_group .weui-btn[data-v-a6929ac4]{margin-bottom:20px}.step[data-v-a6929ac4]{height:5px;width:100%;background:#f1f1f1}.step .line[data-v-a6929ac4]{height:5px;background:#298fee;width:0}.tag[data-v-a6929ac4]{background:#b9b9bd;color:#fff;font-size:12px;border-radius:3px;height:auto;line-height:normal;padding:1px 4px}.tag.ok[data-v-a6929ac4]{background:#5babfb}.upload[data-v-a6929ac4]{padding:10px 0 0 10px}.upload img[data-v-a6929ac4]{width:120px;height:99px;border-radius:5px;margin-right:10px}.upload .hasClose[data-v-a6929ac4]{position:relative;display:inline-block}.upload .hasClose[data-v-a6929ac4]:before{content:"";position:absolute;height:30px;width:30px;background:url('+o(e("P6I7"))+") no-repeat;z-index:9;left:-10px;top:-10px;background-size:contain}",""])}});
//# sourceMappingURL=10.e489845d3ee63d23f156.js.map