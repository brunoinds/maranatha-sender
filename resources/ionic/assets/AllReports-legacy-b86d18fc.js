System.register(["./index-legacy-77355ada.js","./datetime-legacy-a3ddd8e2.js"],(function(e,t){"use strict";var l,u,r,a,n,s,o,d,i,c,f,p,_,y,m,k,g,v,D,S,h,T,b,E,j,O,A,B,C,I,L,R,$;return{setters:[e=>{l=e.d,u=e.r,r=e.B,a=e.C,n=e.c,s=e.w,o=e.u,d=e.R,i=e.o,c=e.a,f=e.b,p=e.h,_=e.g,y=e.i,m=e.j,k=e.I,g=e.T,v=e.H,D=e.L,S=e.K,h=e.k,T=e.y,b=e.U,E=e.m,j=e.s,O=e.v,A=e.N,B=e.l,C=e.O,I=e.F,L=e.P,R=e.Q},e=>{$=e.D}],execute:function(){const t={slot:"content"};e("default",l({__name:"AllReports",setup(e){const l=u([]),w=u(!0),x=r(),F=u(null),M=a((()=>{const e=l.value.reduce(((e,t)=>(e[t.user_id]||(e[t.user_id]=[]),e[t.user_id].push(t),e)),{});return Object.keys(e).map((t=>({user:e[t][0].user,reports:e[t].map((e=>({...e,reportType:"Bill"==e.type?"Boletas":"Facturas",reportStatus:"Draft"==e.status?"Pendiente":"Enviado",reportDates:`${$.fromISO(e.from_date).toLocaleString($.DATE_MED)} - ${$.fromISO(e.to_date).toLocaleString($.DATE_MED)}`})))})))}));return(async()=>{const e=await d.get("/reports");w.value=!1,l.value=e})(),(e,l)=>(i(),n(o(T),{ref_key:"page",ref:F},{default:s((()=>[c(o(k),null,{default:s((()=>[c(o(f),null,{default:s((()=>[c(o(p),null,{default:s((()=>[_("Todos los Reportes")])),_:1}),w.value?(i(),n(o(y),{key:0,type:"indeterminate"})):m("",!0)])),_:1})])),_:1}),c(o(h),null,{default:s((()=>[c(o(g),null,{default:s((()=>[(i(!0),v(S,null,D(M.value,(e=>(i(),n(o(b),{key:e.user.id},{default:s((()=>[c(o(E),{slot:"header",color:"light"},{default:s((()=>[c(o(j),null,{default:s((()=>[O("h2",null,A(e.user.name),1),O("p",null,"@"+A(e.user.username),1)])),_:2},1024)])),_:2},1024),O("section",t,[c(o(B),null,{default:s((()=>[(i(!0),v(S,null,D(e.reports,(e=>(i(),n(o(E),{key:e.id,button:"",onClick:t=>{return l=e.id,void x.push(`/reports/${l}`);var l},detail:!0},{default:s((()=>[c(o(j),null,{default:s((()=>[O("h2",null,[O("b",null,A(e.title),1)]),O("p",null,A(e.reportType),1),O("p",null,A(e.reportDates),1)])),_:2},1024),"Draft"==e.status?(i(),n(o(C),{key:0,color:"danger"},{default:s((()=>[c(o(I),{icon:o(L)},null,8,["icon"]),c(o(j),null,{default:s((()=>[_(A(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):m("",!0),"Submitted"==e.status?(i(),n(o(C),{key:1,color:"success"},{default:s((()=>[c(o(I),{icon:o(R)},null,8,["icon"]),c(o(j),null,{default:s((()=>[_(A(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):m("",!0)])),_:2},1032,["onClick"])))),128))])),_:2},1024)])])),_:2},1024)))),128))])),_:1})])),_:1})])),_:1},512))}}))}}}));