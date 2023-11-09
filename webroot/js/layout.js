import Modal from "/rhino/js/modules/modal.js";
import LayoutElements from "/rhino/js/modules/elements.js";
// import EditorJS from "/rhino/js/vendor/editor.js";

class Layout {
	constructor() {
		this.debug = false;
		window.onload = () => this.init();
	}
	
	init() {
		this.Modal = new Modal(this);
		this.elements = new LayoutElements();
		// this.elements.setModal(this.Modal.modal);
	}
}

new Layout();
//# sourceMappingURL=layout.js.map