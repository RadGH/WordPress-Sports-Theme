<!doctype html>
<html <?php language_attributes(); ?> class="<?php ld_html_classes( 'no-js' ); ?>">
<head>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="site">

	<?php
	$class = 'no-image';
	$header_css = '';

	// The front page template can use a large header image, which appears beneath the header text & menu.
	if ( get_post_type() == 'page' ) {
		$header_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		if ( $header_image ) {
			$header_css = 'style="background-image: url('.esc_attr($header_image[0]).');"';
			$class = 'has-image';
		}
	}
	?>
	<header id="header" class="<?php echo $class; ?>" <?php echo $header_css; ?>>
		<div class="inside">
			<?php
			$title = get_bloginfo('name');
			$menu = ld_nav_menu( 'header', 'primary' )
			?>
			<h1 class="header-title"><a href="<?php echo esc_attr(site_url()); ?>"><?php echo $title; ?></a></h1>

			<nav class="nav-menu nav-header nav-primary"><?php echo $menu; ?></nav>
		</div>

		<?php
		// Mobile Nav Button
		if ( has_nav_menu('mobile_primary') || has_nav_menu('mobile_secondary') ) {
			?>
			<button id="mobile-nav-button">
				<span class="mobile-text"><span class="mobile-hidden">Menu</span><span class="mobile-visible">Close</span></span>
				<span class="bar bar-1"></span>
				<span class="bar bar-2"></span>
				<span class="bar bar-3"></span>
			</button>
			<?php
		}
		?>
	</header> <!-- /#header -->

	<?php
	// Mobile Nav Menu
	if ( has_nav_menu('mobile_primary') || has_nav_menu('mobile_secondary') ) {
		?>
		<div id="mobile-nav">
			<div class="inside">
				<div class="mobile-outer">
					<div class="mobile-inner">
						<?php
						if ( $menu = ld_nav_menu( 'mobile', 'primary' ) ) {
							echo '<nav class="nav-menu nav-mobile nav-primary">';
							echo $menu;
							echo '</nav>';
						}

						if ( $menu = ld_nav_menu( 'mobile', 'secondary' ) ) {
							echo '<nav class="nav-menu nav-mobile nav-secondary">';
							echo $menu;
							echo '</nav>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>

	<div id="content">