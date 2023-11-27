/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Mon, Nov 27, 2023 4:42 PM ET
 * @release       d6815068fe7f024f6df783c14f58618d57dda4e4 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Editor{constructor(e,t){let o="";t.length>0&&(o=JSON.parse(t)),this.editor=new EditorJS({holder:e,tools:{header:{class:Header,inlineToolbar:["link"]},list:List},autofocus:!0,placeholder:"Let`s write an awesome story!",data:o,minHeight:0})}save(){return new Promise(((e,t)=>{this.editor.save().then((t=>{e(t)})).catch((e=>{t(e)}))}))}destroy(){this.editor.destroy()}}