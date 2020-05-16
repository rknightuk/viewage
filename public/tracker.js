// Based on Fathom's tracking script https://github.com/usefathom/fathom/blob/b27894431395fed2053b2c9b92340a4a73b05319/assets/src/js/tracker.js#L24
(function() {
	'use strict';

	let queue = window.viewage.q || [];
	let config = {
		'siteId': '',
		'trackerUrl': '',
	};
	const commands = {
		"set": set,
		"trackPageview": trackPageview,
		"setTrackerUrl": setTrackerUrl,
	};

	function set(key, value) {
		config[key] = value;
	}

	function setTrackerUrl(value) {
		return set("trackerUrl", value);
	}

	// convert object to query string
	function stringifyObject(obj) {
		var keys = Object.keys(obj);

		return '?' +
			keys.map(function(k) {
				return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
			}).join('&');
	}

	function randomString(n) {
		var s = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return Array(n).join().split(',').map(() => s.charAt(Math.floor(Math.random() * s.length))).join('');
	}

	function findTrackerUrl() {
		const el = document.getElementById('viewage-script')
		return el ? el.src.replace('tracker.js', 'collect') : '';
	}

	function trackPageview(vars) {
		vars = vars || {};

		// Respect "Do Not Track" requests
		if('doNotTrack' in navigator && navigator.doNotTrack === "1") {
			return;
		}

		// ignore prerendered pages
		if( 'visibilityState' in document && document.visibilityState === 'prerender' ) {
			return;
		}

		// if <body> did not load yet, try again at dom ready event
		if( document.body === null ) {
			document.addEventListener("DOMContentLoaded", () => {
				trackPageview(vars);
			})
			return;
		}

		//  parse request, use canonical if there is one
		let req = window.location;

		// do not track if not served over HTTP or HTTPS (eg from local filesystem)
		if(req.host === '') {
			return;
		}

		// find canonical URL
		let canonical = document.querySelector('link[rel="canonical"][href]');
		if(canonical) {
			let a = document.createElement('a');
			a.href = canonical.href;

			// use parsed canonical as location object
			req = a;
		}

		let path = vars.path || req.pathname.replace(/\/$/, "");
		if(!path) {
			path = '/';
		}

		// determine hostname
		let hostname = vars.hostname || ( req.protocol + "//" + req.hostname );

		// only set referrer if not internal
		let referrer = vars.referrer || '';
		if(document.referrer.indexOf(hostname) < 0) {
			referrer = document.referrer;
		}

		const d = {
			id: randomString(20),
			p: path,
			h: hostname,
			r: referrer,
			sid: config.siteId,
		};

		let url = config.trackerUrl || findTrackerUrl()
		let img = document.createElement('img');
		img.setAttribute('alt', '');
		img.setAttribute('aria-hidden', 'true');
		img.src = url + stringifyObject(d);
		img.addEventListener('load', function() {
			// remove tracking img from DOM
			document.body.removeChild(img)
		});

		// in case img.onload never fires, remove img after 1s & reset src attribute to cancel request
		window.setTimeout(() => {
			if(!img.parentNode) {
				return;
			}

			img.src = '';
			document.body.removeChild(img)
		}, 1000);

		// add to DOM to fire request
		document.body.appendChild(img);
	}

	// override global viewage object
	window.viewage = function() {
		var args = [].slice.call(arguments);
		var c = args.shift();
		commands[c].apply(this, args);
	};

	// process existing queue
	queue.forEach((i) => viewage.apply(this, i));
})()
