/**
 * Get params helper for photo gallery
 */

 /*jslint browser: true*/
 /*global $, jQuery*/

$(function() {
	"use strict";

	var digitTest = /^\d+$/,
		keyBreaker = /([^\[\]]+)|(\[\])/g,
		plus = /\+/g,
		paramTest = /([^?#]*)(#.*)?$/;


	function init() {
		var dataObject = getParams();

		if(dataObject) {
			ImageURL(dataObject);
		}
	}


	/**
	 * Get filters for page, and show any inactive elements linked to the filters
	 */
	function ImageURL(params) {
		var i,
			key;

		if (params['photo'] !== undefined ){
			$('[data-js-photo]').attr('src', 'img/' + params['photo']);
		}
	}

	function getParams () {
		var params = location.search.slice(1);

		if(params && paramTest.test(params)) {
			return queryStringToJSON();
		}

		return false;
	}

	function queryStringToJSON() {
		var params = location.search.slice(1) + '',
			data = {},
			pairs = params.split('&'),
			pair,
			current,
			part,
			lastPart,
			newKey,
			key, value, parts,
			i, j, k;

		for(i = 0; i < pairs.length; i = i + 1) {
			current = data;
			pair = pairs[i].split('=');

			// if we find foo=1+1=2
			if(pair.length != 2) {
				pair = [pair[0], pair.slice(1).join("=")]
			}

			key = decodeURIComponent(pair[0].replace(plus, " "));
			value = decodeURIComponent(pair[1].replace(plus, " "));
			parts = key.match(keyBreaker);

			for (j = 0; j < parts.length - 1; j++ ) {
				part = parts[j];
				if (!current[part] ) {
					// if what we are pointing to looks like an array
					current[part] = digitTest.test(parts[j+1]) || parts[j+1] == "[]" ? [] : {}
				}
				current = current[part];
			}

			lastPart = parts[parts.length - 1];

			// handle multiple options with |
			value = value.split("|");

			for (k = 0; k < value.length; k = k + 1) {
				if(value.length > 1) {
					newKey = lastPart + k;
				} else {
					newKey = lastPart;
				}
				if(lastPart == "[]") { //first time
					current.push(value[k])
				} else {
					current[newKey] = value[k];
				}
			}
		}

		return data;
	}


	init();

});
