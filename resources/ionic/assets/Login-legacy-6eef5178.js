System.register(["./index-legacy-b7a82da0.js","./_plugin-vue_export-helper-legacy-762b7923.js"],(function(e,a){"use strict";var l,s,t,n,o,r,u,d,i,c,p,m,h,v,g,f,y,w,b,x,_,C,k,O,D;return{setters:[e=>{l=e.d,s=e.B,t=e.r,n=e.C,o=e.c,r=e.w,u=e.u,d=e.S,i=e.o,c=e.a,p=e.I,m=e.v,h=e.M,v=e.l,g=e.m,f=e.n,y=e.f,w=e.g,b=e.j,x=e.i,_=e.k,C=e.y,k=e.z,O=e.R},e=>{D=e._}],execute:function(){var a=document.createElement("style");a.textContent=".holder[data-v-6bd0c9f5]{position:absolute;top:0;bottom:0;left:0;right:0}.holder>article[data-v-6bd0c9f5]{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;max-width:400px;padding:20px;display:flex;flex-direction:column;row-gap:12px}\n",document.head.appendChild(a);const U={class:"holder ion-padding"},V={style:{}};e("default",D(l({__name:"Login",setup(e){const a=s(),l=t({username:"",password:""}),D=n((()=>l.value.username.length>0&&l.value.password.length>=8)),I=t(!1),K=()=>{I.value=!0,d.login(l.value.username,l.value.password).then((e=>{a.push("/my-reports")})).catch((e=>{"Invalid credentials"==e.message?k.create({header:"Oops...",message:"Usuario o contraseña incorrectos",buttons:["OK"]}).then((e=>{e.present()})):k.create({header:"Oops...",message:e.message,buttons:["OK"]}).then((e=>{e.present()}))})).finally((()=>{I.value=!1}))},N=async(e=null)=>{const a=await k.create({header:"Nuevo usuário",inputs:[{type:"text",placeholder:"Nombres y apellidos",value:e?e.name:null},{type:"email",placeholder:"Correo electrónico",value:e?e.email:null},{type:"text",placeholder:"Nombre de usuario",value:e?e.username:null},{type:"password",placeholder:"Contraseña",value:e?e.password:null}],buttons:[{text:"Cancelar",role:"cancel",handler:()=>{}},{text:"Crear Usuário",role:"confirm"}]});await a.present();const{role:s,data:t}=await a.onDidDismiss();if("confirm"==s){const e={name:t.values[0],username:t.values[2],email:t.values[1],password:t.values[3]};O.post("/users",e).then((a=>{k.create({header:"¡Éxito!",message:"Usuário creado exitosamente",buttons:["OK"]}).then((async a=>{await a.present(),await a.onDidDismiss(),l.value.username=e.username,l.value.password=e.password,K()}))})).catch((a=>{k.create({header:"Oops...",message:a.response.message,buttons:["OK"]}).then((async a=>{await a.present(),await a.onDidDismiss(),N(e)}))}))}};return(async()=>{await d.isLogged()&&a.push("/my-reports")})(),(e,a)=>(i(),o(u(C),null,{default:r((()=>[c(u(p)),c(u(_),{class:"ion-padding",scrollX:!1,scrollY:!1},{default:r((()=>[m("section",U,[m("article",V,[m("header",null,[c(u(h),{src:u("/app/assets/maranatha-logo-d14af968.svg"),style:{width:"90%",margin:"0 auto"}},null,8,["src"])]),m("main",null,[c(u(v),null,{default:r((()=>[c(u(g),null,{default:r((()=>[c(u(f),{label:"Usuário","label-placement":"stacked",modelValue:l.value.username,"onUpdate:modelValue":a[0]||(a[0]=e=>l.value.username=e),placeholder:"Nombre de usuário"},null,8,["modelValue"])])),_:1}),c(u(g),null,{default:r((()=>[c(u(f),{label:"Contraseña","label-placement":"stacked",modelValue:l.value.password,"onUpdate:modelValue":a[1]||(a[1]=e=>l.value.password=e),placeholder:"Ingresa su clave"},null,8,["modelValue"])])),_:1})])),_:1})]),m("footer",null,[I.value?b("",!0):(i(),o(u(y),{key:0,disabled:!D.value,expand:"block",onClick:K},{default:r((()=>[w("Iniciar sesión")])),_:1},8,["disabled"])),I.value?b("",!0):(i(),o(u(y),{key:1,expand:"block",fill:"outline",onClick:N},{default:r((()=>[w("Crear una cuenta")])),_:1})),I.value?(i(),o(u(x),{key:2,type:"indeterminate"})):b("",!0)])])])])),_:1})])),_:1}))}}),[["__scopeId","data-v-6bd0c9f5"]]))}}}));
