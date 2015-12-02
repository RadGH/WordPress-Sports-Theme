jQuery(function() {
	// Enables swipebox for the gallery page
	init_swipebox();

	// Adds/removes body the classes "scrolled-from-top" and "scrolled-past-header", as you scroll down the page.
	init_scroll_tracking();

	// Enable our mobile nav menu
	init_mobile_button( '#mobile-nav-button', '#mobile-nav', '.mobile-inner', 'mobile_nav_open' );
});

function init_swipebox() {
	var $gallery = jQuery('.gallery-photos, .highlight-gallery');
	if ( $gallery.length < 1 ) return;

	$gallery.find('a').swipebox({
		hideBarsDelay: 0
	});
}

function init_scroll_tracking() {
	var $body = jQuery('body');
	var $header = jQuery("#header");

	var header_height = $header.outerHeight(true);

	var state_body = false;
	var state_header = false;

	var updateScrollVariables = function(e) {
		header_height = $header.outerHeight(true);
		updateScrollClasses(e);
	};

	var updateScrollClasses = function(e) {
		var scrollTop = false;

		// scrollingElement saves is some effort, but isn't well supported
		if ( typeof e.target.scrollingElement == 'undefined' ) {
			scrollTop = jQuery(e.target).scrollTop;
		}else{
			scrollTop = e.target.scrollingElement.scrollTop;
		}

		// When scrolling any amount from the top of the page
		if ( scrollTop > 0 ) {
			if ( !state_body ) {
				state_body = true;
				$body.addClass('scrolled-from-top');
			}
		}else{
			if ( state_body ) {
				state_body = false;
				$body.removeClass('scrolled-from-top');
			}
		}

		// When scrolling past the header
		if ( scrollTop > header_height ) {
			if ( !state_header ) {
				state_header = true;
				$body.addClass('scrolled-past-header');
			}
		}else{
			if ( state_header ) {
				state_header = false;
				$body.removeClass('scrolled-past-header');
			}
		}
	};


	var scrollTimeout = false;

	jQuery(window).scroll(function(e) {
		// Modify classes as needed. This only affects the dom if it needs to.
		updateScrollClasses(e);

		// Rate-limited scroll events, to keep us from checking the dom too frequently
		if ( scrollTimeout !== false ) clearTimeout(scrollTimeout);

		scrollTimeout = setTimeout(function() {
			updateScrollVariables(e);
		}, 150);
	});
}

function init_mobile_button( button_selector, navigation_selector, inner_nav_selector, body_class ) {
	if ( typeof button_selector == 'undefined' || typeof navigation_selector == 'undefined' || !button_selector || !navigation_selector ) return;

	var $button = jQuery(button_selector);
	var $nav = jQuery(navigation_selector);

	if ( $button.length < 1 || $nav.length < 1 ) {
		return;
	}

	var $body = jQuery('body');
	var $inner = $nav.find(inner_nav_selector);

	var calculate_menu_offset = function() {
		$nav.children('ul.nav-ul').each(function() {
			if ( jQuery('#mobile-nav').is(':visible') && jQuery(this).outerHeight() ) {
				jQuery(this).css( 'margin-top', -1 * parseInt( jQuery(this).outerHeight() ) );
			}
		});
	};
	
	// ----------------------------

	calculate_menu_offset();

	// Open / Close the nav on clicking the button, using a body class
	$button.click(function() {
		// Close any open submenus
		$nav.find('li.sub-menu-open').removeClass('sub-menu-open');

		// Recalculate menu offset, which is required for the menu to be hidden
		calculate_menu_offset();

		// Toggle the mobile nav menu
		$body.toggleClass( body_class );
		return false;
	});

	// For all submenus, add the menu item as an immediate child of the menu.
	// Unless the first item of the menu has the same title or URL
	// This makes it obvious that dropdown menus are pages themselves.
	$nav.find('li.menu-item').each(function() {
		var $submenu = jQuery(this).children('ul.sub-menu');
		if ( $submenu.length < 1 ) return;

		var href = jQuery(this).children('a:first').attr('href');
		var text = jQuery(this).children('a:first').text();

		// If the menu already has a link to itself as a child item, do not re-create it.
		if ( $submenu.find('a:first').text() == text ) return;
		if ( $submenu.find('a:first').attr('href') == href ) return;

		var $new = jQuery('<li></li>').addClass('menu-item');
		$new.append( jQuery('<a></a>').attr('href', href).text( text ) );

		$submenu.prepend( $new );
	});

	// Clicking a menu item should open up the submenu navigation, if it has one. If it is open, close it.
	$nav.on('click', 'a', function(e) {
		var $link = jQuery(this);
		var $item = $link.parent('li.menu-item');
		var $submenu = $item.children('ul.sub-menu:first');

		if ( $submenu.length > 0 ) {
			// Collapse sibling menus if they are open, as well as their children.
			$item.siblings('li.menu-item.sub-menu-open').each(function() {
				jQuery(this).removeClass('sub-menu-open');
				jQuery(this).find('li.menu-item.sub-menu-open').removeClass('sub-menu-open');
			});

			// Collapse or expand the clicked menu as needed.
			$item.toggleClass('sub-menu-open');

			e.preventDefault();
			return false;
		}
	});

	// Clicking outside of the menu (while the menu is active) should close the menu.
	$nav.click(function(e) {
		if ( $body.hasClass( body_class ) ) {
			if ( $inner.length > 0  && (e.target == $inner[0] ||  $inner.find(e.target).length > 0) ) {
				// If the user clicked in the a menu, do not close the menu
				return true;
			}else{
				// User clicked out of the menu. Hide the menu and abort the action.
				$body.removeClass( body_class );
				$nav.find('.sub-menu-open').removeClass('sub-menu-open');
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
		}
	});
}