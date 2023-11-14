export default class Files {
	constructor(main) {
		this.main = main;
		this.Modal = main.Modal;

		if (this.main.debug) {
			console.debug("Files::const");
		}

		this.buttons = document.querySelectorAll('[type=directory]');
		if (this.buttons.length > 0) {
			this.init();
		}
	}

	init() {
		this.buttons.forEach(button => {
			let modal = this.Modal.newModal(button, false);
			this.Modal.addQuery(modal);

			modal.addEventListener('confirm', (e) => {
				let selected = modal.querySelector('input[type=radio]:checked');
				console.log(selected.value);
				let input = document.getElementById(button.name);
				input.value = selected.value;
			});

			modal.addEventListener('close', (e) => {
				this.reset(modal);
			});

			button.addEventListener('click', (event) => {
				event.preventDefault();
				let url = button.value + '?';
				url += new URLSearchParams({
					modal: true,
					dir: button.dataset.dir,
					types: button.dataset.types
				});
				
				fetch(url, {
						headers: {
							'X-Requested-With': 'XMLHttpRequest'
						},
					})
					.then((response) => {
						return response.text();
					})
					.then((html) => {
						console.log(html);
						this.Modal.addContent(modal, html);
						this.Modal.openModal(modal);
					})
					.catch(err => console.log(err))
			})
		});
	}

	reset(modal) {
		this.Modal.addContent(modal, '');
	}
}