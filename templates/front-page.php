<?php
/*
Template Name: Front Page
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
							$academic_title = get_field('highlights_academic_title');
							$academic = get_field('highlights_academic', get_the_ID(), false); // No formatting
							$athletic_title = get_field('highlights_athletic_title');
							$athletic = get_field('highlights_athletic', get_the_ID(), false); // No formatting

							if ( $academic || $athletic ) {
								?>
								<div class="highlight-section">
									<?php
									if ( $academic ) {
										if ( !$academic_title ) $academic_title = 'Academic/Community Leadership';
										$split = preg_split( '/(\r\n|\r|\n)+/', $academic );
										?>
										<div class="highlight-academic">
											<div class="icon icon-book"></div>
											<div class="highlight-content">
												<p><strong><?php echo esc_html($academic_title); ?></strong></p>
												<ul class="ul-disc"><?php
													foreach($split as $line) {
														$line = trim($line);
														if ( !$line ) continue;
														?>
														<li><?php echo esc_html($line); ?></li>
														<?php
													}
												?></ul>
											</div>
										</div>
										<?php
									}



									if ( $athletic ) {
										if ( !$athletic_title ) $athletic_title = 'Athletic Accomplishments';
										$split = preg_split( '/(\r\n|\r|\n)+/', $athletic );
										?>
										<div class="highlight-academic">
											<div class="icon icon-book"></div>
											<div class="highlight-content">
												<p><strong><?php echo esc_html($athletic_title); ?></strong></p>
												<ul class="ul-disc"><?php
													foreach($split as $line) {
														$line = trim($line);
														if ( !$line ) continue;
														?>
														<li><?php echo esc_html($line); ?></li>
														<?php
													}
												?></ul>
											</div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>

						</div><!-- .loop-body -->


							<?php
							$gallery = get_field('photo_strip');

							if ( $gallery ) {
								?>
								<div class="gallery-photos highlight-gallery clearfix">
									<?php
									foreach( $gallery as $photo ) {
										$full = wp_get_attachment_image_src( $photo['ID'], 'full' );
										$thumb = wp_get_attachment_image_src( $photo['ID'], 'thumbnail' );

										if ( !$full || !$thumb ) continue;

										?><div class="gallery-item">
											<a href="<?php echo esc_attr($full[0]); ?>" class="lightbox-image"><img src="<?php echo esc_attr($thumb[0]); ?>" alt="<?php echo esc_attr(smart_media_alt($thumb[0])); ?>" width="<?php echo esc_attr($thumb[1]); ?>" height="<?php echo esc_attr($thumb[2]); ?>"></a>
										</div><?php
									}
									?>
								</div>
								<?php
							}
							?>

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