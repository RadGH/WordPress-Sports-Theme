<?php
/*
Template Name: Tournament Results
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
							$entries = get_field( 'tournament_entries' );

							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];
							$entries[] = $entries[0];

							if ( $entries ) {
								?>
								<table class="tourny-table">
									<thead>
									<tr>
										<th class="col-date"><span>Date</span></th>
										<th class="col-tournament"><span>Tournament</span></th>
										<th class="col-location"><span>Location</span></th>
										<th class="col-yards"><span>Yards</span></th>
										<th class="col-scores"><span>Scores</span></th>
										<th class="col-finish"><span>Finish</span></th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach( $entries as $entry ) {
										if ( empty($entry) ) continue;

										$date = $entry['date'];
										$tournament = $entry['tournament'];
										$location = $entry['location'];
										$yards = $entry['yards'];
										$scores = $entry['scores'];
										$finish = $entry['finish'];
										?>
										<tr>
											<td class="col-date"><span><?php echo esc_html($date); ?></span></td>
											<td class="col-tournament"><span><?php echo esc_html($tournament); ?></span></td>
											<td class="col-location"><span><?php echo esc_html($location); ?></span></td>
											<td class="col-yards"><span><?php echo esc_html($yards); ?></span></td>
											<td class="col-scores"><span><?php echo esc_html($scores); ?></span></td>
											<td class="col-finish"><span><?php echo esc_html($finish); ?></span></td>
										</tr>
										<?php
									}
									?>
									</tbody>
								</table>
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