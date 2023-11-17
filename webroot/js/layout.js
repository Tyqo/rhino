/**
 * @project       tusk
 * @author        carsten.coull@swu.de
 * @build         Fri, Nov 17, 2023 2:55 PM ET
 * @release       a433e330c30db45ed9eaf70ee5d4ebbf88e92350 [main]
 * @copyright     Copyright (c) 2023, SWU Stadtwerke Ulm / Neu-Ulm GmbH
 *
 */
import LayoutModal from"/rhino/js/modules/layoutModal.js";import LayoutElements from"/rhino/js/modules/elements.js";class Layout{constructor(){this.debug=!0,window.onload=()=>this.init()}init(){this.LayoutModal=new LayoutModal(this),this.elements=new LayoutElements(this),this.elements.setModal(this.LayoutModal.modal)}}new Layout;