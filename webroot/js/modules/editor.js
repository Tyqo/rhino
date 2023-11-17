/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 17, 2023 11:38 AM ET
 * @release       dbdb08c537d79b75d2c22f821df556a03d0ba35c [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Editor{constructor(e,t){let o="";t.length>0&&(o=JSON.parse(t)),this.editor=new EditorJS({holder:e,tools:{header:{class:Header,inlineToolbar:["link"]},list:List},autofocus:!0,placeholder:"Let`s write an awesome story!",data:o,minHeight:0})}save(){return new Promise(((e,t)=>{this.editor.save().then((t=>{e(t)})).catch((e=>{t(e)}))}))}destroy(){this.editor.destroy()}}