export default class Cookie {
	set(name, value, expires, path) {
		let cookie = name + "=" + value + ";";

		if (expires) {
			const d = new Date();
			d.setTime(d.getTime() + expires);
			cookie += "expires=" + d.toUTCString();
		}

		if (path) {
			cookie += ";path=/" + path;
		}

		if (domain) {
			cookie += ";domain=/" + domain;
		}

		document.cookie = cookie;
	}

	get(name) {
		let cname = name + "=";
		let cookies = document.cookie.split(';');

		for (let i = 0; i < cookies.length; i++) {
			let cookie = cookies[i];
			
			while (cookie.charAt(0) == ' ') {
				cookie = cookie.substring(1);
			}

			if (cookie.indexOf(cname) == 0) {
				return cookie.substring(cname.length, cookie.length);
			}
		}
	}

	remove(name, path, domain) {
		if (this.get(name)) {
			document.cookie = name + "=" +
				((path) ? ";path=" + path : "") +
				((domain) ? ";domain=" + domain : "") +
				";expires=Thu, 01 Jan 1970 00:00:01 GMT";
		}
	}
}
//# sourceMappingURL=cookie.js.map