(function () {
	'use strict';

	var preferenceKey = 'voxa-theme';
	var validThemes = { light: true, dark: true };

	function validTheme(value) {
		return typeof value === 'string' && validThemes[value] ? value : 'dark';
	}

	function readCookie() {
		var cookies = document.cookie ? document.cookie.split('; ') : [];
		var prefix = preferenceKey + '=';

		for (var index = 0; index < cookies.length; index += 1) {
			if (cookies[index].indexOf(prefix) === 0) {
				try {
					return decodeURIComponent(cookies[index].slice(prefix.length));
				} catch (error) {
					return '';
				}
			}
		}

		return '';
	}

	function readLocalStorage() {
		try {
			return window.localStorage.getItem(preferenceKey) || '';
		} catch (error) {
			return '';
		}
	}

	function cookieDomain() {
		var hostname = window.location.hostname;

		if (hostname === 'voxa.vn' || hostname.slice(-8) === '.voxa.vn') {
			return '.voxa.vn';
		}

		if (hostname === 'voxa.localhost' || hostname.slice(-15) === '.voxa.localhost') {
			return '.voxa.localhost';
		}

		return '';
	}

	function storeTheme(theme) {
		var domain = cookieDomain();
		var cookie = preferenceKey + '=' + encodeURIComponent(theme) + '; Max-Age=31536000; Path=/; SameSite=Lax';

		if (domain) {
			cookie += '; Domain=' + domain;
		}
		if (window.location.protocol === 'https:') {
			cookie += '; Secure';
		}

		document.cookie = cookie;

		try {
			window.localStorage.setItem(preferenceKey, theme);
		} catch (error) {
			// The cookie remains the shared fallback when storage is unavailable.
		}
	}

	function applyTheme(theme) {
		document.documentElement.setAttribute('data-voxa-theme', theme);
	}

	function readTheme() {
		var cookieValue = readCookie();

		if (cookieValue !== '') {
			return validTheme(cookieValue);
		}

		return validTheme(readLocalStorage());
	}

	function updateControls(theme) {
		var isDark = theme === 'dark';
		var controls = document.querySelectorAll('[data-theme-toggle]');

		for (var index = 0; index < controls.length; index += 1) {
			var control = controls[index];
			var icon = control.querySelector('[data-theme-icon]');
			var label = control.querySelector('[data-theme-label]');

			control.setAttribute('aria-pressed', isDark ? 'true' : 'false');
			control.setAttribute('aria-label', isDark ? 'Chuyển sang chế độ sáng' : 'Chuyển sang chế độ tối');
			if (icon) {
				icon.textContent = isDark ? '☀' : '☾';
			}
			if (label) {
				label.textContent = isDark ? 'SÁNG' : 'TỐI';
			}
		}
	}

	var currentTheme = readTheme();
	applyTheme(currentTheme);

	document.addEventListener('DOMContentLoaded', function () {
		var controls = document.querySelectorAll('[data-theme-toggle]');

		updateControls(currentTheme);
		for (var index = 0; index < controls.length; index += 1) {
			controls[index].addEventListener('click', function () {
				currentTheme = document.documentElement.getAttribute('data-voxa-theme') === 'dark' ? 'light' : 'dark';
				applyTheme(currentTheme);
				storeTheme(currentTheme);
				updateControls(currentTheme);
			});
		}
	});
}());
