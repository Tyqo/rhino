/**
 * src/js/main.js
 *
 * Main javascript file
 *
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @author Carsten Coull <c.coull@agentur-halma.de>
 * @package halma-kickstart
 * @version 2021-05-28
 */

/**
 * Import modules, modules are stored in `src/js/modules/`
 */
import Nav from "./vendor/nav.js";
import FlashMessages from "./vendor/flash-messages.js";
import LightBox from "./vendor/light-box.js";
import Overlay from "./vendor/overlay.js";
// import LazyLoading from "/js/vendor/lazyload.js";
// import Map from "/js/vendor/map.js";
// import Slider from "/js/vendor/slider.js";


/**
 * Application main class
 */
class MAIN {
	/**
	 * Constructor
	 */
	constructor() {
		// Class properties, can only be declared inside a method … :-(
		this.debug = false;
		document.addEventListener("DOMContentLoaded", () => this.init());
		window.onload = () => this.pageInit();
	}

	/**
	 * init
	 * Called on DOMContentLoaded, so a good place to setup things not dependend
	 * on the page finished rendering
	 */
	init() {
		if (this.debug) {
			console.debug("MAIN::init");
		}

		document.body.classList.add("page-has-loaded");

		// get scrollbar width to be able to use .full-width
		// @see https://destroytoday.com/blog/100vw-and-the-horizontal-overflow-you-probably-didnt-know-about
		const scrollbarWidth = window.innerWidth - document.body.clientWidth;
		document.body.style.setProperty("--scrollbarWidth", scrollbarWidth + "px");

		window.addEventListener("resize", () => this.throttle(this.resizeHandler), { passive: true });
		window.addEventListener("scroll", () => this.throttle(this.scrollHandler), { passive: true });
	}

	/**
	 * pageInit
	 * Called on window.load, i.e. when the page and all assets have been
	 * loaded completely and the page has rendered
	 *
	 * @return void
	 */
	pageInit() {
		if (this.debug) {
			console.debug("MAIN::pageInit");
		}

		document.body.classList.add("page-has-rendered");

		// Let's see if we have a header element and get it's height (for
		// detecting scroll past header, see `App.scrollHandler`
		this.header = document.querySelector("header");
		if (this.header) {
			let rect = this.header.getBoundingClientRect();
			this.headerBottom = rect.top + rect.height;
		}

		this.main();
	}

	/**
	 * Main method
	 * Put main business logic here
	 *
	 * @return void
	 */
	main() {
		this.Nav = new Nav(this);
		
		this.FlashMessages = new FlashMessages(this);

		this.Overlay = new Overlay(this, {
			closeButtonIcon: '/tusk/icon/cross.svg',
			closeButtonTitle: 'Close Overlay'
		});

		// this.Slider = new Slider(this);
		this.LightBox = new LightBox(this, {
			selector: '#main img',
			prevTitle: 'zum vorherigem Bild',
			nextTitle: 'zum nächsten Bild',
			prevIcon: '/dist/icons/chevron-left.svg',
			nextIcon: '/dist/icons/chevron-right.svg'
		});
	}

	/*
	 * Debounced / throttled scroll handler. Put your scroll-related stuff here!
	 * @return void
	 */
	scrollHandler() {
		let y = window.scrollY;

		if (this.debug) {
			console.debug(`Scroll position: ${y}`);
		}

		// Set classes on body depending on how far the page has scrolled
		document.body.classList.toggle("has-scrolled", y > 0);
		document.body.classList.toggle("has-scrolled-a-bit", y > 30);
		document.body.classList.toggle(
			"has-scrolled-past-header",
			y > this.headerBottom
		);
		document.body.classList.toggle(
			"has-scrolled-100vh",
			y > window.innerHeight
		);

		// Todo: Scroll direction!
		if (this.lastScrollPosition) {
			document.body.classList.toggle(
				"has-scrolled-up",
				y < this.lastScrollPosition
			);

			document.body.classList.toggle(
				"has-scrolled-down",
				y > this.lastScrollPosition
			);
		}
		this.lastScrollPosition = y;

		// Extend here …
	}

	/**
	 * Debounced / throttled scroll handler. Put your resize-related stuff here!
	 *
	 * @return void
	 */
	resizeHandler() {
		let width = window.innerWidth,
			height = window.innerHeight;

		if (this.debug) {
			console.debug(`Window has been resized to ${width}, ${height}`);
		}

		// Set custom properties
		document.body.style.setProperty("--window-width", `${width}px`);
		document.body.style.setProperty("--window-height", `${height}px`);

		// Extend here …
	}

	/**
	 * Throttler method
	 *
	 * @param callable: Handler to be called on throttled scroll event
	 * @return void
	 */
	throttle(handler) {
		this.ticking = false;

		if (!this.ticking) {
			window.requestAnimationFrame(() => {
				handler.call(this);
				this.ticking = false;
			});
			this.ticking = true;
		}
	}

	/**
	 * execute if click/interaktion is outside of the Selector
	 *
	 * @param selector: Element selector (e.g. class, id) to watch for
	 * @param callback: function to execute if interaktion is outside of the Selector
	 *
	 * Example:
	 * this.app.onOutsideClick('#main-menu', this.closeMenu);
	 */
	onOutsideClick(selector, callback) {
		document.addEventListener("click", (event) => {
			var target = event.target.parentNode.closest(selector);
			if (target == null && document.querySelector(selector) != event.target) {
				callback(event, target);
			}
		});
	}

	hideElement() {

	}
}

new MAIN();
//# sourceMappingURL=main.js.map
