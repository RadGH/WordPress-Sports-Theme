<?php
add_action( 'after_switch_theme', 'theme_install_settings' );
add_action( 'after_setup_theme', 'theme_setup_settings' );
add_action( 'switch_theme', 'theme_uninstall_settings' );

function theme_install_settings() {
	global $LD_THEME;

	// Store the default sizes to restore if the theme changes.
	$default_sizes = array(
		get_option( 'thumbnail_size_w', 150 ),
		get_option( 'thumbnail_size_h', 150 ),
		get_option( 'thumbnail_crop', 1 ),

		get_option( 'medium_size_w', 300 ),
		get_option( 'medium_size_h', 300 ),
		get_option( 'medium_crop', 0 ),

		get_option( 'large_size_w', 1024 ),
		get_option( 'large_size_h', 1024 ),
		get_option( 'large_crop', 0 ),
	);

	update_option( 'ld_default_image_sizes', $default_sizes, false );

	update_option( 'thumbnail_size_w', $LD_THEME['images-default']['thumbnail'][0] );
	update_option( 'thumbnail_size_h', $LD_THEME['images-default']['thumbnail'][1] );
	update_option( 'thumbnail_crop',   $LD_THEME['images-default']['thumbnail'][2] ? 1 : 0 );

	update_option( 'medium_size_w', $LD_THEME['images-default']['medium'][0] );
	update_option( 'medium_size_h', $LD_THEME['images-default']['medium'][1] );
	update_option( 'medium_crop', $LD_THEME['images-default']['medium'][2] ? 1 : 0 );

	update_option( 'large_size_w', $LD_THEME['images-default']['large'][0] );
	update_option( 'large_size_h', $LD_THEME['images-default']['large'][1] );
	update_option( 'large_crop', $LD_THEME['images-default']['large'][2] ? 1 : 0 );
}

function theme_setup_settings() {
	global $LD_THEME;

	// Enable header images
	if ( !empty($LD_THEME['images-default']['header-image']) ) {
		$args = array(
			'width' => $LD_THEME['images-default']['header-image'][0],
			'height' => $LD_THEME['images-default']['header-image'][1],
			'header-text' => false,
		);

		add_theme_support( 'custom-header', $args );
	}

	// Register custom image sizes
	foreach( $LD_THEME['images-custom'] as $key => $img ) {
		add_image_size( $key, $img[0], $img[1], $img[2] );
	}

	// Enable RSS feed channels in the document header
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress handle the title tag
	add_theme_support( 'title-tag' );

	// Enable featured images for posts and pages
	add_theme_support( 'post-thumbnails' );

	// Enable HTML5 for the specified templates
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
}

function theme_uninstall_settings() {
	// Restore previous theme's image settings
	$default_sizes = get_option( 'ld_default_image_sizes' );

	$keys = array(
		'thumbnail_size_w',
		'thumbnail_size_h',
		'thumbnail_crop',
		'medium_size_w',
		'medium_size_h',
		'medium_crop',
		'large_size_w',
		'large_size_h',
		'large_crop',
	);

	foreach( $keys as $k ) {
		if ( isset($default_sizes[$k]) ) update_option( $k, $default_sizes[$k] );
	}

	delete_option( 'ld_default_image_sizes' );
}