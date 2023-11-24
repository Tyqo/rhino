/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:49 PM ET
 * @release       621832333ab48a5893da21f81678e52e712626a5 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutElements from"/rhino/js/modules/elements.js";class Layout{constructor(){this.debug=!0,window.onload=()=>this.init()}init(){this.elements=new LayoutElements(this)}}new Layout;