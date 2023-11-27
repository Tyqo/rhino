/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Mon, Nov 27, 2023 4:42 PM ET
 * @release       d6815068fe7f024f6df783c14f58618d57dda4e4 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutElements from"/rhino/js/modules/elements.js";class Layout{constructor(){this.debug=!0,window.addEventListener("load",(t=>{this.init()}))}init(){this.elements=new LayoutElements(this)}}new Layout;