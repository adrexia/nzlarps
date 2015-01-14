/*jslint browser: true*/
/*global $, jQuery*/

$(function() {
	"use strict";

	function updatePreferences(options) {
		var i;

		for(i = 0; i < options.length; i = i + 1) {
			$(options[i]).val(i+1);
		}

	}

	function moveToTop(object) {
		var group = $(object).closest('.preference-group'),
			options;

		group.prepend($(object).closest('.control-group'));

		// update input fields
		options = group.find('.control-group input');
		updatePreferences(options);
	}

	if ($('.preference-select .preference-group') !== undefined){

		$('.preference-select .preference-group .control-group').attr('title', 'Drag and drop to reorder');

		$('.preference-select .preference-group .extra').append('<i class="icon icon-up js-to-top" role="button" title="Move to top"></i>');

		$('.preference-select .preference-group').sortable({
			axis: 'y',
			update: function (event, ui) {
				//update input fields
				var options = ui.item.closest('.preference-group').find('.control-group input');

				updatePreferences(options);
			}
		});


		$('.preference-select .js-to-top').on(Gumby.click, function(e){
			moveToTop(this);
		});

		$('.preference-select .field').on(Gumby.click, function(e) {

			if($(window).width() < 768) {
				moveToTop(this);
			}
		});
	}


});

