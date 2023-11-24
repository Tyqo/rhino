/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
export default class Editor{constructor(e,t){let o="";t.length>0&&(o=JSON.parse(t)),this.editor=new EditorJS({holder:e,tools:{header:{class:Header,inlineToolbar:["link"]},list:List},autofocus:!0,placeholder:"Let`s write an awesome story!",data:o,minHeight:0})}save(){return new Promise(((e,t)=>{this.editor.save().then((t=>{e(t)})).catch((e=>{t(e)}))}))}destroy(){this.editor.destroy()}}