import{d as C,r as m,c as i,w as e,u as a,R as w,o as l,a as t,b as g,e as k,a6 as b,h as v,g as p,i as y,j as B,I as x,l as U,H as N,L as D,K as L,f as P,F as V,G as O,k as S,y as T,m as F,s as H,v as r,N as u,ax as R,z as j}from"./index-575995aa.js";const A=C({__name:"Users",setup(q){const d=m(!0),f=m([]),h=async()=>{w.get("/users").then(n=>{f.value=n}).catch(n=>{console.log(n)}).finally(()=>{d.value=!1})},I=async n=>{const o=await R.create({header:"Opciones para "+n.name,buttons:[{text:"Borrar usuario",role:"destructive",data:{action:"deleteUser"}},{text:"Cambiar clave",data:{action:"changePassword"}},{text:"Cancelar",role:"cancel",data:{action:"cancel"}}]});await o.present();const{role:s,data:c}=await o.onDidDismiss();console.log(s,c),c.action=="changePassword"&&_()},_=async n=>{const o=await j.create({header:"Cambiar contraseña",inputs:[{type:"password",placeholder:"Nueva contraseña"}],buttons:[{text:"Cancelar",role:"cancel",handler:()=>{}},{text:"Cambiar contraseña",role:"confirm"}]});await o.present(),await o.onDidDismiss()};return h(),(n,o)=>(l(),i(a(T),null,{default:e(()=>[t(a(x),null,{default:e(()=>[t(a(g),null,{default:e(()=>[t(a(k),{slot:"start"},{default:e(()=>[t(a(b),{"default-href":"/"})]),_:1}),t(a(v),null,{default:e(()=>[p("Usuários")]),_:1}),d.value?(l(),i(a(y),{key:0,type:"indeterminate"})):B("",!0)]),_:1})]),_:1}),t(a(S),null,{default:e(()=>[t(a(U),null,{default:e(()=>[(l(!0),N(L,null,D(f.value,s=>(l(),i(a(F),{key:s.id,button:"",onClick:c=>I(s),detail:!0},{default:e(()=>[t(a(H),null,{default:e(()=>[r("h2",null,[r("b",null,u(s.name),1)]),r("h3",null,u(s.email),1),r("p",null,"Usuário: @"+u(s.username),1)]),_:2},1024)]),_:2},1032,["onClick"]))),128))]),_:1}),t(a(P),{onClick:n.addUser},{default:e(()=>[t(a(V),{icon:a(O)},null,8,["icon"]),p(" Nuevo usuario ")]),_:1},8,["onClick"])]),_:1})]),_:1}))}});export{A as default};
