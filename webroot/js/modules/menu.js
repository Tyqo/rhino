export default class Menu {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("Menu::const");
		}

		this.Config = {
			menuID: 'main-menu',
			menuButtonID: 'menu-button',
			bodyClass: "menu-is-open",
			menuClass: 'menu--open'
		}

		this.menu = document.getElementById(this.Config.menuID);
		this.menuButton = document.getElementById(this.Config.menuButtonID);

		if (this.menu && this.menuButton) {
			this.setup();
		}
	}

	setup() {
		this.menuButton.addEventListener('click', () => this.toggle());

		window.addEventListener('keydown', (e) => {
			if (e.key == "Escape") {
				this.close();
			}
		});

		this.main.onOutsideClick('#' + this.Config.menuID, (event) => {
			let status = this.menuButton.getAttribute("aria-expanded");
			if (status == 'true') {
				this.close();
			}
		});
	}

	toggle() {
		let status = this.menuButton.getAttribute('aria-expanded');

		if (status == 'true') {
			this.close();
		} else {
			this.open();
		}
	}

	close() {
		this.menu.classList.remove(this.Config.menuClass);
		document.body.classList.remove(this.Config.bodyClass);
		this.menuButton.setAttribute(
			"aria-expanded",
			"false"
		);
	}

	open() {
		// Small delay for onOutsideClick to work
		setTimeout(() => {
			this.menu.classList.add(this.Config.menuClass);
			document.body.classList.add(this.Config.bodyClass);
			this.menuButton.setAttribute(
				"aria-expanded",
				"true"
			);
		}, 100);
	}
}
//# sourceMappingURL=menu.js.map