System.register(["./index-legacy-801db695.js"],(function(t,e){"use strict";var n,o,r;return{setters:[t=>{n=t.aS,o=t.aU,r=t.aV}],execute:function(){var e=globalThis&&globalThis.__awaiter||function(t,e,n,o){function r(t){return t instanceof n?t:new n((function(e){e(t)}))}return new(n||(n=Promise))((function(n,i){function a(t){try{c(o.next(t))}catch(t){i(t)}}function u(t){try{c(o.throw(t))}catch(t){i(t)}}function c(t){t.done?n(t.value):r(t.value).then(a,u)}c((o=o.apply(t,e||[])).next())}))},i=globalThis&&globalThis.__generator||function(t,e){var n,o,r,i,a={label:0,sent:function(){if(1&r[0])throw r[1];return r[1]},trys:[],ops:[]};return i={next:u(0),throw:u(1),return:u(2)},"function"==typeof Symbol&&(i[Symbol.iterator]=function(){return this}),i;function u(t){return function(e){return c([t,e])}}function c(u){if(n)throw new TypeError("Generator is already executing.");for(;i&&(i=0,u[0]&&(a=0)),a;)try{if(n=1,o&&(r=2&u[0]?o.return:u[0]?o.throw||((r=o.return)&&r.call(o),0):o.next)&&!(r=r.call(o,u[1])).done)return r;switch(o=0,r&&(u=[2&u[0],r.value]),u[0]){case 0:case 1:r=u;break;case 4:return a.label++,{value:u[1],done:!1};case 5:a.label++,o=u[1],u=[0];continue;case 7:u=a.ops.pop(),a.trys.pop();continue;default:if(!((r=(r=a.trys).length>0&&r[r.length-1])||6!==u[0]&&2!==u[0])){a=0;continue}if(3===u[0]&&(!r||u[1]>r[0]&&u[1]<r[3])){a.label=u[1];break}if(6===u[0]&&a.label<r[1]){a.label=r[1],r=u;break}if(r&&a.label<r[2]){a.label=r[2],a.ops.push(u);break}r[2]&&a.ops.pop(),a.trys.pop();continue}u=e.call(t,a)}catch(t){u=[6,t],o=0}finally{n=r=0}if(5&u[0])throw u[1];return{value:u[0]?u[1]:void 0,done:!0}}};t("pwa_camera_modal",function(){function t(t){o(this,t),this.onPhoto=r(this,"onPhoto",7),this.noDeviceError=r(this,"noDeviceError",7),this.facingMode="user"}return t.prototype.present=function(){return e(this,void 0,void 0,(function(){var t,n=this;return i(this,(function(o){return(t=document.createElement("pwa-camera-modal-instance")).facingMode=this.facingMode,t.addEventListener("onPhoto",(function(t){return e(n,void 0,void 0,(function(){var e;return i(this,(function(n){return this._modal?(e=t.detail,this.onPhoto.emit(e),[2]):[2]}))}))})),t.addEventListener("noDeviceError",(function(t){return e(n,void 0,void 0,(function(){return i(this,(function(e){return this.noDeviceError.emit(t),[2]}))}))})),document.body.append(t),this._modal=t,[2]}))}))},t.prototype.dismiss=function(){return e(this,void 0,void 0,(function(){return i(this,(function(t){return this._modal?(this._modal&&this._modal.parentNode.removeChild(this._modal),this._modal=null,[2]):[2]}))}))},t.prototype.render=function(){return n("div",null)},t}()).style=":host{z-index:1000;position:fixed;top:0;left:0;width:100%;height:100%;display:-ms-flexbox;display:flex;contain:strict}.wrapper{-ms-flex:1;flex:1;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;background-color:rgba(0, 0, 0, 0.15)}.content{-webkit-box-shadow:0px 0px 5px rgba(0, 0, 0, 0.2);box-shadow:0px 0px 5px rgba(0, 0, 0, 0.2);width:600px;height:600px}"}}}));
