import{d as L,r as _,B as E,C as O,c as d,w as a,u as e,R as N,o,a as s,b as P,h as R,g as f,i as x,j as p,I as F,T as G,H as y,L as k,K as g,k as U,y as V,U as $,m as h,s as c,v as r,N as u,l as w,O as D,F as B,P as j,Q as H}from"./index-b762de1d.js";import{D as i}from"./datetime-49c8e94e.js";const M={slot:"content"},J=L({__name:"AllReports",setup(q){const m=_([]),I=_(!0),C=E(),T=_(null),A=O(()=>{const n=m.value.reduce((l,t)=>(l[t.user_id]||(l[t.user_id]=[]),l[t.user_id].push(t),l),{});return Object.keys(n).map(l=>({user:n[l][0].user,reports:n[l].map(t=>({...t,reportType:t.type=="Bill"?"Boletas":"Facturas",reportStatus:t.status=="Draft"?"Pendiente":"Enviado",reportDates:"".concat(i.fromISO(t.from_date).toLocaleString(i.DATE_MED)," - ").concat(i.fromISO(t.to_date).toLocaleString(i.DATE_MED))}))}))}),S=async()=>{const n=await N.get("/reports");I.value=!1,m.value=n},v=n=>{C.push("/reports/".concat(n))};return S(),(n,b)=>(o(),d(e(V),{ref_key:"page",ref:T},{default:a(()=>[s(e(F),null,{default:a(()=>[s(e(P),null,{default:a(()=>[s(e(R),null,{default:a(()=>[f("Todos los Reportes")]),_:1}),I.value?(o(),d(e(x),{key:0,type:"indeterminate"})):p("",!0)]),_:1})]),_:1}),s(e(U),null,{default:a(()=>[s(e(G),null,{default:a(()=>[(o(!0),y(g,null,k(A.value,l=>(o(),d(e($),{key:l.user.id},{default:a(()=>[s(e(h),{slot:"header",color:"light"},{default:a(()=>[s(e(c),null,{default:a(()=>[r("h2",null,u(l.user.name),1),r("p",null,"@"+u(l.user.username),1)]),_:2},1024)]),_:2},1024),r("section",M,[s(e(w),null,{default:a(()=>[(o(!0),y(g,null,k(l.reports,t=>(o(),d(e(h),{key:t.id,button:"",onClick:K=>v(t.id),detail:!0},{default:a(()=>[s(e(c),null,{default:a(()=>[r("h2",null,[r("b",null,u(t.title),1)]),r("p",null,u(t.reportType),1),r("p",null,u(t.reportDates),1)]),_:2},1024),t.status=="Draft"?(o(),d(e(D),{key:0,color:"danger"},{default:a(()=>[s(e(B),{icon:e(j)},null,8,["icon"]),s(e(c),null,{default:a(()=>[f(u(t.reportStatus),1)]),_:2},1024)]),_:2},1024)):p("",!0),t.status=="Submitted"?(o(),d(e(D),{key:1,color:"success"},{default:a(()=>[s(e(B),{icon:e(H)},null,8,["icon"]),s(e(c),null,{default:a(()=>[f(u(t.reportStatus),1)]),_:2},1024)]),_:2},1024)):p("",!0)]),_:2},1032,["onClick"]))),128))]),_:2},1024)])]),_:2},1024))),128))]),_:1})]),_:1})]),_:1},512))}});export{J as default};
