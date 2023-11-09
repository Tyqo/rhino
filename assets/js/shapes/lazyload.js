/**
 * src/js/modules/lazyload.js
 *
 * Lazy Loading images
 *
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @package halma-kickstart
 * @version 2021-05-28
 */
export default class LazyLoading {

	constructor() {
		this.lazyImages = [];
	}

	init() {

		this.lazyImages = document.querySelectorAll('img[data-src]');

		if ("IntersectionObserver" in window) {
			this.setup();
		}
		else {
			// Fallback for browsers without IntersectionObserver
			this.lazyImages.forEach(image => {
				image.src = image.dataset.src;
				image.classList.add('has-loaded');
			});
		}
	};


	setup() {

		const imageObserver = new IntersectionObserver(function(entries, observer) {

			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					const image = entry.target;
					image.src = image.dataset.src;
					image.onload = function() {
						image.classList.remove('lazy');
						image.classList.add('has-loaded');
					};
					image.onerr

					imageObserver.unobserve(image);
				}
			});
		});

		this.lazyImages.forEach(function(image) {
			imageObserver.observe(image);
		});
	};
};
