<?php
/*
Template Name: Testimonials
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
							$testimonials = get_field( 'testimonials' );

							if ( $testimonials ) {
								?>
								<div class="testimonial-section">
									<?php
									foreach( $testimonials as $entry ) {
										if ( empty($entry) || empty($entry['content']) ) continue;

										$content = $entry['content'];
										$author = $entry['author'];
										$author_contact = $entry['author_contact'];
										?>
										<div class="testimonial-item">
											<div class="testimonial-content"><?php echo wpautop($content); ?></div>

											<?php if ( $author ) { ?>
											<div class="testimonial-author"><?php echo $author; ?></div>
											<?php } ?>

											<?php if ( $author_contact ) { ?>
											<div class="testimonial-contact"><?php echo $author_contact; ?></div>
											<?php } ?>
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