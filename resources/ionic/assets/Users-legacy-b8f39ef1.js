System.register(["./index-legacy-78cb82a4.js"],(function(e,a){"use strict";var t,l,n,s,r,u,o,c,i,d,f,m,h,_,p,y,v,w,C,b,g,x,k,U,D,N,j,P,z,B,F;return{setters:[e=>{t=e.d,l=e.r,n=e.c,s=e.w,r=e.u,u=e.R,o=e.o,c=e.a,i=e.b,d=e.e,f=e.a6,m=e.h,h=e.g,_=e.i,p=e.j,y=e.I,v=e.l,w=e.H,C=e.L,b=e.K,g=e.f,x=e.F,k=e.G,U=e.k,D=e.y,N=e.m,j=e.s,P=e.v,z=e.N,B=e.ax,F=e.z}],execute:function(){e("default",t({__name:"Users",setup(e){const a=l(!0),t=l([]),G=async e=>{const a=await F.create({header:"Cambiar contraseña",inputs:[{type:"password",placeholder:"Nueva contraseña"}],buttons:[{text:"Cancelar",role:"cancel",handler:()=>{}},{text:"Cambiar contraseña",role:"confirm"}]});await a.present(),await a.onDidDismiss()};return(async()=>{u.get("/users").then((e=>{t.value=e})).catch((e=>{console.log(e)})).finally((()=>{a.value=!1}))})(),(e,l)=>(o(),n(r(D),null,{default:s((()=>[c(r(y),null,{default:s((()=>[c(r(i),null,{default:s((()=>[c(r(d),{slot:"start"},{default:s((()=>[c(r(f),{"default-href":"/"})])),_:1}),c(r(m),null,{default:s((()=>[h("Usuários")])),_:1}),a.value?(o(),n(r(_),{key:0,type:"indeterminate"})):p("",!0)])),_:1})])),_:1}),c(r(U),null,{default:s((()=>[c(r(v),null,{default:s((()=>[(o(!0),w(b,null,C(t.value,(e=>(o(),n(r(N),{key:e.id,button:"",onClick:a=>(async e=>{const a=await B.create({header:"Opciones para "+e.name,buttons:[{text:"Borrar usuario",role:"destructive",data:{action:"deleteUser"}},{text:"Cambiar clave",data:{action:"changePassword"}},{text:"Cancelar",role:"cancel",data:{action:"cancel"}}]});await a.present();const{role:t,data:l}=await a.onDidDismiss();console.log(t,l),"changePassword"==l.action&&G()})(e),detail:!0},{default:s((()=>[c(r(j),null,{default:s((()=>[P("h2",null,[P("b",null,z(e.name),1)]),P("h3",null,z(e.email),1),P("p",null,"Usuário: @"+z(e.username),1)])),_:2},1024)])),_:2},1032,["onClick"])))),128))])),_:1}),c(r(g),{onClick:e.addUser},{default:s((()=>[c(r(x),{icon:r(k)},null,8,["icon"]),h(" Nuevo usuario ")])),_:1},8,["onClick"])])),_:1})])),_:1}))}}))}}}));
