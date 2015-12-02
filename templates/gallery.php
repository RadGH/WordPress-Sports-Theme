<?php
/*
Template Name: Gallery
Template Description: Page with custom settings, requires Advanced Custom Fields
*/

global $wp_query;

get_header();
?>

<div class="layout-row no-sidebar clearfix">
	<div class="inside">

		<div id="main">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) : the_post();
					$photos = get_field('photos');
					?>
					<article <?php post_class('loop-single'); ?>>

						<div class="loop-header">
							<?php the_title( '<h1 class="loop-title">', '</h1>' ); ?>
						</div>

						<div class="loop-body">

							<?php if ( get_the_content() ) { ?>
							<div class="loop-content">
								<?php the_content(); ?>
							</div><!-- .loop-content -->
							<?php } ?>

							<?php
							if ( !$photos ) {
								?>
								<div class="gallery-photos-empty">
									<p>We haven't added any gallery photos yet. Check back later.</p>
								</div>
								<?php
							}else{
								// Display the photos
								?>
								<div class="gallery-photos clearfix">
									<?php
									foreach($photos as $photo) {
										$full = wp_get_attachment_image_src( $photo['ID'], 'full' );
										$thumb = wp_get_attachment_image_src( $photo['ID'], 'thumbnail' );

										if ( !$full || !$thumb ) continue;

										?>
										<div class="gallery-item">
											<a href="<?php echo esc_attr($full[0]); ?>" class="lightbox-image"><img src="<?php echo esc_attr($thumb[0]); ?>" alt="<?php echo esc_attr(smart_media_alt($thumb[0])); ?>" width="<?php echo esc_attr($thumb[1]); ?>" height="<?php echo esc_attr($thumb[2]); ?>"></a>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>

						</div><!-- .loop-body -->

					</article>
					<?php
				endwhile;
			}
			?>
		</div>
		<!-- /#main -->

	</div>
	<!-- /.inside -->

</div>
<!-- /.layout-row -->

<?php
get_footer();