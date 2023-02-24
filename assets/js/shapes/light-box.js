export default class LightBox {
	constructor(app, options = null) {
		this.app = app;

		this.options = options;

		this.selector = this.options.selector;
		this.lightBox = document.getElementById('light-box');
		this.lightBoxElements = [];

		if (document.querySelectorAll(this.selector).length > 0 && this.lightBox) {
			this.setup();
		}
	};

	setup() {
		if (this.app.debug) {
			console.log("NewLightBox started");
		}

		// Start Functions
		this.lightBoxElements;
		this.app.Overlay.addOverlay(this.selector, "#light-box");
		this.currentIndex;
		
		this.getElements();
		this.initControlls();
		
		for (var i = 0; i < this.lightBoxElements.length; i++) {
			this.lightBoxElements[i].addEventListener('click', (event) => {
				this.lightBox.classList.add('light-box--active');
				this.currentIndex = this.indexOf(event.target, this.lightBoxElements);
				this.current.innerHTML = (this.currentIndex + 1);
				this.AddImage(event.target);
			});
		}
	};
		
	getElements() {
		if (document.querySelectorAll(this.selector).length > 0) {
			var elements = document.querySelectorAll(this.selector);
			elements.forEach((element, i) => {
				if (element.closest(this.exclude) != null) {
					return;
				}
				this.lightBoxElements.push(element);
			});
		}
	}

	AddImage(element) {
		var type = element.getAttribute('data-lightBoxType') != null ? element.getAttribute('data-lightBoxType') : element.tagName.toLowerCase();
		var source = element.getAttribute('data-src') ? element.getAttribute('data-src') : element.getAttribute('src');
		
		var sourceSet = element.getAttribute('srcset');
		var sizes = element.getAttribute('sizes');
		var alt = element.getAttribute('alt');

		var $image = document.getElementById('light-box--image');
		var $video = document.getElementById('light-box--video');

		this.reset();

		if (type == 'video') {
			$image.style.display = 'none';
			$image.setAttribute('src', '');
			$video.setAttribute('src', source);
			$video.style.display = '';
		} else {
			$video.style.display = 'none';
			$video.setAttribute('src', '');
			$image.setAttribute('src', source);

			if (sourceSet) {
				$image.setAttribute('srcset', sourceSet);
			}

			if (sizes) {
				$image.setAttribute('sizes', sizes);
			}

			if (alt) {
				$image.setAttribute('alt', alt);
			}

			$image.style.display = '';
		}
	}

	lightBoxPrev() {
		var tmpIndex = this.currentIndex - 1;
		this.currentIndex = tmpIndex >= 0 ? tmpIndex : this.lightBoxElements.length -1;
		this.current.innerHTML = (this.currentIndex + 1);
		var element = this.lightBoxElements[this.currentIndex];
		this.AddImage(element);
	}

	lightBoxNext() {
		var tmpIndex = this.currentIndex + 1;
		this.currentIndex = tmpIndex < this.lightBoxElements.length ? tmpIndex : 0;
		this.current.innerHTML = (this.currentIndex + 1);
		var element = this.lightBoxElements[this.currentIndex];
		this.AddImage(element);
	}

	initControlls() {
		this.controlls = document.createElement('div');
		this.controlls.classList.add('light-box__controlls');

		this.prevButton = this.createButton('light-box__prev', this.options.prevTitle, this.options.prevIcon);
		this.nextButton = this.createButton('light-box__next', this.options.nextTitle, this.options.nextIcon);

		this.nextButton.addEventListener('click', () => this.lightBoxNext());
		this.prevButton.addEventListener('click', () => this.lightBoxPrev());

		let status = this.createStatus();

		this.controlls.appendChild(this.prevButton);
		this.controlls.appendChild(status);
		this.controlls.appendChild(this.nextButton);

		this.lightBox.appendChild(this.controlls);

		window.addEventListener("keydown", (event) => {
			if (event.key == 'ArrowLeft' || event.key == 'h' ) { // left
				this.lightBoxPrev();
			}

			if (event.key == 'ArrowRight' || event.key == 'l' ) { // right
				this.lightBoxNext();
			}
		});
	}

	createButton(buttonClass, title, file) {
		let button = document.createElement('button');
		button.classList.add(buttonClass);
		button.setAttribute('title', title);
		
		fetch(file)
			.then(response => response.text())
			.then(text => {
				button.innerHTML = text;
			});

		return button
	}

	createStatus() {
		let total = document.createElement('span');
		total.classList.add('light-box--total');
		total.innerHTML = this.lightBoxElements.length;
		
		let current = document.createElement('span');
		current.classList.add('light-box--current');
		current.innerHTML = this.currentIndex + 1;
		this.current = current;

		let status = document.createElement('div');
		status.classList.add('light-box__status');

		status.appendChild(total);
		status.appendChild(current);

		return status;
	}

	indexOfElement(element, query, parent) {
		var parent = parent == null ? document : parent;
		var elements = parent.querySelectorAll(query);
		return this.indexOf(element, elements)
	}
	
	indexOf(needle, haystack) {
		for (var i = 0; i < haystack.length; i++) {
			if (haystack[i] == needle) {
				return i;
			}
		}
		return null;
	}
	
	reset() {
		var $image = document.getElementById('light-box--image');
		var $video = document.getElementById('light-box--video');
		$video.setAttribute('src', '');
		$image.setAttribute('src', '');
		$image.setAttribute('srcset', '');
		$image.setAttribute('sizes', '');
	}
}
