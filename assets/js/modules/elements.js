import DragDrop from "./dragdrop.js";
import Editor from "./editor.js";

export default class LayoutElements {
	constructor() {
		this.DragDrop = new DragDrop();
		this.elements = document.querySelectorAll('.layout-element');
		this.DragDrop.loadElements(this.elements, this.setPosition);
	}

	setModal(modal) {
		modal.addEventListener('modalOpen', (event) => this.initForm(event));
		modal.addEventListener('modalClosed', (event) => this.onDispatch(event));
	}

	initForm(event) {
		this.modal = event.detail;
		let form = this.modal.modalMain.querySelector('form');
		let html = form.querySelector('[name=html]');

		if (html) {
			this.editor = new Editor('editor', html.value);
		} else {
			this.editor = null;
		}

		form.addEventListener('submit', (event) => {
			event.preventDefault();

			if (this.editor) {
				this.editor.save().then((data) => {
					html.value = JSON.stringify(data);
					this.editor.destroy();
					this.sendFrom(form);
				});
			} else {
				this.sendFrom(form);
			}
		})
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
		let button = event.detail;
		this.element = button.parentNode.parentNode;
		let id = this.readId(this.element);

		if (!id) {
			window.location.reload();
		}

		fetch('/tusk/contents/element/' + id, {
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

		fetch('/tusk/contents/change/' + id + "?" + new URLSearchParams({
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