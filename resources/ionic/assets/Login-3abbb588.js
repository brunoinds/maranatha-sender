import{d as b,r as _,A as a,c as I,w as o,a as n,o as v,b as e,I as k,e as C,f as l,g as x,v as t,p as L,q as N}from"./index-1429d4c6.js";import{R}from"./RequestAPI-7dca5b6f.js";const u="/app/assets/maranatha-logo-d14af968.svg",w=t("article",null,[t("header"),t("main")],-1),A=b({__name:"Login",setup(B){console.log(u);const d=_([]),p=_(!0);return(async()=>{const s=await R.get("/reports",{user_id:1});p.value=!1,d.value=s.data})(),(s,U)=>{const m=a("ion-img"),f=a("ion-card-header"),r=a("ion-input"),c=a("ion-item"),g=a("ion-list"),i=a("ion-button"),h=a("ion-card");return v(),I(n(N),null,{default:o(()=>[e(n(x),null,{default:o(()=>[e(n(k),null,{default:o(()=>[e(n(C),null,{default:o(()=>[l("Login")]),_:1})]),_:1})]),_:1}),e(n(L),null,{default:o(()=>[w,e(h,null,{default:o(()=>[e(f,null,{default:o(()=>[e(m,{src:n(u)},null,8,["src"])]),_:1}),t("main",null,[e(g,null,{default:o(()=>[e(c,null,{default:o(()=>[e(r,{label:"Usuário","label-placement":"stacked",placeholder:"Nombre de usuário"})]),_:1}),e(c,null,{default:o(()=>[e(r,{label:"Contraseña","label-placement":"stacked",placeholder:"Ingresa su clave"})]),_:1})]),_:1})]),t("footer",null,[e(i,{fill:"clear"},{default:o(()=>[l("Iniciar sesión")]),_:1}),e(i,{color:"dark",fill:"clear"},{default:o(()=>[l("Olvidé mi contraseña")]),_:1})])]),_:1})]),_:1})]),_:1})}}});export{A as default};
