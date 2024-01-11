import LayoutComponents from "/rhino/js/modules/components.js";
// import EditorJS from "/rhino/js/vendor/editor.js";

class Layout {
	constructor() {
		this.debug = true;
		window.addEventListener("load", (event) => {
			this.init();
		});
	}
	
	init() {
		this.Components = new LayoutComponents(this);
		// this.elements.setModal(this.LayoutModal.modal);
	}

	getToken() {
		return document.querySelector('meta[name="csrfToken"]').getAttribute('content');
	}

	getPageId() {
		return document.querySelector('meta[name="pageId"]').getAttribute('content');
	}
}

new Layout();
//# sourceMappingURL=layout.js.map