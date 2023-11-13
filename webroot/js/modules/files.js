export default class Files {
	constructor(main) {
		this.main = main;
		this.Modal = main.Modal;

		if (this.main.debug) {
			console.debug("Files::const");
		}

		this.buttons = document.querySelectorAll('[name=fileSelect]');
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
			})

			button.addEventListener('click', (event) => {
				event.preventDefault();
				let url = '/rhino/files/get?';
				url += new URLSearchParams({modal: true});
				
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
}
//# sourceMappingURL=files.js.map