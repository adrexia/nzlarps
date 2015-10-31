/*jslint browser: true*/
/*global $, jQuery*/

$(function() {
	"use strict";

	function setFilter (filterBy){
		$('.js-filters').find('.success').removeClass('success');
		$('.label[data-filter="'+filterBy+'"]').addClass('success');
		$container.isotope({ filter: filterBy });
	}

	// init Isotope
	var $container = $('.js-isotope').isotope({
		itemSelector: '.item',
		layoutMode: 'masonry',
		gutter: 10,
		resizesContainer: true
	}),
	hash = window.location.hash.substring(1),
	genreClass = '.' + hash;

	$('.js-filters').on( 'click', '.label', function() {
		setFilter($(this).attr('data-filter'));
	});

	// Apply from anchor
	if(hash && $('#' + hash).length < 1){
		if($(genreClass).length > 0 && $('.js-isotope').length > 0 ){
			// fixes bug where filter doesn't clear after having been set
			setTimeout(function(){
				$('.label[data-filter="'+genreClass+'"]').trigger('click');
			}, 5);
		}
	}

	setTimeout(function(){
		$container.isotope('layout');
	}, 500);

});
