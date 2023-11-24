/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import DragDrop from"./dragdrop.js";import Editor from"./editor.js";import Modal from"./modal.js";export default class LayoutElements{constructor(e){this.main=e,this.main.debug,this.Config={newButtonID:"new-content",mainID:"layout-container",tokenSelector:'meta[name="csrfToken"]',elementSelector:".layout-element"},this.newButton=document.getElementById(this.Config.newButtonID),this.mainContainer=document.getElementById(this.Config.mainID),this.elements=document.querySelectorAll(this.Config.elementSelector),this.csrfToken=document.querySelector(this.Config.tokenSelector).getAttribute("content"),this.DragDrop=new DragDrop,this.newButton&&this.setup()}setup(){this.DragDrop.loadElements(this.elements,((e,t)=>this.setPosition(e,t))),this.newButton.addEventListener("click",(()=>this.newContent(this.newButton.dataset.url))),this.elements.forEach((e=>{new Element(this,e)}))}newContent(e){this.postFetch(e).then((e=>e.text())).then((e=>{let t=new Element(this,e);this.mainContainer.appendChild(t.nodeElement)}))}async updateContent(e,t,n,i={}){"save"==e&&(i=await n.get()),this.postFetch(t,i).then((e=>e.text())).then((t=>{if("update"==e){let e=new Element(this,t);this.mainContainer.insertBefore(e.nodeElement,n.nodeElement)}"delete"!=e&&"update"!=e||n.destroy()}))}setPosition(e,t){let n="/rhino/contents/update/"+e.id.replace("element-","");t<0&&(t=0),this.updateContent("move",n,e,{position:t})}async postFetch(e,t=""){return fetch(e,{method:"POST",headers:{Accept:"application/json","Content-Type":"application/json","X-CSRF-Token":this.csrfToken,"X-Requested-With":"XMLHttpRequest"},credentials:"same-origin",body:JSON.stringify(t)})}}class Element{constructor(e,t=null){this.elementHandler=e,this.fields=["element_id","html","media"],"object"==typeof t&&t.nodeType?this.nodeElement=t:"string"==typeof t&&(this.nodeElement=this.createElement(t)),this.html=this.nodeElement.querySelector("[name=html]"),this.media=this.nodeElement.querySelector("[name=media]"),this.select=this.nodeElement.querySelector("[name=element_id]"),this.id=this.nodeElement.dataset.id,this.position=this.nodeElement.dataset.position,this.elementHandler.DragDrop.addElement(this.nodeElement),this.initialize()}initialize(){this.saveButton=this.nodeElement.querySelector("[name=save]"),this.deleteButton=this.nodeElement.querySelector("[name=delete]"),this.toggleButton=this.nodeElement.querySelector("[name=toggle]"),this.moveHandle=this.nodeElement.querySelector("[name=move]"),this.select.addEventListener("change",(()=>this.elementHandler.updateContent("update",this.select.dataset.url,this,{element_id:this.select.value}))),this.saveButton.addEventListener("click",(()=>this.elementHandler.updateContent("save",this.saveButton.dataset.url,this))),this.toggleButton.addEventListener("change",(()=>this.elementHandler.updateContent("update",this.toggleButton.dataset.url,this,{active:!this.toggleButton.value}))),this.deleteButton.addEventListener("click",(()=>this.elementHandler.updateContent("delete",this.deleteButton.dataset.url,this))),this.moveHandle.addEventListener("mouseover",(()=>this.nodeElement.draggable=!0)),this.moveHandle.addEventListener("mouseout",(()=>this.nodeElement.draggable=!1)),this.nodeElement.addEventListener("keydown",(e=>{if(e.ctrlKey&&83===e.keyCode)return e.preventDefault(),this.elementHandler.updateContent("save",this.saveButton.dataset.url,this),!1})),this.addEditor(),this.addMedia()}createElement(e){let t=document.createElement("template");return t.innerHTML=e.trim(),t.content.firstChild}addEditor(){let e=this.nodeElement.querySelector(".editor");e&&(this.editor=new Editor(e,this.html.value))}addMedia(){let e=this.nodeElement.querySelector("[name=mediaButton]");if(!e)return;this.Modal||(this.Modal=new Modal(this));let t=this.Modal.newModal(e,!1);this.Modal.addQuery(t),e.addEventListener("click",(()=>{fetch(e.value).then((e=>e.text())).then((e=>{this.Modal.addContent(t,e),this.Modal.openModal(t)}))})),t.addEventListener("confirm",(e=>{let n=t.querySelector("input[type=radio]:checked");this.media.value=n.value,this.elementHandler.updateContent("update",this.select.dataset.url,this,{media:this.media.value})})),t.addEventListener("close",(e=>{this.Modal.reset(t)}))}async get(){if(this.editor){let e=await this.editor.save();this.html.value=JSON.stringify(e),this.html.innerHTML=this.html.value}let e={};return this.fields.forEach((t=>{let n=this.nodeElement.querySelector("[name="+t+"]");n&&(e[t]=n.value)})),e}destroy(){this.editor&&this.editor.destroy(),this.nodeElement.remove()}}