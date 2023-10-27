import Modal from "/rhino/js/modules/modal.js";
import LayoutElements from "/rhino/js/modules/elements.js";
// import EditorJS from "/rhino/js/vendor/editor.js";

class Layout {
	constructor() {
		window.onload = () => this.init();
	}
	
	init() {
		this.modal = new Modal();
		this.elements = new LayoutElements();
		this.elements.setModal(this.modal.modal);
	}
}

new Layout();
//# sourceMappingURL=layout.js.map