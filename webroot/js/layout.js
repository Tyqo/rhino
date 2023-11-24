/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 24, 2023 3:57 PM ET
 * @release       f1fbadc834ac73776f5565c9500257c231e8b826 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutElements from"/rhino/js/modules/elements.js";class Layout{constructor(){this.debug=!0,window.onload=()=>this.init()}init(){this.elements=new LayoutElements(this)}}new Layout;