import DragDrop from "./dragdrop.js";
import Editor from "./editor.js";

export default class LayoutElements {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("LayoutElements::const");
		}

		this.DragDrop = new DragDrop();
		this.elements = document.querySelectorAll('.layout-element');
		this.DragDrop.loadElements(this.elements, this.setPosition);
	}

	setModal(modal) {
		modal.addEventListener('modalOpen', (event) => this.initForm(event));
		modal.addEventListener('modalClosed', (event) => this.onDispatch(event));
	}

	initForm(event) {
		if (this.main.debug) {
			console.debug("LayoutElements::initForm");
		}
		this.modal = event.detail;
		this.modalForm = this.modal.modalMain.querySelector('form');
		let switcher = document.getElementById('element-id');
		this.container = document.getElementById('elements-container');
		this.fetchElement(switcher.value);
		
		switcher.addEventListener('change', (event) => {
			this.fetchElement(event.target.value);
		})

		this.modalForm.addEventListener('submit', (event) => {
			event.preventDefault();
			let html = this.modalForm.querySelector('[name=html]');

			if (this.editor && html) {
				this.editor.save().then((data) => {
					html.value = JSON.stringify(data);
					this.editor.destroy();
					this.sendFrom(this.modalForm);
				});
			} else {
				this.sendFrom(this.modalForm);
			}
		})
	}

	fetchElement(elementId) {
		let url = this.container.dataset.request + '?';
		url += new URLSearchParams({
			layoutmode: true,
			elementId: elementId
		}).toString();
		fetch(url)
		.then(response => response.text())
		.then((element) => {
			console.log(element);
			this.container.innerHTML = element;

			let editor = document.getElementById('editor');
			if (editor) {
				let html = this.modalForm.querySelector('[name=html]');
				this.editor = new Editor('editor', html.value);
			} else {
				this.editor = null;
			}
		})
		.catch(err => console.log(err))
	}

	sendFrom(form) {
		fetch(form.getAttribute('action'), {
			method: 'POST',
			body: new FormData(form)
		})
		.then(response => response.json())
		.then((json) => {
			if (json.status != 200) {
				throw new Exception('something went wrong');
			}
			this.modal.closeModal();
		})
		.catch(err => console.log(err))
	}

	onDispatch(event) {
		if (this.main.debug) {
			console.debug("LayoutElements::dispatch");
		}

		let button = event.detail;
		this.element = button.parentNode.parentNode;
		let id = this.readId(this.element);

		if (!id) {
			window.location.reload();
		}

		fetch('/rhino/contents/element/' + id, {
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		}).then(response => response.text()).then(text => this.updateContent(text)).catch();
	}

	updateContent(content) {
		if (!content.length) {
			this.element.remove();
			return;
		}
		
		let container = this.element.querySelector('.element-container');
		if (container) {
			container.innerHTML = content;
		}
	}

	readId(element) {
		return element.id.replace('element-', '');
	}

	setPosition(element, position) {
		let id = element.id.replace('element-', '');

		if (position < 0) {
			position = 0;
		}

		fetch('/rhino/contents/change/' + id + "?" + new URLSearchParams({
			key: 'position',
			value: position
		}), {
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(json => console.log(json))
		.catch();
	}

}