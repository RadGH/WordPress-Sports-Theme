<?php
$sidebar = 'sidebar';

if ( is_home() || is_post_type_archive('post')|| is_category() || is_tax() || get_post_type() == 'post' ) {
	$sidebar = 'blog';
}

if ( is_front_page() ) {
	$sidebar = 'front-page';
}

if ( class_exists('WooCommerce') ) {
	if ( is_woocommerce() ) $sidebar = 'store';

	// Checkout and cart page
	if ( ld_is_woocommerce_page() ) $sidebar = 'checkout';
}

if ( is_search() ) {
	$sidebar = 'search';
}

// ----------------------------------------------------------------

if ( is_active_sidebar( $sidebar ) ) {
	$classes = array( 'sidebar' );
	if ( $sidebar !== 'sidebar' ) $classes[] = 'sidebar-' . $sidebar;
	else $classes[] = 'sidebar-default';

	?>
	<section class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<div class="sidebar-inner">
			<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	</section>
	<?php
}