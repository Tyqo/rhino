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
			layoutContainerSelector: '.layout-container, .layout-slot',
			elementSelector: '.layout-element'
		}

		this.Actions = {
			new: 	'/rhino/components/new/',
			update: '/rhino/components/update/',
			change: '/rhino/components/change/',
			delete: '/rhino/components/delete/',
		}

		this.containers = {};

		let layoutContainers = document.querySelector(this.Config.layoutContainerSelector);
		
		// this.DragDrop = new DragDrop();
			
		if (layoutContainers) {
			this.setup(document);
		}
	}
	
	/**
	 * setup
	 */
	setup(parentNode) {
		// this.DragDrop.loadElements(
		// 	this.elements,
		// 	(element, position) => this.setPosition(element, position)
		// );
		this.pageId = this.main.getPageId();

		this.newButtons = parentNode.querySelectorAll(this.Config.newButtonSelector);
		this.elements = parentNode.querySelectorAll(this.Config.elementSelector);
		this.layoutContainers = parentNode.querySelectorAll(this.Config.layoutContainerSelector);

		console.log(this.newButtons.length);

		this.layoutContainers.forEach(container => {
			this.containers[container.getAttribute('name')] = container;
		});

		this.newButtons.forEach(newButton => {
			newButton.addEventListener('click', () => {
				this.newComponent(newButton.value);
			});
		});

		this.elements.forEach(nodeElement => {
			new Component(this, nodeElement);
		});
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
				'X-CSRF-Token': this.main.getToken(),
				'X-Requested-With': 'XMLHttpRequest'
			},
			credentials: "same-origin",
			body: JSON.stringify(data)
		})
	}

	/**
	 * newComponent
	 * 
	 * @param {*} url 
	 * @param {*} name 
	 */
	newComponent(region) {
		let container = this.containers[region];
		
		this.postFetch(this.Actions.new, {
			region: region,
			parentId: container.getAttribute('value')
		}).then((response) => response.text())
			.then((html) => {
				let component = new Component(this, html);
				container.appendChild(component.element);

				this.setup(component.element);
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
			data = await element.getContent();
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
			// 'media',
		];

		if (typeof element == "object" && element.nodeType) {
			this.element = element;
		} else if (typeof element == "string") {
			this.element = this.createElement(element);
		}

		this.content = this.element.querySelector('[name=content]');
		this.select = this.element.querySelector('[name=template_id]');
		// this.media = this.element.querySelector('[name=media]');

		this.id = this.element.dataset.id;
		this.region = this.element.dataset.region;
		// this.position = this.element.dataset.position;

		// this.elementHandler.DragDrop.addElement(this.nodeElement);

		this.initialize();
	}

	/**
	 * initialize
	 * 
	 */
	initialize() {
		this.saveButton = this.element.querySelector('[name=save]');
		this.deleteButton = this.element.querySelector('[name=delete]');
		this.toggleButton = this.element.querySelector('[name=toggle]');
		this.moveHandle = this.element.querySelector('[name=move]');

		// this.select.addEventListener('change', () => this.elementHandler.updateContent(
		// 	'update',
		// 	this.select.dataset.url,
		// 	this,
		// 	{ element_id: this.select.value },
		// ));
		
		this.saveButton.addEventListener('click', () => this.update());
		this.deleteButton.addEventListener('click', () => this.delete());
		this.select.addEventListener('change', () => this.change({
			template_id: this.select.value
		}));

		// this.toggleButton.addEventListener('change', () => this.elementHandler.updateContent(
		// 	'update',
		// 	this.toggleButton.dataset.url,
		// 	this,
		// 	{ active: !this.toggleButton.value }
		// ));

		// this.moveHandle.addEventListener('mouseover', () => this.nodeElement.draggable = true);
		// this.moveHandle.addEventListener('mouseout', () => this.nodeElement.draggable = false);

		this.element.addEventListener('keydown', (e) => {
			if (e.ctrlKey && e.keyCode === 83) {
				e.preventDefault();
				this.update('save');
				return false;
			}
		});

		this.addEditor();
		this.addMedia();
	}


	async update() {
		let data = await this.getContent();
		data.id = this.id;

		this.Handler.postFetch(this.Handler.Actions.update, data);
	}

	async change(data) {
		data.id = this.id;

		this.Handler.postFetch(this.Handler.Actions.change, data)
			.then((response) => response.text())
			.then((html) => {
				let elementNew = new Component(this.Handler, html);
				this.element.parentElement.insertBefore(elementNew.element, this.element);
				this.destroy();

				this.Handler.setup(elementNew.element);
			});
	}

	async delete() {
		this.Handler.postFetch(this.Handler.Actions.delete, {
			id: this.id
		}).then((response) => response.text())
			.then((html) => {
				this.destroy();
			});
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
		let editorElement = this.element.querySelector('.editor');
		
		if (!editorElement) {
			return;
		}
		
		let parentElement = editorElement.closest('.layout-element');
		if (this.element.dataset.id != parentElement.dataset.id) {
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
		let mediaButton = this.element.querySelector('[name=mediaButton]');

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
	async getContent() {
		if (this.editor) {
			let editorData = await this.editor.save();
			this.content.value = JSON.stringify(editorData);
			this.content.innerHTML = this.content.value;
		}

		let data = {};

		this.fields.forEach(field => {
			let node = this.element.querySelector('[name=' + field + ']');
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
		this.element.remove();
	}
}