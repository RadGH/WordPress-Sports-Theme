<?php
/*

custom_logo_image()
custom_logo_url()
custom_login_title()
	Use the blog information, not wordpress.org

custom_login_footer()
	Adds the "Powered by" logo to the login screen

*/

/* Update Wordpress Login Image */
function custom_logo_image() {
	$logoID = get_field('logo','options');

	if($logoID) {
		$meta = wp_get_attachment_metadata($logoID);
		?>
		<style>
			body.login #login h1 a {
				background: url(<?php echo esc_attr(wp_get_attachment_url($logoID)); ?>) no-repeat center top transparent;
				height: <?php echo $meta['height']; ?>px;
				width: <?php echo $meta['width']; ?>px;
				background-size: contain;
			}
		</style>
		<?php
	}
}
add_action( 'login_head', 'custom_logo_image' );


function custom_logo_url() { return get_bloginfo('url'); }
add_filter( 'login_headerurl', 'custom_logo_url' );


function custom_login_title() { return get_bloginfo('title'); }
add_filter( 'login_headertitle', 'custom_login_title' );


function custom_login_footer() {
	$lm_logo = get_template_directory_uri() . '/includes/images/defaults/radforest-black.png';

	if ( get_option('login_theme_dark') ) {
		$lm_logo = get_template_directory_uri() . '/includes/images/defaults/radforest-white.png';
	}

	echo <<<HTML
  <div id="radforest">
    <a href="http://radforest.com/" target="_blank" class="lm_logo">
      <img src="{$lm_logo}" alt="RadForest Logo" />
    </a>
  </div>
HTML;
}
add_action( 'login_footer', 'custom_login_footer' );