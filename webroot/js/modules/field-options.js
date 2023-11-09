export default class FieldOptions {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("FieldOptions::const");
		}

		this.Config = {
			tabGroupSelector: '.tab-group',
			tabButtonSelector: '[data-target]',
			tabButtonClass: 'tab-button',
			activeTabClass: 'tab--active',
			activeButtonClass: 'tab-button--active'
		}

		this.container = document.getElementById("field-options");
		if (this.container) {
			this.setup();
		}
	}

	setup() {
		this.bench = document.getElementById("benched-options");
		this.typeSelector = document.getElementById('type');
		this.bench.innerHTML = this.container.innerHTML;
		this.container.innerHTML = '';
		
		this.change();
	}

	init() {
		if (!this.typeSelector) {
			return;
		}

		this.typeSelector.addEventListener('change', () => {
			this.reset();
			this.change();
		});
	}

	change() {
		let selected = this.typeSelector.value + "-options";
		let element = document.getElementById(selected);
		if (element) {
			this.container.appendChild(element);
		}

		this.main.layoutUpdate();
	}

	reset() {
		this.container.childNodes.forEach((node) => {
			this.bench.appendChild(node);
		});
	}
}
//# sourceMappingURL=field-options.js.map