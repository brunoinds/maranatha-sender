System.register(["./index-legacy-6da67748.js"],(function(e,l){"use strict";var t,a,n,u,r,o,s,c,i,d,f,_,g,m,v,y,h,p,k,S,w,j,x,C,b,A;return{setters:[e=>{t=e.d,a=e.r,n=e.B,u=e.V,r=e.c,o=e.w,s=e.u,c=e.R,i=e.o,d=e.a,f=e.b,_=e.h,g=e.g,m=e.i,v=e.j,y=e.I,h=e.l,p=e.m,k=e.s,S=e.v,w=e.N,j=e.F,x=e.W,C=e.k,b=e.y,A=e.S}],execute:function(){const l=S("img",{alt:"Silhouette of a person's head",src:"https://ionicframework.com/docs/img/demos/avatar.svg"},null,-1);e("default",t({__name:"Account",setup(e){const t=a(null),B=a(!0),F=n(),I=a(null),M=()=>{F.replace("/login")},N=async()=>{A.getCurrentSession().then((async e=>{e||M(),e.logout().then((()=>{M()})).catch((e=>{console.error(e)}))}))};return(async()=>{t.value=await c.get("/account/me"),B.value=!1})(),(e,a)=>{const n=u("ion-avatar");return i(),r(s(b),{ref_key:"page",ref:I},{default:o((()=>[d(s(y),null,{default:o((()=>[d(s(f),null,{default:o((()=>[d(s(_),null,{default:o((()=>[g("Mi cuenta")])),_:1}),B.value?(i(),r(s(m),{key:0,type:"indeterminate"})):v("",!0)])),_:1})])),_:1}),d(s(C),null,{default:o((()=>[B.value?v("",!0):(i(),r(s(h),{key:0},{default:o((()=>[d(s(p),null,{default:o((()=>[d(n,{slot:"start"},{default:o((()=>[l])),_:1}),d(s(k),null,{default:o((()=>[S("h2",null,w(t.value.name),1),S("p",null,w(t.value.email),1)])),_:1})])),_:1}),d(s(p),{onClick:N},{default:o((()=>[d(s(j),{color:"danger",icon:s(x),slot:"start"},null,8,["icon"]),d(s(k),{color:"danger"},{default:o((()=>[g("Terminar sesión")])),_:1})])),_:1})])),_:1}))])),_:1})])),_:1},512)}}}))}}}));
