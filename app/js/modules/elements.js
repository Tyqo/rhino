import DragDrop from "./dragdrop.js";
import Editor from "./editor.js";
import Modal from "./modal.js";

/**
 * 
 */
export default class LayoutElements {
	/**
	 * 
	 * @param {*} main 
	 */
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("LayoutElements::const");
		}

		this.Config = {
			newButtonID: 'new-content',
			mainID: 'layout-container',
			tokenSelector: 'meta[name="csrfToken"]',
			elementSelector: '.layout-element'
		}

		this.newButton = document.getElementById(this.Config.newButtonID);
		this.mainContainer = document.getElementById(this.Config.mainID);
		this.elements = document.querySelectorAll(this.Config.elementSelector);
		this.csrfToken = document.querySelector(this.Config.tokenSelector).getAttribute('content');

		this.DragDrop = new DragDrop();
			
		if (this.newButton) {
			this.setup();
		}
	}
	
	setup() {
		this.DragDrop.loadElements(
			this.elements,
			(element, position) => this.setPosition(element, position)
		);

		this.newButton.addEventListener('click', () => this.newContent(this.newButton.dataset.url));
		this.elements.forEach(nodeElement => {
			new Element(this, nodeElement);
		});


	}

	newContent(url) {
		this.postFetch(url)
			.then((response) => response.text())
			.then((html) => {
				let element = new Element(this, html);
				this.mainContainer.appendChild(element.nodeElement);
			});
	}

	async updateContent(action, url, element, data = {}) {
		if (action == 'save') {
			data = await element.get();
		}

		this.postFetch(url, data)
		.then((response) => response.text())
		.then((html) => {
			if (action == 'update') {
				let elementNew = new Element(this, html);
				this.mainContainer.insertBefore(elementNew.nodeElement, element.nodeElement);
			}
			
			if (action == 'delete' || action == 'update') {
				element.destroy();
			}
		});
	}

	setPosition(element, position) {
		let id = element.id.replace('element-', '');
		let url = '/rhino/contents/update/' + id

		if (position < 0) {
			position = 0;
		}

		console.log(this);

		this.updateContent('move', url, element, { position: position });
	}

	async postFetch(url, data = '') {
		return fetch(url, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
				'X-CSRF-Token': this.csrfToken,
				'X-Requested-With': 'XMLHttpRequest'
			},
			credentials: "same-origin",
			body: JSON.stringify(data)
		})
	}
}

class Element {
	constructor(handler, element = null) {
		this.elementHandler = handler;

		this.fields = [
			'template_id',
			'content',
			'media',
		];

		if (typeof element == "object" && element.nodeType) {
			this.nodeElement = element;
		} else if (typeof element == "string") {
			this.nodeElement = this.createElement(element);
		}

		this.content = this.nodeElement.querySelector('[name=content]');
		this.media = this.nodeElement.querySelector('[name=media]');
		this.select = this.nodeElement.querySelector('[name=template_id]');

		this.id = this.nodeElement.dataset.id;
		this.position = this.nodeElement.dataset.position;

		this.elementHandler.DragDrop.addElement(this.nodeElement);

		this.initialize();
	}

	initialize() {		
		this.saveButton = this.nodeElement.querySelector('[name=save]');
		this.deleteButton = this.nodeElement.querySelector('[name=delete]');
		this.toggleButton = this.nodeElement.querySelector('[name=toggle]');
		this.moveHandle = this.nodeElement.querySelector('[name=move]');

		this.select.addEventListener('change', () => this.elementHandler.updateContent(
			'update',
			this.select.dataset.url,
			this,
			{ element_id: this.select.value },
		));

		this.saveButton.addEventListener('click', () => this.elementHandler.updateContent(
			'save',
			this.saveButton.dataset.url,
			this
		));

		this.toggleButton.addEventListener('change', () => this.elementHandler.updateContent(
			'update',
			this.toggleButton.dataset.url,
			this,
			{ active: !this.toggleButton.value }
		));

		this.deleteButton.addEventListener('click', () => this.elementHandler.updateContent(
			'delete',
			this.deleteButton.dataset.url,
			this
		));

		this.moveHandle.addEventListener('mouseover', () => this.nodeElement.draggable = true);
		this.moveHandle.addEventListener('mouseout', () => this.nodeElement.draggable = false);

		this.nodeElement.addEventListener('keydown', (e) => {
			if (e.ctrlKey && e.keyCode === 83) {
				e.preventDefault();

				this.elementHandler.updateContent(
					'save',
					this.saveButton.dataset.url,
					this
				);
				return false;
			}
		});

		this.addEditor();
		this.addMedia();
	}

	createElement(html) {
		let template = document.createElement('template');
		template.innerHTML = html.trim();

		let element = template.content.firstChild;
		return element;
	}

	addEditor() {
		let editorElement = this.nodeElement.querySelector('.editor');
		
		if (!editorElement) {
			return;
		}

		this.editor = new Editor(editorElement, this.content.value);
	}

	addMedia() {
		let mediaButton = this.nodeElement.querySelector('[name=mediaButton]');

		if (!mediaButton) {
			return;
		}

		if (!this.Modal) {
			this.Modal = new Modal(this);
		}

		let modal = this.Modal.newModal(mediaButton, false);
		this.Modal.addQuery(modal);
		
		mediaButton.addEventListener('click', () => {
			fetch(mediaButton.value)
				.then(response => response.text())
				.then(text => {
					this.Modal.addContent(modal, text);
					this.Modal.openModal(modal);
				});
		});

		modal.addEventListener('confirm', (e) => {
			let selected = modal.querySelector('input[type=radio]:checked');

			this.media.value = selected.value;

			console.log(this.media.value);

			this.elementHandler.updateContent(
				'update',
				this.select.dataset.url,
				this,
				{ media: this.media.value },
			);
		});

		modal.addEventListener('close', (e) => {
			this.Modal.reset(modal);
		});
	}

	async get() {
		if (this.editor) {
			let editorData = await this.editor.save();
			this.content.value = JSON.stringify(editorData);
			this.content.innerHTML = this.content.value;
		}

		let data = {};

		this.fields.forEach(field => {
			let node = this.nodeElement.querySelector('[name=' + field + ']');
			if (node) {
				data[field] = node.value;
			}
		});

		return data;
	}

	destroy() {
		if (this.editor) {
			this.editor.destroy();
		}
		this.nodeElement.remove();
	}
}