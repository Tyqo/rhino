import LayoutElements from "/rhino/js/modules/elements.js";
// import EditorJS from "/rhino/js/vendor/editor.js";

class Layout {
	constructor() {
		this.debug = true;
		window.onload = () => this.init();
	}
	
	init() {
		
		this.elements = new LayoutElements(this);
		// this.elements.setModal(this.LayoutModal.modal);
	}
}

new Layout();