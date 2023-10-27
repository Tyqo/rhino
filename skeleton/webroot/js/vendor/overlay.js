export default class Overlay {
	constructor(app, options = null) {
		this.app = app;

		this.options = options;
		
		this.overlay = document.querySelector('.overlay');
		if (this.overlay) {
			this.setup();
		}
	}

	setup() {
		this.initWrapper();
		this.initCloseButton();
		
		window.addEventListener("keydown", (event)  => {
			if (event.keyCode == 27) {
				this.closeOverlays();
			}
		});
	}
	
	addOverlay(selector, overlay) {
		if (this.app.debug) {
			console.log("Overlay added, " + selector);
		}
		
		var openButtons = document.querySelectorAll(selector);
		openButtons.forEach((openButton) => {
			openButton.addEventListener('click', (event) => {
				this.toggleOverlay(overlay);
			});
		});
	}
	
	toggleOverlay(targetOverlay = null) {
		targetOverlay = this.overlay.querySelector(targetOverlay);
		this.overlay.classList.remove("overlay--open");
		var check = false;
		var overlayTargets = this.overlay.querySelectorAll('.overlay--target');
		overlayTargets.forEach((target) => {
			check = targetOverlay == target;
			target.classList.remove("overlay--target");
		});

		if (targetOverlay && !check) {
			this.openOverlay(targetOverlay);
		}
	}
	
	closeOverlays() {
		this.overlay.classList.remove("overlay--open");
		var overlayTargets = this.overlay.querySelectorAll('.overlay--target');
		overlayTargets.forEach((target) => {
			target.classList.remove("overlay--target");
		});
	}
	
	openOverlay(targetOverlay) {
		this.overlay.classList.add("overlay--open");
		targetOverlay.classList.add("overlay--target");
		
		var focus = targetOverlay.querySelector('[data-focus]');
		if (focus) { focus.focus(); }
	}
	
	getWrapper() {
		return document.querySelector('.overlay__wrapper');
	}

	initCloseButton() {
		this.closeButton = document.createElement('button');
		this.closeButton.classList.add('overlay__close');
		this.closeButton.setAttribute('title', this.options.closeButtonTitle);
		this.overlay.insertBefore(this.closeButton, this.overlay.firstChild);
		
		// let file = '/dist/img/cross.svg';
		
		fetch(this.options.closeButtonIcon)
		.then(response => response.text())
		.then(text => {
			this.closeButton.innerHTML = text;
		});
		
		this.closeButton.addEventListener('click', () => {
			this.closeOverlays();
		});
	}

	initWrapper() {
		this.wrapper = document.createElement('div');
		this.wrapper.classList.add('overlay__wrapper');

		let fragment = document.createDocumentFragment();
		this.overlay.childNodes.forEach(child => {
			if (child.tagName) {
				fragment.appendChild(child);
			}
		});

		this.wrapper.appendChild(fragment);
		this.overlay.appendChild(this.wrapper);
	}
}