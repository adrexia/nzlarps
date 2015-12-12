/*jslint browser: true*/
/*global $, jQuery*/

$(function() {
	"use strict";


	var sharebutton = new ShareButton({
		networks: {
			facebook: {
				app_id: "448326078706391"
			},
			googlePlus: {
				enabled: false
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
	});

	if($('.tag-field.genre').length > 0){

		$(".tag-field.genre input").tagsInput({
			autocomplete: {
				delay: 0,
				minLength: 1,
				source: $('.genre-list').text().split(","),
				autoFill:true,
				selectFirst: true,
			},
			defaultText:'Add a genre',
			autocomplete_url:'/fake_json_endpoint.html', //required by jquery ui
			height: '30px',
			width: '98%',
			placeholderColor:'rgba(255,255,255,0.3)',
			delimiter:' ',
			removeWithBackspace:true,
		});
	}

	if($('.pagination').length > 0){

			// Pagination - endless
			$('.pagination.endless').ssendless({
					contentSelector: '.pagination-content',
					templates: {
							main:
								'<div class="ss-pagination">'+
										'<a class="btn default medium info rounded" href="#" data-page-number="<%= nextPage %>"><span class="text">Show More</span> <span class="loading-icon"><i class="icon-blank">&nbsp;</i></span></a>'+
								'</div>'
					}
			});

			$('.pagination-wrap.endless-scroll').addClass('ssendless');

			$('.pagination.endless').on('ssendlessbeforepagefetch', function(event){
					$(this).siblings('.ss-pagination').addClass('load').find('a').html('<span class="text">Loading</span> <span class="loading-icon"><i class="icon-cw icon-spin">&nbsp;</i></span>');
			});

			$('.pagination.endless').on('ssendlessafterpagefetch', function(event){
					$(this).siblings('.ss-pagination').removeClass('load').find('a').html('<span class="text">Show More</span> <span class="loading-icon"><i class="icon-blank">&nbsp;</i></span>');
			});

	}

	// SITEMAP
	$('.sitemap').on('click', '.button', function() {
			var self = $(this),
					target = $(self.attr('data-target'));

			// only do an ajax request if the content isn't loaded
			if(target.html().length === 0) {
					self.addClass('loading');

					$.ajax({
							url: self.attr('href'),
							data: { ajax: true }
					}).done(function(data) {
							target.html(data);
							self.removeClass('loading');
					});
			}

			self.toggleClass('open');

			if(self.hasClass('open')) {
					target.removeClass('collapse').addClass('collapsed');
					$(this).attr('aria-expanded', 'true');
					$(this).children('.linkText').replaceWith('<span class="linkText  nonvisual-indicator">Collapse section</span>');
			} else {
					target.removeClass('collapsed').addClass('collapse');
					$(this).attr('aria-expanded', 'false');
					$(this).children('.linkText').replaceWith('<span class="linkText nonvisual-indicator">Expand section</span>');
			}

			return false;
	});

	// Customize validation for user forms. Accessibility fixes
	var siteForm = $('.UserDefinedForm #Form_Form');
	if (siteForm.length > 0) {

			// Set up validation.
			siteForm.validate({
					errorPlacement: function(error, element) {
							var errorId = element.attr('id') + '_message';
							//prevent duplicate labels
							element.closest('div.field').find('label .error').remove();
							error.appendTo(element.closest('div.field'));
							//Make valid html and adjust attributes
							error.removeAttr('for').addClass('message').attr('id', errorId);
							//Link error to input
							element.attr('aria-describedby', errorId);
					},
					errorElement: 'span'
			});

			if(siteForm.find('.requiredField').length > 0){
					siteForm.prepend('<p class="req-indicator-message">Required fields are marked</p>');
			}
	}

});
