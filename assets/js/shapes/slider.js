import Splide from "/dist/js/vendor/splide.esm.js";

export default class Slider {
	constructor(app) {
		this.app = app;

		// Set Language support
		Splide.defaults = {
			i18n: {
				prev: 'Voheriger slide',
				next: 'Nächster slide',
			},
		};

		var slides = document.querySelectorAll(".splide");
		if (slides.length) {
			this.setup();
		}
	}

	// for more options see:
	// https://splidejs.com/guides/options/
	setup() {
		var splide = new Splide(".splide", {
			type: "loop",
			focus: 'center',
			height: 'auto',
			rewind: true,
			releaseWheel: true,
			easing: "ease", // also supports cubic functions
			speed: 600
		});
		splide.mount();
	}
}