import{d as V,B as N,r as y,C as B,c as m,w as t,u as a,S as I,o as v,a as n,I as D,v as d,M as O,l as U,m as b,n as x,f as C,g as k,j as g,i as K,k as P,y as S,z as i,R as H}from"./index-0cb7082f.js";import{_ as R}from"./_plugin-vue_export-helper-c27b6911.js";const M="/app/assets/maranatha-logo-d14af968.svg",j={class:"holder ion-padding"},q={style:{}},z=V({__name:"Login",setup(A){const h=N(),o=y({username:"",password:""}),L=B(()=>o.value.username.length>0&&o.value.password.length>=8),l=y(!1),_=()=>{l.value=!0,I.login(o.value.username,o.value.password).then(e=>{h.push("/my-reports")}).catch(e=>{e.message=="Invalid credentials"?i.create({header:"Oops...",message:"Usuario o contraseña incorrectos",buttons:["OK"]}).then(s=>{s.present()}):i.create({header:"Oops...",message:e.message,buttons:["OK"]}).then(s=>{s.present()})}).finally(()=>{l.value=!1})},f=async(e=null)=>{const s=await i.create({header:"Nuevo usuário",inputs:[{type:"text",placeholder:"Nombres y apellidos",value:e?e.name:null},{type:"email",placeholder:"Correo electrónico",value:e?e.email:null},{type:"text",placeholder:"Nombre de usuario",value:e?e.username:null},{type:"password",placeholder:"Contraseña",value:e?e.password:null}],buttons:[{text:"Cancelar",role:"cancel",handler:()=>{}},{text:"Crear Usuário",role:"confirm"}]});await s.present();const{role:r,data:c}=await s.onDidDismiss();if(r=="confirm"){const p={name:c.values[0],username:c.values[2],email:c.values[1],password:c.values[3]};H.post("/users",p).then(w=>{i.create({header:"¡Éxito!",message:"Usuário creado exitosamente",buttons:["OK"]}).then(async u=>{await u.present(),await u.onDidDismiss(),o.value.username=p.username,o.value.password=p.password,_()})}).catch(w=>{i.create({header:"Oops...",message:w.response.message,buttons:["OK"]}).then(async u=>{await u.present(),await u.onDidDismiss(),f(p)})})}};return(async()=>{await I.isLogged()&&h.push("/my-reports")})(),(e,s)=>(v(),m(a(S),null,{default:t(()=>[n(a(D)),n(a(P),{class:"ion-padding",scrollX:!1,scrollY:!1},{default:t(()=>[d("section",j,[d("article",q,[d("header",null,[n(a(O),{src:a(M),style:{width:"90%",margin:"0 auto"}},null,8,["src"])]),d("main",null,[n(a(U),null,{default:t(()=>[n(a(b),null,{default:t(()=>[n(a(x),{label:"Usuário","label-placement":"stacked",modelValue:o.value.username,"onUpdate:modelValue":s[0]||(s[0]=r=>o.value.username=r),placeholder:"Nombre de usuário"},null,8,["modelValue"])]),_:1}),n(a(b),null,{default:t(()=>[n(a(x),{label:"Contraseña","label-placement":"stacked",modelValue:o.value.password,"onUpdate:modelValue":s[1]||(s[1]=r=>o.value.password=r),placeholder:"Ingresa su clave"},null,8,["modelValue"])]),_:1})]),_:1})]),d("footer",null,[l.value?g("",!0):(v(),m(a(C),{key:0,disabled:!L.value,expand:"block",onClick:_},{default:t(()=>[k("Iniciar sesión")]),_:1},8,["disabled"])),l.value?g("",!0):(v(),m(a(C),{key:1,expand:"block",fill:"outline",onClick:f},{default:t(()=>[k("Crear una cuenta")]),_:1})),l.value?(v(),m(a(K),{key:2,type:"indeterminate"})):g("",!0)])])])]),_:1})]),_:1}))}});const E=R(z,[["__scopeId","data-v-6bd0c9f5"]]);export{E as default};
