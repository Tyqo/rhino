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

			let input = document.getElementById(button.name);
			let fileInput = document.querySelector('input[name=' + button.name + '_file]');

			if (fileInput) {
				fileInput.addEventListener('change', (event) => {
					let files = fileInput.files;
					let output = [];
					for (var i = 0; i < files.length; i++) {
						var filename = files[i].name.replace(/^.*[\\/]/, '');
						output.push(filename);
					}
					input.value = output.join(', ');
				});
			}

			modal.addEventListener('confirm', (e) => {
				let selected = modal.querySelector('input[type=radio]:checked');
				input.value = selected.value;
			});

			modal.addEventListener('close', (e) => {
				this.Modal.reset(modal);
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
						this.Modal.addContent(modal, html);
						this.Modal.openModal(modal);
					})
					.catch(err => console.log(err))
			})
		});
	}
}
//# sourceMappingURL=files.js.map