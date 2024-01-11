export default class Modal {

	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("Modal::const");
		}

		this.Conf = {
			isOpenClass: "modal-is-open",
			openingClass: "modal-is-opening",
			closingClass: "modal-is-closing",
			animationDuration: 400
		};

		this.visibleModal = null;

		this.buttons = document.querySelectorAll('[data-target]');
		if (this.buttons.length > 0) {
			this.init();
		}
	}

	init() {
		this.buttons.forEach(button => {
			let target = document.getElementById(button.dataset.target);
			this.initButton(button, target);		
		});
	}

	initButton(button, target) {
		if (target == null) {
			let modal = this.newModal(button);
			this.addContent(modal, button.dataset.modal);
			this.addQuery(modal);
			modal.addEventListener('confirm', () => {
				let form = modal.querySelector('form');
				if (form) {
					form.submit();
				}
			});
		} else if (target.tagName == 'DIALOG') {
			button.addEventListener('click', (event) => {
				if (button.ariaLabel == 'Close') {
					let event = new Event('cancel');
					target.dispatchEvent(event);
				}
				this.toggleModal(event, target);
			});
		} else if (target.tagName == 'FORM') {
			let modal = this.newModal(button);
			this.addContent(modal, button.dataset.modal);
			this.addQuery(modal);
			modal.addEventListener('confirm', () => {
				target.submit();				
			});
		}
	}

	toggleModal(event, target) {
		event.preventDefault();
		if (this.isModalOpen(target)) {
			this.closeModal(target);
		} else {
			this.openModal(target);
		}
	}

	isModalOpen(modal) {
		return !(!modal.hasAttribute("open") || "false" == modal.getAttribute("open"));
	}

	openModal(modal) {
		this.visibleModal = modal;

		let event = new CustomEvent("open", {
			detail: this.button,
		});
		modal.dispatchEvent(event);

		modal.showModal();
	}

	closeModal(modal) {
		this.visibleModal = null;

		modal.close();
	}

	newModal(button, openOnclick = true) {
		let target = button.dataset.target;
		if (target == null) {
			target = button.name;
			button.dataset.target = target;
		}

		let modal = document.createElement('dialog');
		let modalInner = document.createElement('article');
		let modalMain = document.createElement('main');
		let closeButton = document.createElement('button');

		modal.id = target;

		closeButton.classList.add('close', 'button', 'outline', 'contrast');
		closeButton.ariaLabel = 'Close';
		closeButton.dataset.target = target;

		modalInner.appendChild(closeButton);
		modalInner.appendChild(modalMain);
		modal.appendChild(modalInner);
		document.body.appendChild(modal);
		
		this.initButton(closeButton, modal);

		if (openOnclick) {
			this.initButton(button, modal);
		}

		return modal;
	}

	addContent(modal, content) {
		modal.querySelector('main').innerHTML = content;
	}

	addQuery(modal, conf = {cancel: true, confirm: true}) {
		let modalInner = modal.querySelector('article');
		let container = document.createElement('footer');
		
		if (conf.cancel) {
			let cancel = document.createElement('button');
			cancel.innerText = 'cancel';
			cancel.classList.add('contrast');
			container.appendChild(cancel);
			cancel.addEventListener('click', () => {
				let event = new Event('cancel');
				modal.dispatchEvent(event);
				this.closeModal(modal);
			});
		}

		if (conf.confirm) {
			let confirm = document.createElement('button');
			confirm.innerText = 'confirm';
			container.appendChild(confirm);
			confirm.addEventListener('click', () => {
				let event = new Event('confirm');
				modal.dispatchEvent(event);
				this.closeModal(modal);
			});
		}
		
		modalInner.appendChild(container);
	}

	reset(modal) {
		this.addContent(modal, '');
	}
}
//# sourceMappingURL=modal.js.map