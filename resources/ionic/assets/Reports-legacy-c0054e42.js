System.register(["./index-legacy-ade528f8.js","./RequestAPI-legacy-8663166e.js"],(function(e,l){"use strict";var t,u,n,a,s,r,d,i,o,c,f,_,v,p,g,h,y,k,m,x,R,b,j,q,w,C,I;return{setters:[e=>{t=e.d,u=e.r,n=e.u,a=e.c,s=e.w,r=e.a,d=e.o,i=e.b,o=e.I,c=e.e,f=e.f,_=e.g,v=e.h,p=e.i,g=e.j,h=e.k,y=e.l,k=e.m,m=e.n,x=e.F,R=e.p,b=e.q,j=e.s,q=e.t,w=e.v,C=e.x},e=>{I=e.R}],execute:function(){e("default",t({__name:"Reports",setup(e){const l=u([]),t=u(!0),z=n();return(async()=>{const e=await I.get("/reports");t.value=!1,l.value=e})(),(e,t)=>(d(),a(r(b),null,{default:s((()=>[i(r(_),null,{default:s((()=>[i(r(o),null,{default:s((()=>[i(r(c),null,{default:s((()=>[f("Mis Reportes")])),_:1})])),_:1})])),_:1}),i(r(R),null,{default:s((()=>[i(r(v),{slot:"fixed",vertical:"bottom",horizontal:"end",edge:!1},{default:s((()=>[i(r(p),null,{default:s((()=>[i(r(g),{icon:r(h)},null,8,["icon"])])),_:1})])),_:1}),i(r(y),null,{default:s((()=>[(d(!0),k(x,null,m(l.value,(e=>(d(),a(r(j),{key:e.id,button:"",onClick:l=>{return t=e.id,void z.push(`/reports/${t}`);var t},detail:!0},{default:s((()=>[i(r(q),null,{default:s((()=>[w("h2",null,C(e.title),1),w("h3",null,C(e.status),1)])),_:2},1024)])),_:2},1032,["onClick"])))),128))])),_:1})])),_:1})])),_:1}))}}))}}}));
