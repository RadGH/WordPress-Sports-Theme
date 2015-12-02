<?php
/* ===========================

Table of Contents:

  1. Theme Function Files
  2. Plugin Functions
  3. Menus & Sidebars
  4. Widgets
  5. Shortcodes

=========================== */

global $LD_THEME;

$LD_THEME = array(
	// Installed on theme activation via /functions/install.php:
	'images-default' => array(
		'thumbnail' => array( 360, 360, true ),
		'medium' => array( 720, 720, true ),
		'large' => array( 2030, 700, true ),
	),
	'images-custom' => array(
		'rssfeed-landscape' => array( 560, 280, true ), // Used for blog post featured images in the rss feed
	),
);

// ===========================
// 1. Theme Function Files

include_once 'includes/admin/editor-styles.php'; // Custom admin editor styles
include_once 'functions/install.php';            // Functions triggered when the theme is first activated
include_once 'functions/enqueue.php';            // Includes various CSS/JS files used throughout the theme
include_once 'functions/utility.php';            // A variety of custom functions to use within the theme
include_once 'functions/defaults.php';           // Customize Wordpress default settings, such as the "From" address in emails
include_once 'functions/admin.php';              // Customizations to the admin section, admin bar, dashboard, etc
include_once 'functions/login.php';              // Use custom logo, blog url, etc. for the login screen
include_once 'functions/menus.php';              // Set up our menus and hook into menu displaying functionality
include_once 'functions/sharing.php';            // Allows us to create various sharing links for a page.
include_once 'functions/rss.php';                // Improves RSS feeds, adds featured images and image size
include_once 'functions/theme-options.php';      // ACF Theme options pages
include_once 'functions/template-tags.php';      // Functions that are utilized within the theme's template files
include_once 'functions/pagination.php';         // Features for pagination
include_once 'functions/class_contactForm.php';  // Contact form class for sending to multiple emails from a single gform.

// Fallback functions to keep the theme from giving fatal errors when dependencies are not installed.
add_action( 'plugins_loaded', 'ld_declare_fallbacks', 30 );

function ld_declare_fallbacks() {
	include_once 'functions/fallbacks.php';
}

// ===========================
// 2. Plugin Functions

global $seo_ultimate;
if ( isset($seo_ultimate) ) {
	include_once 'plugin-addons/seo-ultimate.php';
}

if ( class_exists('WooCommerce') ) {
	include_once 'plugin-addons/woocommerce.php';
	include_once 'plugin-addons/woocommerce-cart-data.php';
}

if ( class_exists('acf') ) {
	include_once 'plugin-addons/advanced-custom-fields.php';
}

// ===========================
// 3. Menus & Sidebars

function define_menus() {
	$menus = array(
		'header_primary'   => 'Header - Primary',
		'header_secondary' => 'Header - Secondary',

		'footer_primary'   => 'Footer - Primary',
		'footer_secondary' => 'Footer - Secondary',

		'mobile_primary'   => 'Mobile - Primary',
		'mobile_secondary' => 'Mobile - Secondary',
	);

	$sidebars = array(
		'sidebar'    => array(
			'Sidebar',
			'Used when a more specific sidebar is not in use.',
		),
		'blog'       => array(
			'Blog',
			'For the blog homepage, and any blog related sections.',
		),
		'front-page' => array(
			'Front Page',
			'Used on the front page.',
		),
		'store'      => array(
			'Store',
			'Used on WooCommerce store related pages.',
		),
		'checkout'   => array(
			'Checkout',
			'Used on the checkout screen of WooCommerce.',
		),
		'search'     => array(
			'Search',
			'Used on the search page.',
		),
	);

	// Register the menus & sidebars
	register_nav_menus($menus);

	foreach ( $sidebars as $key => $bar ) {
		register_sidebar( array(
			'id'          => $key,
			'name'        => $bar[0],
			'description' => $bar[1],

			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
	}
}
add_action( 'after_setup_theme', 'define_menus' );

// ===========================
// 4. Widgets
include_once 'widgets/textButtonWidget.php';

// ===========================
// 5. Shortcodes
function theme_register_shortcodes() {
	include_once 'shortcodes/copyright.php'; // copy, reg, tm, year
	include_once 'shortcodes/button.php'; // Allows you to easily render buttons onto pages.
	include_once 'shortcodes/ll_accordian.php'; //Accordian shortcode.  Does not provide animation or styling, only sets classes.
	include_once 'shortcodes/ll_columns.php';  //Create multiple columns on standard content pages.
}
add_action( 'init', 'theme_register_shortcodes' );