( function( $ ) {
	"use strict";

	$(document).on('click', '.news-element-notice .button-primary', function( e ) {
     
		if ( 'install-activate' === $(this).data('action') && ! $( this ).hasClass('init') ) {
			var $self = $(this),
				$href = $self.attr('href');

			$self.addClass('init');

			$self.html('Installing News Element Addon <span class="dot-flashing"></span>');

			var elementorData = {
				'action' : 'news_element_install_active_elementor',
				'nonce' : news_element_localize.elementor_nonce
			};

			// Send Request.
			$.post( news_element_localize.ajax_url, elementorData, function( response ) {

				if ( response.success ) {
					console.log('elementor installed');

					// Both Plugins Installed
					if ( true === response.data.plugins_updated ) {
						setTimeout(function() {
							$self.html('Redirecting to News Element Addon <span class="dot-flashing"></span>');

							setTimeout( function() {
								window.location = $href;
							}, 1000 );
						}, 500);

						console.log('news element addon installed');

						return false;
					}

					var ThePackData = {
						'action' : 'news_element_install_activate_addon',
						'nonce' : news_element_localize.news_element_addon_nonce
					};

					$.post( news_element_localize.ajax_url, ThePackData, function( response ) {
						if ( response.success ) {

							var elementorRedirect = {
								'action' : 'news_element_prevent_elementor_redirect',
							};

							$.post( news_element_localize.ajax_url, elementorRedirect, function( response ) {
								console.log('news element addon installed');

								setTimeout(function() {
									$self.html('Redirecting to News Element Addon <span class="dot-flashing"></span>');

									setTimeout( function() {
										window.location = $href;
									}, 1000 );
								}, 500);
							});

						}
					});

				}

			} ).fail( function( xhr, textStatus, e ) {
				$(this).parent().after( `<div class="plugin-activation-warning">${news_element_localize.failed_message}</div>` );
			} );

			e.preventDefault();
		}
	} );

} )( jQuery );
