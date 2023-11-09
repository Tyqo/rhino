export default class ThemeSwitcher {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("ThemeSwitcher::const");
		}

		// Config
		this.Config = {
			_scheme: "auto",
			menuTarget: "details[role='list']",
			buttonsTarget: "a[data-theme-switcher]",
			buttonAttribute: "data-theme-switcher",
			rootAttribute: "data-theme",
			localStorageKey: "picoPreferredColorScheme",
		}

		this.scheme = this.schemeFromLocalStorage;
	}

	// Init
	init() {
		this.initSwitchers();
	}

	// Get color scheme from local storage
	get schemeFromLocalStorage() {	
		if (typeof window.localStorage !== "undefined") {
			if (window.localStorage.getItem(this.Config.localStorageKey) !== null) {
				return window.localStorage.getItem(this.Config.localStorageKey);
			}
		}

		return this.Config._scheme;
	}

	// Preferred color scheme
	get preferredColorScheme() {
		return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
	}

	// Init switchers
	initSwitchers() {
		this.buttons = document.querySelectorAll(this.Config.buttonsTarget);
		this.buttons.forEach((button) => {
			button.addEventListener(
				"click",
				(event) => {
					event.preventDefault();
					// Set scheme
					this.scheme = button.getAttribute(this.Config.buttonAttribute);
					// Close dropdown
					document.querySelector(this.Config.menuTarget).removeAttribute("open");
				},
				false
			);
		});
	}

	// Set scheme
	set scheme(scheme) {
		if (scheme == "auto") {
			this.preferredColorScheme == "dark" ? (this.Config._scheme = "dark") : (this.Config._scheme = "light");
		} else if (scheme == "dark" || scheme == "light") {
			this.Config._scheme = scheme;
		}
		this.applyScheme();
		this.schemeToLocalStorage();
	}

	// Get scheme
	get scheme() {
		return this.Config._scheme;
	}

	// Apply scheme
	applyScheme() {
		document.querySelector("html").setAttribute(this.Config.rootAttribute, this.scheme);
	}

	// Store scheme to local storage
	schemeToLocalStorage() {
		if (typeof window.localStorage !== "undefined") {
			window.localStorage.setItem(this.Config.localStorageKey, this.scheme);
		}
	}
};

// Init
//# sourceMappingURL=theme-switcher.js.map
