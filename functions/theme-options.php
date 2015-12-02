<?php
// ===========================
// Check that ACF is installed & active

function theme_alert_no_acf() {
	?>
	<div class="error">
		<p><strong>Theme Notice:</strong> Advanced Custom Fields is not available. Theme options will not be available. Please install Advanced Custom Fields.</p>
	</div>
	<?php
}

if( !function_exists('acf_add_options_page') ) {
	add_action( 'admin_notices', 'theme_alert_no_acf' );
	return;
}

// ===========================
// Register ACF Options Pages

acf_add_options_sub_page(array(
	'parent' => 'options-general.php',

	'page_title' => 'Social Media',
	'menu_title' => 'Social Media',
	'menu_slug' => 'theme-options-social',
));

acf_add_options_sub_page(array(
	'parent' => 'options-general.php',

	'page_title' => 'Tracking',
	'menu_title' => 'Tracking',
	'menu_slug' => 'theme-options-tracking',
));

include get_template_directory() . '/functions/theme-options/tracking.php';

// Per-page tracking code on page edit screen, see functions/defaults.php
include get_template_directory() . '/functions/theme-options/tracking-pages.php';