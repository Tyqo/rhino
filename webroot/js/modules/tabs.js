export default class Tabs {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("Tabs::const");
		}

		this.Config = {
			tabGroupSelector: '.tab-group',
			tabButtonSelector: '[data-target]',
			tabButtonClass: 'tab-button',
			activeTabClass: 'tab--active',
			activeButtonClass: 'tab-button--active'
		}

		this.tabGroups = document.querySelectorAll(this.Config.tabGroupSelector);

		if (this.tabGroups.length > 0) {
			this.setup();
		}
	}

	setup() {
		this.tabGroups.forEach(tabGroup => {
			let tabButton = tabGroup.querySelector(this.Config.tabButtonSelector);
			this.open(tabButton);
		});

		const hash = location.hash.substring(1);
		if (hash) {
			let hashButton = document.querySelector(
				"." + this.Config.tabButtonClass + this.Config.tabButtonSelector.slice(0, -1) + "=" + hash + "]"
				);

			if (hashButton) {
				let hashGroup = hashButton.closest(this.Config.tabGroupSelector);
				this.toggle(hashButton, hashGroup);
				console.log("toggle");
			}
		}
	}

	init() {
		this.tabGroups.forEach(tabGroup => {
			let tabButtons = tabGroup.querySelectorAll(this.Config.tabButtonSelector);

			tabButtons.forEach(tabButton => {
				tabButton.addEventListener('click', (event) => {
					event.preventDefault();
					this.toggle(tabButton, tabGroup);
				});
			});
		});

		window.addEventListener("layout-update", () => this.refresh());
	}
	
	toggle(tabButton, tabGroup) {
		this.close(tabGroup);
		this.open(tabButton);
	}

	close(group) {
		let activeButtons = group.querySelectorAll("." + this.Config.activeButtonClass);
		let activeTabs = group.querySelectorAll("." + this.Config.activeTabClass);

		activeButtons.forEach(active => {
			active.classList.remove(this.Config.activeButtonClass);
		});

		activeTabs.forEach(active => {
			active.classList.remove(this.Config.activeTabClass);
		});
	}

	open(button) {
		let target = document.getElementById(button.dataset.target);

		button.classList.add(this.Config.activeButtonClass);
		target.classList.add(this.Config.activeTabClass);
	}

	refresh() {
		this.tabGroups = document.querySelectorAll(this.Config.tabGroupSelector);
		this.tabGroups.forEach(tabGroup => {
			let tabButton = tabGroup.querySelector(this.Config.tabButtonSelector);
			this.open(tabButton);
		});
	}
}
//# sourceMappingURL=tabs.js.map