/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 17, 2023 2:55 PM ET
 * @release       a433e330c30db45ed9eaf70ee5d4ebbf88e92350 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Editor{constructor(e,t){let o="";t.length>0&&(o=JSON.parse(t)),this.editor=new EditorJS({holder:e,tools:{header:{class:Header,inlineToolbar:["link"]},list:List},autofocus:!0,placeholder:"Let`s write an awesome story!",data:o,minHeight:0})}save(){return new Promise(((e,t)=>{this.editor.save().then((t=>{e(t)})).catch((e=>{t(e)}))}))}destroy(){this.editor.destroy()}}