import{u as w,a as $,r as m,o as B,b as g,c as a,d as o,e,F as f,f as y,g as C,w as D,t as d}from"./app-Dp8iK4W1.js";const F={class:"app__home"},I={class:"container"},M={class:"app__home-inner"},N=e("h1",{class:"title"},"Тестирование",-1),S={key:0,class:"app__home-tests"},T=["onClick"],V={class:"app__home-info"},b=e("h2",{class:"title"},"Последние результаты",-1),A={style:{display:"flex",gap:"10px"}},L={__name:"AppHome",setup(E){const i=w(),k=$(),r=m([]),_=m([]),x=n=>{k.push({name:"Test",params:{id:n}})};return B(async()=>{var s,l,u,p,h,v;const n=i.state.user.group_id,c=i.state.user.id;try{const t=await g.get(`/api/testschedules/group/${n}/${c}`);r.value=((l=(s=t.data)==null?void 0:s.data)==null?void 0:l.data)||((u=t.data)==null?void 0:u.data)||t.data}catch(t){console.log(t)}try{const t=await g.get(`api/testschedules/res/${c}`);_.value=((h=(p=t.data)==null?void 0:p.data)==null?void 0:h.data)||((v=t.data)==null?void 0:v.data)||t.data}catch(t){console.log(t)}}),(n,c)=>(a(),o("div",F,[e("div",I,[e("div",M,[N,r.value.length?(a(),o("div",S,[(a(!0),o(f,null,y(r.value,s=>(a(),o("div",{key:s.id,class:"app__home-tests__item hover",onClick:D(l=>x(s.test.id),["prevent"])},d(s.test.title),9,T))),128))])):C("",!0),e("div",V,[b,(a(!0),o(f,null,y(_.value,s=>(a(),o("div",A,[e("p",null,d(s.test_title),1),e("p",null,d(s.total_points),1)]))),256))])])])]))}};export{L as default};