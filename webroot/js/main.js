/**
 * app/js/main.js
 *
 * Main javascript file
 *
 * @author Carsten Coull <carsten.coull@swu.de>
 * @package vt-dispo
 * @version 2023-10-25
 */

/**
 * Import modules, modules are stored in `app/js/modules/`
 */
import ThemeSwitcher from "/rhino/js/modules/theme-switcher.js";
import Modal from "/rhino/js/modules/modal.js";
import Files from "/rhino/js/modules/files.js";
import Menu from "/rhino/js/modules/menu.js";
import Tabs from "/rhino/js/modules/tabs.js";
import FieldOptions from "/rhino/js/modules/field-options.js";
import HooksHandler from "/rhino/js/modules/hooks-handler.js";

/**
 * Application main class
 */
class MAIN {
	/**
	 * Constructor
	 */
	constructor() {
		this.debug = false;

		document.addEventListener("DOMContentLoaded", () => this.init());
		window.onload = () => this.main();
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
		
		// Init Moduls that need to start before the page is visible here:
		this._layoutUpdate = new CustomEvent("layout-update", {});

		this.Hooks = new HooksHandler(this);
		this.ThemeSwitcher = new ThemeSwitcher(this);
		this.FieldOptions = new FieldOptions(this);
		this.Tabs = new Tabs(this);
		
		document.body.classList.add("page-has-loaded");
		window.addEventListener("resize", () => this.throttle(this.resizeHandler), { passive: true });
		window.addEventListener("scroll", () => this.throttle(this.scrollHandler), { passive: true });
	}

	layoutUpdate() {
		window.dispatchEvent(this._layoutUpdate);
	}
	/**
	 * Main method
	 * Put main business logic here
	 *
	 * @return void
	 */
	main() {
		this.pageInit();
		if (this.debug) {
			console.debug("MAIN::main");
		}

		// Init Moduls here:
		this.ThemeSwitcher.init();
		this.FieldOptions.init();
		this.Tabs.init();
		this.Modal = new Modal(this);
		this.Menu = new Menu(this);
		this.Files = new Files(this);

		document.body.classList.add("page-has-rendered");
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

		// Let's see if we have a header element and get it's height (for
		// detecting scroll past header, see `App.scrollHandler`
		this.header = document.querySelector("header");
		if (this.header) {
			let rect = this.header.getBoundingClientRect();
			this.headerBottom = rect.top + rect.height;
		}
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
}

new MAIN();
//# sourceMappingURL=main.js.map
