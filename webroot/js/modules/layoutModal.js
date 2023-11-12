export default class LayoutModal {
	constructor() {
		this.modal = document.createElement('dialog');
		// this.modalWrapper = document.createElement('div');
		this.modalHeader = document.createElement('header');
		this.headline = document.createElement('p');
		this.closeButton = document.createElement('button');
		this.modalMain = document.createElement('main');
		this.cross = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc.--><path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25-6.2 6.25-14.4 9.35-22.6 9.35s-16.38-3.125-22.62-9.375L160 301.3 54.63 406.6C48.38 412.9 40.19 416 32 416s-16.37-3.1-22.625-9.4c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z" /></svg>';
		this.addModal();
		this.init();
	}
	
	init() {
		this.closeButton.addEventListener('click', () => this.closeModal());
		document.addEventListener('keydown', (event) => {
			if (event.key == "Escape") {
				this.closeModal();
			}
		});
		const openModalButtons = document.querySelectorAll('.open-modal');
		openModalButtons.forEach((button) => button.addEventListener('click', (event) => {
			this.button = event.target;
			this.openModal(event);
		}));
	}
	
	addModal() {
		this.closeButton.id = "close-modal";
		this.closeButton.innerHTML = this.cross;

		this.modalHeader.classList.add('modal-header');
		this.modalHeader.appendChild(this.headline);
		this.modalHeader.appendChild(this.closeButton);

		this.modalMain.classList.add('modal-main')

		this.modal.classList.add('modal');
		this.modal.setAttribute('closed', true);
		this.modal.appendChild(this.modalHeader);
		this.modal.appendChild(this.modalMain);
		
		// this.modalWrapper.classList.add('modal-wrapper');
		// this.modalWrapper.appendChild(this.modal);
		
		// document.body.appendChild(this.modalWrapper);
		document.body.appendChild(this.modal);
	}

	closeModal() {
		// this.modalWrapper.classList.remove('modal-wrapper--open');
		this.modal.close();
		this.modalMain.innerHTML = '';
		let dispatch = this.button.getAttribute('data-dispatch');

		let event = new CustomEvent("modalClosed", {
			detail: this.button,
		});

		if (dispatch) {
			this.modal.dispatchEvent(event);
		}
	}
	
	openModal(event) {
		let target = event.target;
		this.headline.innerHTML = target.name;
		this.modal.showModal();
		// this.modalWrapper.classList.add('modal-wrapper--open');
		
		fetch(target.value, {
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
		}).then((response) => {
			return response.text();
		}).then((html) => this.initModal(html))
		.catch(err => console.log(err))
	}
	
	initModal(html) {
		this.modalMain.innerHTML = html;

		let event = new CustomEvent("modalOpen", {
			detail: this,
		});

		this.modal.dispatchEvent(event)
	}
}  
//# sourceMappingURL=layoutModal.js.map