import Modal from "/rhno/js/modules/modal.js";
import LayoutElements from "/rhno/js/modules/elements.js";
// import EditorJS from "/rhno/js/vendor/editor.js";

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