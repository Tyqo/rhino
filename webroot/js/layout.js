/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 17, 2023 11:38 AM ET
 * @release       dbdb08c537d79b75d2c22f821df556a03d0ba35c [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutModal from"/rhino/js/modules/layoutModal.js";import LayoutElements from"/rhino/js/modules/elements.js";class Layout{constructor(){this.debug=!0,window.onload=()=>this.init()}init(){this.LayoutModal=new LayoutModal(this),this.elements=new LayoutElements(this),this.elements.setModal(this.LayoutModal.modal)}}new Layout;