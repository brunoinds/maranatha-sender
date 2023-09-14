import{d as A,r as M,o as r,c as _,w as t,a,u as e,I as j,b as q,e as E,f as R,g as c,h as H,i as K,j as v,k as z,l as F,m as b,n as W,p as X,q as B,s as D,t as w,v as f,x,y as G,z as O,R as J,S as Y,A as Z,B as ee,C as te,D as ae,E as le,F as I,G as ne,H as k,J as T,K as L,L as N,M as se,N as y,O as S,P as $,Q as P}from"./index-bb5c1096.js";import{D as oe,E as ue,U,a as re}from"./ReportInterfaces-4741bd82.js";import{D as i}from"./datetime-49c8e94e.js";const de="/app/assets/report-633412c4.svg",ie=["disabled"],ce=["disabled"],pe=A({__name:"NewReport",props:{emitter:{type:oe,required:!0}},setup(V){const h=V,m=M(!1),l=M({title:"",type:ue.Bill,startDate:i.now().set({day:1}).toFormat("dd/MM/yyyy").toString(),endDate:i.now().set({day:1}).plus({month:1}).minus({day:1}).toFormat("dd/MM/yyyy").toString()}),C=async()=>{var s;const p=g();if(!p.isValid){O.create({header:"Oops...",message:p.errors[0],buttons:["OK"]}).then(o=>{o.present()});return}m.value=!0,J.post("/reports",{user_id:(s=await Y.getCurrentSession())==null?void 0:s.id(),title:l.value.title,type:l.value.type,from_date:i.fromFormat(l.value.startDate,"dd/MM/yyyy").toISO(),to_date:i.fromFormat(l.value.endDate,"dd/MM/yyyy").toISO(),status:"Draft"}).then(o=>{h.emitter.fire("created",{...o.report}),Z.create({message:"Reporte creado con exito!",duration:2e3}).then(u=>{u.present()}),h.emitter.fire("close")}).catch(o=>{O.create({header:"Oops...",message:o.response.message,buttons:["OK"]}).then(u=>{u.present()})}).finally(()=>{m.value=!1})},g=()=>{let p=[];l.value.title.trim().length==0&&p.push("El nombre del reporte no puede estar vacío");const s=i.fromFormat(l.value.startDate,"dd/MM/yyyy").isValid,o=i.fromFormat(l.value.endDate,"dd/MM/yyyy").isValid;if(s||p.push(i.fromFormat(l.value.startDate,"dd/MM/yyyy").invalidExplanation),o||p.push(i.fromFormat(l.value.endDate,"dd/MM/yyyy").invalidExplanation),s&&o){const u=i.fromFormat(l.value.startDate,"dd/MM/yyyy"),d=i.fromFormat(l.value.endDate,"dd/MM/yyyy");u>d&&p.push("La fecha de inicio no puede ser mayor a la fecha de término")}return{isValid:p.length==0,errors:p}};return(p,s)=>(r(),_(e(G),null,{default:t(()=>[a(e(j),null,{default:t(()=>[a(e(q),null,{default:t(()=>[a(e(E),{slot:"start"},{default:t(()=>[a(e(R),{onClick:s[0]||(s[0]=o=>h.emitter.fire("close"))},{default:t(()=>[c("Cancelar")]),_:1})]),_:1}),a(e(H),null,{default:t(()=>[c("Nuevo Reporte")]),_:1}),a(e(E),{slot:"end"},{default:t(()=>[a(e(R),{onClick:C},{default:t(()=>[c("Crear")]),_:1})]),_:1}),m.value?(r(),_(e(K),{key:0,type:"indeterminate"})):v("",!0)]),_:1})]),_:1}),a(e(z),null,{default:t(()=>[a(e(F),{inset:!0},{default:t(()=>[a(e(b),null,{default:t(()=>[a(e(W),{label:"Nombre del reporte","label-placement":"stacked",placeholder:"Nombre del reporte",modelValue:l.value.title,"onUpdate:modelValue":s[1]||(s[1]=o=>l.value.title=o),disabled:m.value},null,8,["modelValue","disabled"])]),_:1}),a(e(b),null,{default:t(()=>[a(e(X),{label:"Tipo de documento","label-placement":"stacked",interface:"action-sheet",modelValue:l.value.type,"onUpdate:modelValue":s[2]||(s[2]=o=>l.value.type=o),disabled:m.value},{default:t(()=>[a(e(B),{value:"Bill"},{default:t(()=>[c("Boletas")]),_:1}),a(e(B),{value:"Facture"},{default:t(()=>[c("Facturas")]),_:1})]),_:1},8,["modelValue","disabled"])]),_:1}),a(e(b),null,{default:t(()=>[a(e(D),{position:"stacked"},{default:t(()=>[c("Fecha de Inicio")]),_:1}),w(f("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":s[3]||(s[3]=o=>l.value.startDate=o),disabled:m.value},null,8,ie),[[e(U)],[x,l.value.startDate]])]),_:1}),a(e(b),null,{default:t(()=>[a(e(D),{position:"stacked"},{default:t(()=>[c("Fecha de Término")]),_:1}),w(f("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":s[4]||(s[4]=o=>l.value.endDate=o),disabled:m.value},null,8,ce),[[e(U)],[x,l.value.endDate]])]),_:1})]),_:1})]),_:1})]),_:1}))}}),fe={key:0},me={key:1},ye={key:2,class:"ion-padding",style:{display:"flex","flex-direction":"column","align-items":"center","justify-content":"center",height:"100%"}},_e=f("h2",null,"Aún no tienes reportes",-1),ve=f("p",{class:"ion-text-center"},'Crea tu primer reporte haciendo click en el botón "+" abajo',-1),be=A({__name:"Reports",setup(V){const h=M([]),m=M(!0),l=ee(),C=M(null),g=te(()=>{const u=h.value.map(d=>({...d,reportType:d.type=="Bill"?"Boletas":"Facturas",reportStatus:d.status=="Draft"?"Pendiente":"Enviado",reportDates:"".concat(i.fromISO(d.from_date).toLocaleString(i.DATE_MED)," - ").concat(i.fromISO(d.to_date).toLocaleString(i.DATE_MED))}));return{drafts:u.filter(d=>d.status=="Draft"),submitted:u.filter(d=>d.status=="Submitted")}}),p=async()=>{const u=await J.get("/me/reports");m.value=!1,h.value=u},s=u=>{l.push("/reports/".concat(u))},o=async()=>{re.show(pe,{onLoaded(u){u.on("created",d=>{const n=d.data.id;s(n),p()})},modalControllerOptions:{presentingElement:C,showBackdrop:!0}})};return p(),(u,d)=>(r(),_(e(G),{ref_key:"page",ref:C},{default:t(()=>[a(e(j),null,{default:t(()=>[a(e(q),null,{default:t(()=>[a(e(H),null,{default:t(()=>[c("Mis Reportes")]),_:1}),m.value?(r(),_(e(K),{key:0,type:"indeterminate"})):v("",!0)]),_:1})]),_:1}),a(e(z),null,{default:t(()=>[a(e(ae),{slot:"fixed",vertical:"bottom",horizontal:"end",edge:!1},{default:t(()=>[a(e(le),{onClick:o},{default:t(()=>[a(e(I),{icon:e(ne)},null,8,["icon"])]),_:1})]),_:1}),g.value.drafts.length>0?(r(),k("article",fe,[a(e(T),null,{default:t(()=>[c("Pendientes")]),_:1}),a(e(F),null,{default:t(()=>[(r(!0),k(L,null,N(g.value.drafts,n=>(r(),_(e(b),{key:n.id,button:"",onClick:Q=>s(n.id),detail:!0},{default:t(()=>[a(e(D),null,{default:t(()=>[f("h2",null,[f("b",null,y(n.title),1)]),f("p",null,y(n.reportType),1),f("p",null,y(n.reportDates),1)]),_:2},1024),n.status=="Draft"?(r(),_(e(S),{key:0,color:"danger"},{default:t(()=>[a(e(I),{icon:e($)},null,8,["icon"]),a(e(D),null,{default:t(()=>[c(y(n.reportStatus),1)]),_:2},1024)]),_:2},1024)):v("",!0),n.status=="Submitted"?(r(),_(e(S),{key:1,color:"success"},{default:t(()=>[a(e(I),{icon:e(P)},null,8,["icon"]),a(e(D),null,{default:t(()=>[c(y(n.reportStatus),1)]),_:2},1024)]),_:2},1024)):v("",!0)]),_:2},1032,["onClick"]))),128))]),_:1})])):v("",!0),g.value.submitted.length>0?(r(),k("article",me,[a(e(T),null,{default:t(()=>[c("Enviados")]),_:1}),a(e(F),null,{default:t(()=>[(r(!0),k(L,null,N(g.value.submitted,n=>(r(),_(e(b),{key:n.id,button:"",onClick:Q=>s(n.id),detail:!0},{default:t(()=>[a(e(D),null,{default:t(()=>[f("h2",null,[f("b",null,y(n.title),1)]),f("p",null,y(n.reportType),1),f("p",null,y(n.reportDates),1)]),_:2},1024),n.status=="Draft"?(r(),_(e(S),{key:0,color:"danger"},{default:t(()=>[a(e(I),{icon:e($)},null,8,["icon"]),a(e(D),null,{default:t(()=>[c(y(n.reportStatus),1)]),_:2},1024)]),_:2},1024)):v("",!0),n.status=="Submitted"?(r(),_(e(S),{key:1,color:"success"},{default:t(()=>[a(e(I),{icon:e(P)},null,8,["icon"]),a(e(D),null,{default:t(()=>[c(y(n.reportStatus),1)]),_:2},1024)]),_:2},1024)):v("",!0)]),_:2},1032,["onClick"]))),128))]),_:1})])):v("",!0),!m.value&&h.value.length==0?(r(),k("article",ye,[a(e(se),{src:e(de),style:{width:"90%",margin:"0 auto"}},null,8,["src"]),_e,ve])):v("",!0)]),_:1})]),_:1},512))}});export{be as default};
