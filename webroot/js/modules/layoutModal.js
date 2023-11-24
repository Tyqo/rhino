/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class LayoutModal{constructor(){this.modal=document.createElement("dialog"),this.modalHeader=document.createElement("header"),this.headline=document.createElement("p"),this.closeButton=document.createElement("button"),this.modalMain=document.createElement("main"),this.cross='<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">\x3c!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc.--\x3e<path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25-6.2 6.25-14.4 9.35-22.6 9.35s-16.38-3.125-22.62-9.375L160 301.3 54.63 406.6C48.38 412.9 40.19 416 32 416s-16.37-3.1-22.625-9.4c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" /></svg>',this.addModal(),this.init()}init(){this.closeButton.addEventListener("click",(()=>this.closeModal())),document.addEventListener("keydown",(t=>{"Escape"==t.key&&this.closeModal()}));document.querySelectorAll(".open-modal").forEach((t=>t.addEventListener("click",(t=>{this.button=t.target,this.openModal(t)}))))}addModal(){this.closeButton.id="close-modal",this.closeButton.innerHTML=this.cross,this.modalHeader.classList.add("modal-header"),this.modalHeader.appendChild(this.headline),this.modalHeader.appendChild(this.closeButton),this.modalMain.classList.add("modal-main"),this.modal.classList.add("modal"),this.modal.setAttribute("closed",!0),this.modal.appendChild(this.modalHeader),this.modal.appendChild(this.modalMain),document.body.appendChild(this.modal)}closeModal(){this.modal.close(),this.modalMain.innerHTML="";let t=this.button.getAttribute("data-dispatch"),e=new CustomEvent("modalClosed",{detail:this.button});t&&this.modal.dispatchEvent(e)}openModal(t){let e=t.target;this.headline.innerHTML=e.name,this.modal.showModal(),fetch(e.value,{headers:{"X-Requested-With":"XMLHttpRequest"}}).then((t=>t.text())).then((t=>this.initModal(t))).catch((t=>{}))}initModal(t){this.modalMain.innerHTML=t;let e=new CustomEvent("modalOpen",{detail:this});this.modal.dispatchEvent(e)}}