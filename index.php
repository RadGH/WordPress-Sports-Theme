<?php
global $wp_query;

get_header( 'simple' );
?>

<div class="layout-row no-sidebar clearfix">
	<div class="inside">

		<div id="main">
			<?php
			if ( have_posts() ) {

				while ( have_posts() ) : the_post();

					if ( is_singular() ) {
						get_template_part( 'views/single', get_post_type() );
					}else{
						get_template_part( 'views/archive', get_post_type() );
					}

				endwhile;

				if ( is_archive() && $wp_query->max_num_pages > 1 ) {
					$args = apply_filters('archive-pagination-args', array());

					echo '<div class="pagination clearfix">';
					echo paginate_links( $args );
					echo '</div>';
				}

			}else{
				get_template_part( 'views/404', get_post_type() );
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