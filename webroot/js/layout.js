/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Wed, Jan 10, 2024 4:53 PM ET
 * @release       f39df71e611dee1cda1bc6540ca6aa0707b9a278 [page-tree]
 * @copyright     Copyright (c) 2024, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutComponents from"/rhino/js/modules/components.js";class Layout{constructor(){this.debug=!0,window.addEventListener("load",(t=>{this.init()}))}init(){this.Components=new LayoutComponents(this)}getToken(){return document.querySelector('meta[name="csrfToken"]').getAttribute("content")}getPageId(){return document.querySelector('meta[name="pageId"]').getAttribute("content")}}new Layout;