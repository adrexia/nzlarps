/*jslint browser: true*/
/*global $, jQuery*/

$(function() {
	"use strict";

	function init() {
		setupForms();
		setupShare();
		setupPagination();
		attachEvents();
	}

	function setupForms() {
		var form = $('form');

		if (form.length < 1) {
			return;
		}

        form.parsley();

		setTimeout(function() {
			$('.colorpalette input').off();
		}, 1000);

		applyEditor();
	}

	function getEditorSettings() {
		return {
			toolbar: {
				anchorInputPlaceholder: 'Type a link',
				buttons: ['bold', 'italic', 'quote', 'anchor', 'link', 'orderedlist', 'unorderedlist', 'h3', 'h4', 'removeFormat'],
				cleanPastedHTML: true,
				diffLeft: 20,
				diffTop: 10,
			},
			placeholder: {
				text: '',
				hideOnClick: true
			},
			paste: {
				forcePlainText: false,
				cleanPastedHTML: true,
				cleanAttrs: ['class', 'style', 'dir'],
				cleanTags: ['meta', 'ul', 'div', 'script', 'section', 'aside', 'article']
			}
		};
	}

	function attachEvents() {

		var endless = $('.pagination.endless');

		$( "form" ).submit(function( event ) {
			var editable = $('.editable'),
				value = editable.html();

			editable.parent().find('textarea').val(value);
		});

		endless.on('ssendlessbeforepagefetch', function (event) {
			$(this).siblings('.ss-pagination')
				.addClass('load')
				.find('a')
				.html('<span class="text">Loading</span> <span class="loading-icon"><i class="icon-cw icon-spin">&nbsp;</i></span>');
		});

		endless.on('ssendlessafterpagefetch', function (event) {
			$(this).siblings('.ss-pagination')
				.removeClass('load')
				.find('a')
				.html('<span class="text">Show More</span> <span class="loading-icon"><i class="icon-blank">&nbsp;</i></span>');
		});
	}

	function  applyEditor() {
		if($('.editable').length < 1) {
			return;
		}

		var editor  = new MediumEditor('.editable',  getEditorSettings()),
			editable = $('.editable'),
			value = editable.parent().find('textarea').val();

		editable.html(value);
	}

	function getShareConfig() {
		return {
			networks: {
				facebook: {
					app_id: "448326078706391"
				},
				reddit: {
					enabled: false
				},
				linkedin: {
					enabled: false,
				},
				whatsapp: {
					enabled: false
				},
				email: {
					enabled: false
				}
			}
		};
	}

	function setupShare() {

		if ($('.share-wrapper').length < 1) {
			return;
		}

		new ShareButton(getShareConfig());
	}


	function setupPagination() {

		if ($('.pagination').length < 1) {
			return;
		}

		var endless = $('.pagination.endless');

		// Pagination - endless
		endless.ssendless({
			contentSelector: '.pagination-content',
			templates: {
				main:
				'<div class="ss-pagination">' +
				'<a class="btn default medium info rounded" href="#" data-page-number="<%= nextPage %>"><span class="text">Show More</span> <span class="loading-icon"><i class="icon-blank">&nbsp;</i></span></a>' +
				'</div>'
			}
		});

		$('.pagination-wrap.endless-scroll').addClass('ssendless');
	}

	init();

});