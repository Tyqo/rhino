export default class Nav {
	constructor(main) {
		this.nav = document.getElementById('main-nav');
		this.menuButton = document.getElementById('menu-button');

		let subNavButtons = this.nav.querySelectorAll('[name=subnav-button]');
		subNavButtons.forEach((subnav) => {
			subnav.addEventListener('click', () => {
				if (subnav.getAttribute('aria-expanded') == 'true') {
					subnav.setAttribute('aria-expanded', 'false');
				} else {
					subnav.setAttribute('aria-expanded', 'true');
				}
			});
		});

		this.menuButton.addEventListener('click', () => {
			let status = this.menuButton.getAttribute('aria-expanded');

			if (status == 'true') {
				this.close();
			} else {
				this.open();
			}
		});
		
		window.addEventListener('keydown', (e) => {
			if (e.key == "Escape") {
				this.close();
			}
		});

		main.onOutsideClick('.subnav', (event) => {
			let openNavs = this.nav.querySelectorAll('[name=subnav-button][aria-expanded=true]');
			openNavs.forEach((subnav) => {
				if (event.target !== subnav) {
					subnav.setAttribute('aria-expanded', 'false');
				}
			});
		});

		main.onOutsideClick('#main-nav', (event) => {
			let status = this.menuButton.getAttribute("aria-expanded");
			if (status == 'true') {
				this.close();
			}
		});
	}

	close() {
		this.nav.classList.remove("nav--open");
		document.body.classList.remove("mobile-nav-is-open");
		this.menuButton.setAttribute(
			"aria-expanded",
			"false"
		);
	}
	
	open() {
		// Small delay for onOutsideClick to work
		setTimeout(() => {
			this.nav.classList.add("nav--open");
			document.body.classList.add("mobile-nav-is-open");
			this.menuButton.setAttribute(
				"aria-expanded",
				"true"
			);
		}, 100);
	}
}