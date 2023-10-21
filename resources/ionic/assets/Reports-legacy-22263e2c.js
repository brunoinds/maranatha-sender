System.register(["./index-legacy-23fb27d0.js","./ReportInterfaces-legacy-ede8d8a8.js","./datetime-legacy-a3ddd8e2.js"],(function(e,t){"use strict";var l,a,n,u,o,r,d,s,i,c,p,f,y,m,v,_,h,b,g,D,k,M,S,F,C,E,V,x,O,w,A,B,I,R,T,j,L,N,U,K,P,$,q,z,G,H,J,Q,W,X;return{setters:[e=>{l=e.d,a=e.r,n=e.o,u=e.c,o=e.w,r=e.a,d=e.u,s=e.I,i=e.b,c=e.e,p=e.f,f=e.g,y=e.h,m=e.i,v=e.j,_=e.k,h=e.l,b=e.m,g=e.n,D=e.p,k=e.q,M=e.s,S=e.t,F=e.v,C=e.x,E=e.y,V=e.z,x=e.R,O=e.S,w=e.A,A=e.B,B=e.C,I=e.D,R=e.E,T=e.F,j=e.G,L=e.H,N=e.J,U=e.K,K=e.L,P=e.M,$=e.N,q=e.O,z=e.P,G=e.Q},e=>{H=e.D,J=e.E,Q=e.U,W=e.a},e=>{X=e.D}],execute:function(){const t=["disabled"],Y=["disabled"],Z=l({__name:"NewReport",props:{emitter:{type:H,required:!0}},setup(e){const l=e,A=a(!1),B=a({title:"",type:J.Bill,startDate:X.now().set({day:1}).toFormat("dd/MM/yyyy").toString(),endDate:X.now().set({day:1}).plus({month:1}).minus({day:1}).toFormat("dd/MM/yyyy").toString()}),I=async()=>{var e;const t=R();t.isValid?(A.value=!0,x.post("/reports",{user_id:null===(e=await O.getCurrentSession())||void 0===e?void 0:e.id(),title:B.value.title,type:B.value.type,from_date:X.fromFormat(B.value.startDate,"dd/MM/yyyy").toISO(),to_date:X.fromFormat(B.value.endDate,"dd/MM/yyyy").toISO(),status:"Draft"}).then((e=>{l.emitter.fire("created",{...e.report}),w.create({message:"Reporte creado con exito!",duration:2e3}).then((e=>{e.present()})),l.emitter.fire("close")})).catch((e=>{V.create({header:"Oops...",message:e.response.message,buttons:["OK"]}).then((e=>{e.present()}))})).finally((()=>{A.value=!1}))):V.create({header:"Oops...",message:t.errors[0],buttons:["OK"]}).then((e=>{e.present()}))},R=()=>{let e=[];0==B.value.title.trim().length&&e.push("El nombre del reporte no puede estar vacío");const t=X.fromFormat(B.value.startDate,"dd/MM/yyyy").isValid,l=X.fromFormat(B.value.endDate,"dd/MM/yyyy").isValid;return t||e.push(X.fromFormat(B.value.startDate,"dd/MM/yyyy").invalidExplanation),l||e.push(X.fromFormat(B.value.endDate,"dd/MM/yyyy").invalidExplanation),t&&l&&X.fromFormat(B.value.startDate,"dd/MM/yyyy")>X.fromFormat(B.value.endDate,"dd/MM/yyyy")&&e.push("La fecha de inicio no puede ser mayor a la fecha de término"),{isValid:0==e.length,errors:e}};return(e,a)=>(n(),u(d(E),null,{default:o((()=>[r(d(s),null,{default:o((()=>[r(d(i),null,{default:o((()=>[r(d(c),{slot:"start"},{default:o((()=>[r(d(p),{onClick:a[0]||(a[0]=e=>l.emitter.fire("close"))},{default:o((()=>[f("Cancelar")])),_:1})])),_:1}),r(d(y),null,{default:o((()=>[f("Nuevo Reporte")])),_:1}),r(d(c),{slot:"end"},{default:o((()=>[r(d(p),{onClick:I},{default:o((()=>[f("Crear")])),_:1})])),_:1}),A.value?(n(),u(d(m),{key:0,type:"indeterminate"})):v("",!0)])),_:1})])),_:1}),r(d(_),null,{default:o((()=>[r(d(h),{inset:!0},{default:o((()=>[r(d(b),null,{default:o((()=>[r(d(g),{label:"Nombre del reporte","label-placement":"stacked",placeholder:"Nombre del reporte",modelValue:B.value.title,"onUpdate:modelValue":a[1]||(a[1]=e=>B.value.title=e),disabled:A.value},null,8,["modelValue","disabled"])])),_:1}),r(d(b),null,{default:o((()=>[r(d(D),{label:"Tipo de documento","label-placement":"stacked",interface:"action-sheet",modelValue:B.value.type,"onUpdate:modelValue":a[2]||(a[2]=e=>B.value.type=e),disabled:A.value},{default:o((()=>[r(d(k),{value:"Bill"},{default:o((()=>[f("Boletas")])),_:1}),r(d(k),{value:"Facture"},{default:o((()=>[f("Facturas")])),_:1})])),_:1},8,["modelValue","disabled"])])),_:1}),r(d(b),null,{default:o((()=>[r(d(M),{position:"stacked"},{default:o((()=>[f("Fecha de Inicio")])),_:1}),S(F("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":a[3]||(a[3]=e=>B.value.startDate=e),disabled:A.value},null,8,t),[[d(Q)],[C,B.value.startDate]])])),_:1}),r(d(b),null,{default:o((()=>[r(d(M),{position:"stacked"},{default:o((()=>[f("Fecha de Término")])),_:1}),S(F("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":a[4]||(a[4]=e=>B.value.endDate=e),disabled:A.value},null,8,Y),[[d(Q)],[C,B.value.endDate]])])),_:1})])),_:1})])),_:1})])),_:1}))}}),ee={key:0},te={key:1},le={key:2,class:"ion-padding",style:{display:"flex","flex-direction":"column","align-items":"center","justify-content":"center",height:"100%"}},ae=F("h2",null,"Aún no tienes reportes",-1),ne=F("p",{class:"ion-text-center"},'Crea tu primer reporte haciendo click en el botón "+" abajo',-1);e("default",l({__name:"Reports",setup(e){const t=a([]),l=a(!0),c=A(),p=a(null),g=B((()=>{const e=t.value.map((e=>({...e,reportType:"Bill"==e.type?"Boletas":"Facturas",reportStatus:"Draft"==e.status?"Pendiente":"Enviado",reportDates:`${X.fromISO(e.from_date).toLocaleString(X.DATE_MED)} - ${X.fromISO(e.to_date).toLocaleString(X.DATE_MED)}`,invoices:{total:e.invoices.count,totalAmount:e.invoices.total_amount}})));return{drafts:e.filter((e=>"Draft"==e.status)),submitted:e.filter((e=>"Submitted"==e.status))}})),D=async()=>{const e=await x.get("/me/reports");l.value=!1,t.value=e},k=e=>{c.push(`/reports/${e}`)},S=async()=>{W.show(Z,{onLoaded(e){e.on("created",(e=>{const t=e.data.id;k(t),D()}))},modalControllerOptions:{presentingElement:p,showBackdrop:!0}})};return D(),(e,a)=>(n(),u(d(E),{ref_key:"page",ref:p},{default:o((()=>[r(d(s),null,{default:o((()=>[r(d(i),null,{default:o((()=>[r(d(y),null,{default:o((()=>[f("Mis Reportes")])),_:1}),l.value?(n(),u(d(m),{key:0,type:"indeterminate"})):v("",!0)])),_:1})])),_:1}),r(d(_),null,{default:o((()=>[r(d(I),{slot:"fixed",vertical:"bottom",horizontal:"end",edge:!1},{default:o((()=>[r(d(R),{onClick:S},{default:o((()=>[r(d(T),{icon:d(j)},null,8,["icon"])])),_:1})])),_:1}),g.value.drafts.length>0?(n(),L("article",ee,[r(d(N),null,{default:o((()=>[f("Pendientes")])),_:1}),r(d(h),null,{default:o((()=>[(n(!0),L(U,null,K(g.value.drafts,(e=>(n(),u(d(b),{key:e.id,button:"",onClick:t=>k(e.id),detail:!0},{default:o((()=>[r(d(M),null,{default:o((()=>[F("h2",null,[F("b",null,$(e.title),1)]),F("p",null,$(e.reportType),1),F("p",null,$(e.reportDates),1),F("p",null,[F("b",null,"S./ "+$(e.invoices.totalAmount),1)])])),_:2},1024),"Draft"==e.status?(n(),u(d(q),{key:0,color:"danger"},{default:o((()=>[r(d(T),{icon:d(z)},null,8,["icon"]),r(d(M),null,{default:o((()=>[f($(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):v("",!0),"Submitted"==e.status?(n(),u(d(q),{key:1,color:"success"},{default:o((()=>[r(d(T),{icon:d(G)},null,8,["icon"]),r(d(M),null,{default:o((()=>[f($(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):v("",!0)])),_:2},1032,["onClick"])))),128))])),_:1})])):v("",!0),g.value.submitted.length>0?(n(),L("article",te,[r(d(N),null,{default:o((()=>[f("Enviados")])),_:1}),r(d(h),null,{default:o((()=>[(n(!0),L(U,null,K(g.value.submitted,(e=>(n(),u(d(b),{key:e.id,button:"",onClick:t=>k(e.id),detail:!0},{default:o((()=>[r(d(M),null,{default:o((()=>[F("h2",null,[F("b",null,$(e.title),1)]),F("p",null,$(e.reportType),1),F("p",null,$(e.reportDates),1),F("p",null,[F("b",null,"S./ "+$(e.invoices.totalAmount),1)])])),_:2},1024),"Draft"==e.status?(n(),u(d(q),{key:0,color:"danger"},{default:o((()=>[r(d(T),{icon:d(z)},null,8,["icon"]),r(d(M),null,{default:o((()=>[f($(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):v("",!0),"Submitted"==e.status?(n(),u(d(q),{key:1,color:"success"},{default:o((()=>[r(d(T),{icon:d(G)},null,8,["icon"]),r(d(M),null,{default:o((()=>[f($(e.reportStatus),1)])),_:2},1024)])),_:2},1024)):v("",!0)])),_:2},1032,["onClick"])))),128))])),_:1})])):v("",!0),l.value||0!=t.value.length?v("",!0):(n(),L("article",le,[r(d(P),{src:d("/app/assets/report-633412c4.svg"),style:{width:"90%",margin:"0 auto"}},null,8,["src"]),ae,ne]))])),_:1})])),_:1},512))}}))}}}));