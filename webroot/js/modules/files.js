/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Mon, Nov 27, 2023 4:42 PM ET
 * @release       d6815068fe7f024f6df783c14f58618d57dda4e4 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Files{constructor(e){this.main=e,this.Modal=e.Modal,this.main.debug,this.buttons=document.querySelectorAll("[type=directory]"),this.buttons.length>0&&this.init()}init(){this.buttons.forEach((e=>{let t=this.Modal.newModal(e,!1);this.Modal.addQuery(t);let a=document.getElementById(e.name),n=document.querySelector("input[name="+e.name+"_file]");n&&n.addEventListener("change",(e=>{let t=n.files,d=[];for(var l=0;l<t.length;l++){var i=t[l].name.replace(/^.*[\\/]/,"");d.push(i)}a.value=d.join(", ")})),t.addEventListener("confirm",(e=>{let n=t.querySelector("input[type=radio]:checked");a.value=n.value})),t.addEventListener("close",(e=>{this.Modal.reset(t)})),e.addEventListener("click",(a=>{a.preventDefault();let n=e.value+"?";n+=new URLSearchParams({modal:!0,dir:e.dataset.dir,types:e.dataset.types}),fetch(n,{headers:{"X-Requested-With":"XMLHttpRequest"}}).then((e=>e.text())).then((e=>{this.Modal.addContent(t,e),this.Modal.openModal(t)})).catch((e=>{}))}))}))}}