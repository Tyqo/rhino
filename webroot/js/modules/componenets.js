// import DragDrop from "./dragdrop.js";
import Editor from "./editor.js";
import Modal from "./modal.js";

/**
 * 
 */
export default class LayoutComponents {
	/**
	 * 
	 * @param {*} main 
	 */
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("LayoutComponents::const");
		}

		this.Config = {
			newButtonSelector: 'button[name=new-component]',
			layoutContainerSelector: '.layout-container',
			elementSelector: '.layout-element'
		}

		this.Actions = {
			new: 	'/rhino/components/new/',
			update: '/rhino/components/update/',
			delete: '/rhino/components/delete/',
		}

		this.containers = [];

		this.layoutContainers = document.querySelectorAll(this.Config.layoutContainerSelector);
		
		// this.DragDrop = new DragDrop();
			
		if (this.layoutContainers.length) {
			this.setup();
		}
	}
	
	/**
	 * setup
	 */
	setup() {
		// this.DragDrop.loadElements(
		// 	this.elements,
		// 	(element, position) => this.setPosition(element, position)
		// );

		this.newButtons = document.querySelectorAll(this.Config.newButtonSelector);
		this.elements = document.querySelectorAll(this.Config.elementSelector);

		this.layoutContainers.forEach(container => {
			this.containers.push(container.name, container);
		});

		console.log(this.containers);

		this.newButtons.forEach(newButton => {
			newButton.addEventListener('click', () => {
				this.newContent(newButton.dataset.url, newButton.value);
			});
		});

		this.elements.forEach(nodeElement => {
			new Element(this, nodeElement);
		});
	}

	/**
	 * newComponent
	 * 
	 * @param {*} url 
	 * @param {*} name 
	 */
	newComponent(url, name) {
		this.postFetch(url)
			.then((response) => response.text())
			.then((html) => {
				let component = new Component(this, html);
				let container = document.querySelector(this.Config.layoutContainerSelector + "[name=" + name + "]");
				container.appendChild(component.element);
			});
	}

	/**
	 * updateContent
	 * 
	 * @param {*} action 
	 * @param {*} url 
	 * @param {*} element 
	 * @param {*} data 
	 */
	async updateContent(action, url, element, data = {}) {
		if (action == 'save') {
			data = await element.get();
		}

		this.postFetch(url, data)
			.then((response) => response.text())
			.then((html) => {
				if (action == 'update') {
					let elementNew = new Element(this, html);
					element.container.insertBefore(elementNew.nodeElement, element.nodeElement);
				}
				
				if (action == 'delete' || action == 'update') {
					element.destroy();
				}
			});
	}

	/**
	 * setPosition (Depricated)
	 * 
	 * @param {*} element 
	 * @param {*} position 
	 */
	setPosition(element, position) {
		let id = element.id.replace('element-', '');
		let url = '/rhino/contents/update/' + id

		if (position < 0) {
			position = 0;
		}

		this.updateContent('move', url, element, { position: position });
	}

	/**
	 * postFetch
	 * 
	 * @param {*} url 
	 * @param {*} data 
	 * @returns 
	 */
	async postFetch(url, data = '') {
		return fetch(url, {
			method: 'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
				'X-CSRF-Token': this.main.getToken,
				'X-Requested-With': 'XMLHttpRequest'
			},
			credentials: "same-origin",
			body: JSON.stringify(data)
		})
	}
}


/**
 * Component
 * 
 */
class Component {
	/**
	 * 
	 * @param {*} handler 
	 * @param {*} element 
	 */
	constructor(handler, element = null) {
		this.Handler = handler;

		this.fields = [
			'template_id',
			'content',
			'media',
		];

		if (typeof element == "object" && element.nodeType) {
			this.element = element;
		} else if (typeof element == "string") {
			this.element = this.createElement(element);
		}

		this.content = this.element.querySelector('[name=content]');
		this.media = this.element.querySelector('[name=media]');
		this.select = this.element.querySelector('[name=template_id]');

		this.id = this.element.dataset.id;
		this.position = this.element.dataset.position;

		// this.elementHandler.DragDrop.addElement(this.nodeElement);

		this.initialize();
	}

	/**
	 * initialize
	 * 
	 */
	initialize() {
		this.container = this.nodeElement.parentElement;

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

	/**
	 * createElement
	 * 
	 * @param {*} html 
	 * @returns 
	 */
	createElement(html) {
		let template = document.createElement('template');
		template.innerHTML = html.trim();

		let element = template.content.firstChild;
		return element;
	}

	/**
	 * addEditor
	 * 
	 * @returns 
	 */
	addEditor() {
		let editorElement = this.nodeElement.querySelector('.editor');
		
		if (!editorElement) {
			return;
		}

		this.editor = new Editor(editorElement, this.content.value);
	}

	/**
	 * addMedia
	 * 
	 * @returns 
	 */
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

	/**
	 * get
	 * 
	 * @returns 
	 */
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

	/**
	 * destroy
	 */
	destroy() {
		if (this.editor) {
			this.editor.destroy();
		}
		this.nodeElement.remove();
	}
}
//# sourceMappingURL=componenets.js.map