(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{278:function(s,t,a){var e={"./af":73,"./af.js":73,"./ar":74,"./ar-dz":75,"./ar-dz.js":75,"./ar-kw":76,"./ar-kw.js":76,"./ar-ly":77,"./ar-ly.js":77,"./ar-ma":78,"./ar-ma.js":78,"./ar-sa":79,"./ar-sa.js":79,"./ar-tn":80,"./ar-tn.js":80,"./ar.js":74,"./az":81,"./az.js":81,"./be":82,"./be.js":82,"./bg":83,"./bg.js":83,"./bm":84,"./bm.js":84,"./bn":85,"./bn-bd":86,"./bn-bd.js":86,"./bn.js":85,"./bo":87,"./bo.js":87,"./br":88,"./br.js":88,"./bs":89,"./bs.js":89,"./ca":90,"./ca.js":90,"./cs":91,"./cs.js":91,"./cv":92,"./cv.js":92,"./cy":93,"./cy.js":93,"./da":94,"./da.js":94,"./de":95,"./de-at":96,"./de-at.js":96,"./de-ch":97,"./de-ch.js":97,"./de.js":95,"./dv":98,"./dv.js":98,"./el":99,"./el.js":99,"./en-au":100,"./en-au.js":100,"./en-ca":101,"./en-ca.js":101,"./en-gb":102,"./en-gb.js":102,"./en-ie":103,"./en-ie.js":103,"./en-il":104,"./en-il.js":104,"./en-in":105,"./en-in.js":105,"./en-nz":106,"./en-nz.js":106,"./en-sg":107,"./en-sg.js":107,"./eo":108,"./eo.js":108,"./es":109,"./es-do":110,"./es-do.js":110,"./es-mx":111,"./es-mx.js":111,"./es-us":112,"./es-us.js":112,"./es.js":109,"./et":113,"./et.js":113,"./eu":114,"./eu.js":114,"./fa":115,"./fa.js":115,"./fi":116,"./fi.js":116,"./fil":117,"./fil.js":117,"./fo":118,"./fo.js":118,"./fr":119,"./fr-ca":120,"./fr-ca.js":120,"./fr-ch":121,"./fr-ch.js":121,"./fr.js":119,"./fy":122,"./fy.js":122,"./ga":123,"./ga.js":123,"./gd":124,"./gd.js":124,"./gl":125,"./gl.js":125,"./gom-deva":126,"./gom-deva.js":126,"./gom-latn":127,"./gom-latn.js":127,"./gu":128,"./gu.js":128,"./he":129,"./he.js":129,"./hi":130,"./hi.js":130,"./hr":131,"./hr.js":131,"./hu":132,"./hu.js":132,"./hy-am":133,"./hy-am.js":133,"./id":134,"./id.js":134,"./is":135,"./is.js":135,"./it":136,"./it-ch":137,"./it-ch.js":137,"./it.js":136,"./ja":138,"./ja.js":138,"./jv":139,"./jv.js":139,"./ka":140,"./ka.js":140,"./kk":141,"./kk.js":141,"./km":142,"./km.js":142,"./kn":143,"./kn.js":143,"./ko":144,"./ko.js":144,"./ku":145,"./ku.js":145,"./ky":146,"./ky.js":146,"./lb":147,"./lb.js":147,"./lo":148,"./lo.js":148,"./lt":149,"./lt.js":149,"./lv":150,"./lv.js":150,"./me":151,"./me.js":151,"./mi":152,"./mi.js":152,"./mk":153,"./mk.js":153,"./ml":154,"./ml.js":154,"./mn":155,"./mn.js":155,"./mr":156,"./mr.js":156,"./ms":157,"./ms-my":158,"./ms-my.js":158,"./ms.js":157,"./mt":159,"./mt.js":159,"./my":160,"./my.js":160,"./nb":161,"./nb.js":161,"./ne":162,"./ne.js":162,"./nl":163,"./nl-be":164,"./nl-be.js":164,"./nl.js":163,"./nn":165,"./nn.js":165,"./oc-lnc":166,"./oc-lnc.js":166,"./pa-in":167,"./pa-in.js":167,"./pl":168,"./pl.js":168,"./pt":169,"./pt-br":170,"./pt-br.js":170,"./pt.js":169,"./ro":171,"./ro.js":171,"./ru":172,"./ru.js":172,"./sd":173,"./sd.js":173,"./se":174,"./se.js":174,"./si":175,"./si.js":175,"./sk":176,"./sk.js":176,"./sl":177,"./sl.js":177,"./sq":178,"./sq.js":178,"./sr":179,"./sr-cyrl":180,"./sr-cyrl.js":180,"./sr.js":179,"./ss":181,"./ss.js":181,"./sv":182,"./sv.js":182,"./sw":183,"./sw.js":183,"./ta":184,"./ta.js":184,"./te":185,"./te.js":185,"./tet":186,"./tet.js":186,"./tg":187,"./tg.js":187,"./th":188,"./th.js":188,"./tk":189,"./tk.js":189,"./tl-ph":190,"./tl-ph.js":190,"./tlh":191,"./tlh.js":191,"./tr":192,"./tr.js":192,"./tzl":193,"./tzl.js":193,"./tzm":194,"./tzm-latn":195,"./tzm-latn.js":195,"./tzm.js":194,"./ug-cn":196,"./ug-cn.js":196,"./uk":197,"./uk.js":197,"./ur":198,"./ur.js":198,"./uz":199,"./uz-latn":200,"./uz-latn.js":200,"./uz.js":199,"./vi":201,"./vi.js":201,"./x-pseudo":202,"./x-pseudo.js":202,"./yo":203,"./yo.js":203,"./zh-cn":204,"./zh-cn.js":204,"./zh-hk":205,"./zh-hk.js":205,"./zh-mo":206,"./zh-mo.js":206,"./zh-tw":207,"./zh-tw.js":207};function r(s){var t=n(s);return a(t)}function n(s){if(!a.o(e,s)){var t=new Error("Cannot find module '"+s+"'");throw t.code="MODULE_NOT_FOUND",t}return e[s]}r.keys=function(){return Object.keys(e)},r.resolve=n,s.exports=r,r.id=278},448:function(s,t,a){"use strict";a.r(t);var e={extends:a(209).a,data:function(){return{chartData:{labels:["Italy","India","Japan","USA"],datasets:[{borderWidth:1,borderColor:["rgba(255,99,132,1)","rgba(54, 162, 235, 1)","rgba(255, 206, 86, 1)","rgba(75, 192, 192, 1)"],backgroundColor:["rgba(255, 99, 132, 0.2)","rgba(54, 162, 235, 0.2)","rgba(255, 206, 86, 0.2)","rgba(75, 192, 192, 0.2)"],data:[1e3,500,1500,1e3]}]},options:{legend:{display:!0},responsive:!0,maintainAspectRatio:!1}}},mounted:function(){this.renderChart(this.chartData,this.options)},created:function(){var s=this;this.$http.post("".concat(this.url,"/v1/pie")).then((function(t){s.chartData.labels.splice(0),s.chartData.datasets[0].borderColor.splice(0),s.chartData.datasets[0].backgroundColor.splice(0),s.chartData.datasets[0].data.splice(0),s.chartData.labels=t.data.labels;for(var a=[],e=0;e<s.chartData.labels.length;e++)a.push(s.random_bg_color());s.chartData.datasets[0].borderColor=a,s.chartData.datasets[0].backgroundColor=a,s.chartData.datasets[0].data=t.data.data,s.renderChart(s.chartData,s.options)})).catch((function(s){console.log(s)}))},methods:{random_bg_color:function(){return"rgb("+Math.floor(256*Math.random())+","+Math.floor(256*Math.random())+","+Math.floor(256*Math.random())+")"}}},r=a(4),n={data:function(){return{tbldata:[],bread_items:[{text:"DashBoard",disabled:!0,href:"breadcrumbs_dashboard"}]}},created:function(){this.getData()},methods:{getData:function(){var s=this;this.$http.post("".concat(this.url,"/v1/dashboard")).then((function(t){var a=t.data.message;s.tbldata.splice(0);for(var e=0;e<a.length;e++)s.tbldata.push(a[e])})).catch((function(s){console.log(s)}))}},components:{PieChart:Object(r.a)(e,void 0,void 0,!1,null,null,null).exports}},o=Object(r.a)(n,(function(){var s=this,t=s.$createElement,a=s._self._c||t;return a("v-container",[a("v-row",[a("v-col",{staticClass:"d-flex flex-row mb-6"},[a("h2",[s._v("Dashboard")])]),s._v(" "),a("v-breadcrumbs",{attrs:{items:s.bread_items},scopedSlots:s._u([{key:"divider",fn:function(){return[a("v-icon",[s._v("mdi-chevron-right")])]},proxy:!0}])})],1),s._v(" "),a("v-row",[a("v-col",[a("v-spacer"),s._v(" "),a("v-card",{attrs:{outlined:"",height:"300px"}},[a("v-simple-table",{staticClass:"mr-5 ml-5 mt-5",attrs:{id:"mytable","fixed-header":"",dense:"",stripe:"",height:"250px"},scopedSlots:s._u([{key:"default",fn:function(){return[a("thead",[a("tr",[a("th",{staticClass:"text-left"},[s._v("Expense Categories")]),s._v(" "),a("th",{staticClass:"text-left"},[s._v("Total")])])]),s._v(" "),a("tbody",s._l(s.tbldata,(function(t,e){return a("tr",{key:e},[a("td",[s._v(s._s(s.tbldata[e].category_name))]),s._v(" "),a("td",[s._v("$"+s._s(s.tbldata[e].total_amount))])])})),0)]},proxy:!0}])})],1)],1),s._v(" "),a("v-col",[a("pie-chart")],1)],1)],1)}),[],!1,null,null,null);t.default=o.exports}}]);