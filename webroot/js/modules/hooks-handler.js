export default class HooksHandler {
	constructor(main) {
		this.main = main;

		if (this.main.debug) {
			console.debug("HooksHandler::const");
		}

		// (A1) CURRENT HOOK QUEUE
		this.queue = {};
	}

	// (A2) ADD FUNCTION TO QUEUE
	// name : name of function to add hook to
	// fn : function to call
	add(name, fn) {
		if (!this.queue[name]) { this.queue[name] = []; }
		this.queue[name].push(fn);
	}

	// (A3) CALL A HOOK
	// name : name of function to add hook to
	// params : parameters
	call(name, ...params) {
		console.log(name);
		if (this.queue[name]) {
			this.queue[name].forEach((fn) => { fn(...params); });
			delete this.queue[name];
		}
	}
}
//# sourceMappingURL=hooks-handler.js.map