export default class FlashMessages {
	constructor(app) {
		this.app = app;
		this.flash = document.getElementById('flash-messages');

		if (this.flash) {
			this.messages = this.flash.querySelectorAll('.message');

			if (this.messages.length > 0) {
				this.setup();
			}
		}
	};

	setup() {
		if (this.app.debug) {
			console.log("FlashMessage started:", this.messages.length);
		}

		this.messages.forEach(message => {
			let dismissButton = message.querySelector('[name=dismiss-message]');
			dismissButton.addEventListener('click', () => {
				this.dismissMessage(message);
			});
		});
	};

	dismissMessage(message) {
		message.classList.add('message--dismissed');
		message.addEventListener('transitionend', () => message.remove());
	}
}
