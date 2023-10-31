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
			
			if (target.tagName == 'DIALOG') {
				button.addEventListener('click', (event) => {
					this.toggleModal(event, target);
				})
			}
		});
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
		modal.showModal();
	}

	closeModal(modal) {
		this.visibleModal = null;
		modal.close();
	}
}
//# sourceMappingURL=modal.js.map