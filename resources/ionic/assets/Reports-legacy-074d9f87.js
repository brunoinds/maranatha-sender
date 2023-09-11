System.register(["./index-legacy-4514fca9.js","./RequestAPI-legacy-f8dcfb20.js","./datetime-legacy-bd58d730.js"],(function(e,t){"use strict";var a,l,d,o,u,n,r,s,i,y,c,p,m,f,v,_,h,b,M,g,D,k,F,V,C,w,x,O,R,S,E,j,B,I,U,N,q,K,z,A,L,T,G,H;return{setters:[e=>{a=e.d,l=e.r,d=e.o,o=e.c,u=e.w,n=e.a,r=e.u,s=e.I,i=e.b,y=e.e,c=e.f,p=e.g,m=e.h,f=e.i,v=e.j,_=e.k,h=e.l,b=e.m,M=e.n,g=e.p,D=e.q,k=e.s,F=e.t,V=e.v,C=e.x,w=e.y,x=e.z,O=e.A,R=e.B,S=e.C,E=e.D,j=e.E,B=e.F,I=e.G,U=e.H,N=e.J,q=e.K},e=>{K=e.R,z=e.S},e=>{A=e.D,L=e.E,T=e.a,G=e.U,H=e.b}],execute:function(){const t=["disabled"],J=["disabled"],P=a({__name:"NewReport",props:{emitter:{type:A,required:!0}},setup(e){const a=e,R=l(!1),S=l({title:"",type:L.Bill,startDate:T.now().set({day:1}).toFormat("dd/MM/yyyy").toString(),endDate:T.now().set({day:1}).plus({month:1}).minus({day:1}).toFormat("dd/MM/yyyy").toString()}),E=async()=>{var e;const t=j();t.isValid?(R.value=!0,K.post("/reports",{user_id:null===(e=await z.getCurrentSession())||void 0===e?void 0:e.id(),title:S.value.title,type:S.value.type,from_date:T.fromFormat(S.value.startDate,"dd/MM/yyyy").toISO(),to_date:T.fromFormat(S.value.endDate,"dd/MM/yyyy").toISO(),status:"Draft"}).then((e=>{a.emitter.fire("created",{...e.report}),O.create({message:"Reporte creado con exito!",duration:2e3}).then((e=>{e.present()})),a.emitter.fire("close")})).catch((e=>{x.create({header:"Oops...",message:e.response.message,buttons:["OK"]}).then((e=>{e.present()}))})).finally((()=>{R.value=!1}))):x.create({header:"Oops...",message:t.errors[0],buttons:["OK"]}).then((e=>{e.present()}))},j=()=>{let e=[];0==S.value.title.trim().length&&e.push("El nombre del reporte no puede estar vacío");const t=T.fromFormat(S.value.startDate,"dd/MM/yyyy").isValid,a=T.fromFormat(S.value.endDate,"dd/MM/yyyy").isValid;return t||e.push(T.fromFormat(S.value.startDate,"dd/MM/yyyy").invalidExplanation),a||e.push(T.fromFormat(S.value.endDate,"dd/MM/yyyy").invalidExplanation),t&&a&&T.fromFormat(S.value.startDate,"dd/MM/yyyy")>T.fromFormat(S.value.endDate,"dd/MM/yyyy")&&e.push("La fecha de inicio no puede ser mayor a la fecha de término"),{isValid:0==e.length,errors:e}};return(e,l)=>(d(),o(r(w),null,{default:u((()=>[n(r(s),null,{default:u((()=>[n(r(i),null,{default:u((()=>[n(r(y),{slot:"start"},{default:u((()=>[n(r(c),{onClick:l[0]||(l[0]=e=>a.emitter.fire("close"))},{default:u((()=>[p("Cancelar")])),_:1})])),_:1}),n(r(m),null,{default:u((()=>[p("Nuevo Reporte")])),_:1}),n(r(y),{slot:"end"},{default:u((()=>[n(r(c),{onClick:E},{default:u((()=>[p("Crear")])),_:1})])),_:1}),R.value?(d(),o(r(f),{key:0,type:"indeterminate"})):v("",!0)])),_:1})])),_:1}),n(r(_),null,{default:u((()=>[n(r(h),{inset:!0},{default:u((()=>[n(r(b),null,{default:u((()=>[n(r(M),{label:"Nombre del reporte","label-placement":"stacked",placeholder:"Nombre del reporte",modelValue:S.value.title,"onUpdate:modelValue":l[1]||(l[1]=e=>S.value.title=e),disabled:R.value},null,8,["modelValue","disabled"])])),_:1}),n(r(b),null,{default:u((()=>[n(r(g),{label:"Tipo de documento","label-placement":"stacked",interface:"action-sheet",modelValue:S.value.type,"onUpdate:modelValue":l[2]||(l[2]=e=>S.value.type=e),disabled:R.value},{default:u((()=>[n(r(D),{value:"Bill"},{default:u((()=>[p("Boletas")])),_:1}),n(r(D),{value:"Facture"},{default:u((()=>[p("Facturas")])),_:1})])),_:1},8,["modelValue","disabled"])])),_:1}),n(r(b),null,{default:u((()=>[n(r(k),{position:"stacked"},{default:u((()=>[p("Fecha de Inicio")])),_:1}),F(V("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":l[3]||(l[3]=e=>S.value.startDate=e),disabled:R.value},null,8,t),[[r(G)],[C,S.value.startDate]])])),_:1}),n(r(b),null,{default:u((()=>[n(r(k),{position:"stacked"},{default:u((()=>[p("Fecha de Término")])),_:1}),F(V("input",{class:"native-input sc-ion-input-ios","data-maska":"##/##/####","onUpdate:modelValue":l[4]||(l[4]=e=>S.value.endDate=e),disabled:R.value},null,8,J),[[r(G)],[C,S.value.endDate]])])),_:1})])),_:1})])),_:1})])),_:1}))}});e("default",a({__name:"Reports",setup(e){const t=l([]),a=l(!0),y=R(),c=l(null),f=async()=>{const e=await K.get("/reports");a.value=!1,t.value=e},v=e=>{y.push(`/reports/${e}`)},M=async()=>{H.show(P,{onLoaded(e){e.on("created",(e=>{const t=e.data.id;v(t),f()}))},modalControllerOptions:{presentingElement:c,showBackdrop:!0}})};return f(),(e,a)=>(d(),o(r(w),{ref_key:"page",ref:c},{default:u((()=>[n(r(s),null,{default:u((()=>[n(r(i),null,{default:u((()=>[n(r(m),null,{default:u((()=>[p("Mis Reportes")])),_:1})])),_:1})])),_:1}),n(r(_),null,{default:u((()=>[n(r(S),{slot:"fixed",vertical:"bottom",horizontal:"end",edge:!1},{default:u((()=>[n(r(E),{onClick:M},{default:u((()=>[n(r(j),{icon:r(B)},null,8,["icon"])])),_:1})])),_:1}),n(r(h),null,{default:u((()=>[(d(!0),I(N,null,U(t.value,(e=>(d(),o(r(b),{key:e.id,button:"",onClick:t=>v(e.id),detail:!0},{default:u((()=>[n(r(k),null,{default:u((()=>[V("h2",null,q(e.title),1),V("h3",null,q(e.status),1)])),_:2},1024)])),_:2},1032,["onClick"])))),128))])),_:1})])),_:1})])),_:1},512))}}))}}}));
