/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 ( function( $ ) {
	const themeContstants = {
		prefix: 'trendy_news_'
	}
	const themeCalls = {
		trendyNewsAjaxCall: function( action, id ) {
			$.ajax({
				method: "GET",
				url: trendyNewsPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: trendyNewsPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).html( response )
						} else {
							$( "head" ).append( '<style id="' + id + '">' + response + '</style>' )
						}
					}
				}
			})
		},
		trendyNewsGenerateLinkTag: function( action, id ) {
			$.ajax({
				method: "GET",
				url: trendyNewsPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: trendyNewsPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).attr( "href", response )
						} else {
							$( "head" ).append( '<link rel="stylesheet" id="' + id + '" href="' + response + '"></link>' )
						}
					}
				}
			})
		}
	}
	
	// theme color bind changes
	wp.customize( 'theme_color', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-color-style', '--theme-color-red')
		});
	});

	// preset 1 bind changes
	wp.customize( 'preset_color_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-1-style', '--tn-global-preset-color-1')
		});
	});

	// preset 2 bind changes
	wp.customize( 'preset_color_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-2-style', '--tn-global-preset-color-2')
		});
	});

	// preset 3 bind changes
	wp.customize( 'preset_color_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-3-style', '--tn-global-preset-color-3')
		});
	});

	// preset 4 bind changes
	wp.customize( 'preset_color_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-4-style', '--tn-global-preset-color-4')
		});
	});

	// preset 5 bind changes
	wp.customize( 'preset_color_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-5-style', '--tn-global-preset-color-5')
		});
	});

	// preset 6 bind changes
	wp.customize( 'preset_color_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-6-style', '--tn-global-preset-color-6')
		});
	});

	// preset gradient 1 bind changes
	wp.customize( 'preset_gradient_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-1-style', '--tn-global-preset-gradient-color-1')
		});
	});

	// preset gradient 2 bind changes
	wp.customize( 'preset_gradient_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-2-style', '--tn-global-preset-gradient-color-2')
		});
	});

	// preset gradient 3 bind changes
	wp.customize( 'preset_gradient_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-3-style', '--tn-global-preset-gradient-color-3')
		});
	});

	// preset gradient 4 bind changes
	wp.customize( 'preset_gradient_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-4-style', '--tn-global-preset-gradient-color-4')
		});
	});

	// preset gradient 5 bind changes
	wp.customize( 'preset_gradient_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-5-style', '--tn-global-preset-gradient-color-5')
		});
	});

	// preset gradient 6 bind changes
	wp.customize( 'preset_gradient_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-6-style', '--tn-global-preset-gradient-color-6')
		});
	});

	// site background color styles 
	wp.customize( 'site_background_color', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.backgroundColor()
		});
	});

	// site block border top
	wp.customize( 'website_block_border_top_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( "body" ).removeClass( "tn_site_block_border_top" )
				$( "body" ).addClass( "tn_site_block_border_top" )
			} else {
				$( "body" ).removeClass( "tn_site_block_border_top" )
			}
		});
	});
	wp.customize( 'website_block_border_top_color', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.blockBorderStyles()
		});
	});
	
	// top header styles
	wp.customize( 'top_header_bottom_border', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.topHeaderStyles()
		});
	});
	wp.customize( 'top_header_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.topHeaderStyles()
		});
	});

	// header styles
	wp.customize( 'header_vertical_padding', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerStyles()
		});
	});
	wp.customize( 'header_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerStyles()
		});
	});
	wp.customize( 'header_menu_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerMenuStyles()
		});
	});
	// scroll to top butto styles 
	wp.customize( 'stt_responsive_option', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});
	wp.customize( 'stt_font_size', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});
	wp.customize( 'stt_border', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});
	wp.customize( 'stt_padding', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});
	wp.customize( 'stt_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});
	wp.customize( 'stt_background_color_group', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.sttButtonStyles()
		});
	});

	// header border
	wp.customize( 'header_menu_bottom_border', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerBorderStyles()
		});
	});
	wp.customize( 'header_menu_bottom_border', function( value ) {
		value.bind( function(to) {
			ajaxFunctions.headerBorderStyles()
		});
	});

	// header menu hover effect 
	wp.customize( 'header_menu_hover_effect', function( value ) {
		value.bind( function(to) {
			$( "#site-navigation" ).removeClass( "hover-effect--one hover-effect--none" )
			$( "#site-navigation" ).addClass( "hover-effect--" + to )
		});
	});

	// scroll to top align
	wp.customize( 'stt_alignment', function( value ) {
		value.bind( function(to) {
			$( "#tn-scroll-to-top" ).removeClass( "align--left align--center align--right" )
			$( "#tn-scroll-to-top" ).addClass( "align--" + to )
		});
	});

	// logo width
	wp.customize( 'trendy_news_site_logo_width', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.siteLogoStyles()
		});
	});

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	});
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	});
	// blog description
	wp.customize( 'blogdescription_option', function( value ) {
		value.bind(function(to) {
			if( to ) {
				$( '.site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
			} else {
				$( '.site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			}
		})
	});

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a' ).css( {
					color: to,
				} );
			}
		} );
	});

	// site description color
	wp.customize( 'site_description_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css( {
				color: to,
			});
		} );
	});

	// site title typo
	wp.customize( 'site_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			ajaxFunctions.siteTitleTypo()
		})
	})

	// bottom footer menu option
	wp.customize( 'bottom_footer_menu_option', function( value ) {
		value.bind( function( to ) {
			if( to ) {
				$( '.bottom-footer .bottom-menu' ).show()
			} else {
				$( '.bottom-footer .bottom-menu' ).hide()
			}
		});
	});

	// single post related posts title
	wp.customize( 'single_post_related_posts_title', function( value ) {
		value.bind( function( to ) {
			$( '.single-related-posts-section .tn-block-title span' ).text( to );
		} );
	});
	// footer styles
	wp.customize( 'footer_top_border', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.footerStyles()
		});
	});

	// constants
	const ajaxFunctions = {
		typoFontsEnqueue: function() {
			var action = themeContstants.prefix + "typography_fonts_url",id ="trendy-news-customizer-typo-fonts-css"
			themeCalls.trendyNewsGenerateLinkTag( action, id )
		},
		backgroundColor : function() {
			var action = themeContstants.prefix + "site_background_color",id ="trendy-news-site-background-color-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		blockBorderStyles : function() {
			var action = themeContstants.prefix + "customizer_site_block_border_top",id ="trendy-news-site-block-border-top-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		sttButtonStyles : function() {
			var action = themeContstants.prefix + "stt_buttons__styles",id ="trendy-news-site-stt-button-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		siteLogoStyles : function() {
			var action = themeContstants.prefix + "site_logo_styles",id ="trendy-news-site-logo-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		siteTitleTypo : function() {
			var action = themeContstants.prefix + "site_title_typo",id ="trendy-news-site-title-typo"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		topHeaderStyles : function() {
			var action = themeContstants.prefix + "top_header_styles",id ="trendy-news-top-header-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		headerStyles : function() {
			var action = themeContstants.prefix + "header_styles",id ="trendy-news-header-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		headerMenuStyles : function() {
			var action = themeContstants.prefix + "header_menu_styles",id ="trendy-news-header-menu-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		headerBorderStyles : function() {
			var action = themeContstants.prefix + "header_border_styles",id ="trendy-news-header-border-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		},
		footerStyles : function() {
			var action = themeContstants.prefix + "footer__styles",id ="trendy-news-footer-styles"
			themeCalls.trendyNewsAjaxCall( action, id )
		}
	}

	// constants
	const helperFunctions = {
		generateStyle: function(color, id, variable) {
			if(color) {
				if( id == 'theme-color-style' ) {
					var styleText = 'body.tn_main_body, body.trendy_news_dark_mode { ' + variable + ': ' + helperFunctions.getFormatedColor(color) + '}';
				} else {
					var styleText = 'body.tn_main_body { ' + variable + ': ' + helperFunctions.getFormatedColor(color) + '}';
				}
				if( $( "head #" + id ).length > 0 ) {
					$( "head #" + id).text( styleText )
				} else {
					$( "head" ).append( '<style id="' + id + '">' + styleText + '</style>' )
				}
			}
		},
		getFormatedColor: function(color) {
			if( color == null ) return
			if( color.includes('preset') ) {
				return 'var(' + color + ')'
			} else {
				return color
			}
		}
	}
}( jQuery ) );