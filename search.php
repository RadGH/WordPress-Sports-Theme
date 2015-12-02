<?php
/*
Template Name: Search
Template Description: Displays the search page
*/

global $wp_query;

$search_title = "Search";
$search_content = "Enter a search term below, then click search.";


if ( $wp_query->is_page() ) {

	// We're on a static page using the search template. Use a blank query as the search results.
	global $post;

	$search_title = $post->post_title;
	$search_content = $post->post_content;

	$page_query = $wp_query; // This query is the page query.
	$search_query = new WP_Query(); // Blank query as the search query.

}else{

	// We're on a pre-generated search archive.
	// Get the default search page if one is using the search template (this file)
	$args = array(
		'post_type' => 'page',
		'meta_query' => array(
			array(
				'key' => '_wp_page_template',
				'value' => 'search.php'
			)
		),
		'posts_per_page' => '1',
	);

	$page_query = new WP_Query( $args );

	if ( $page_query->have_posts() ) {
		$search_title = $page_query->posts[0]->post_title;
		$search_content = $page_query->posts[0]->post_content;
	}

	$search_query = $wp_query;
}

if ( $search_query->have_posts() ) {
	// The user found something in their search.
	$search_title = sprintf(
		'Found %s %s',
		$search_query->found_posts,
		($search_query->found_posts == 1) ? 'result' : 'results'
	);

	if ( !empty($_REQUEST['s']) ) {
		$search_content = sprintf(
			'You searched for "%s".',
			esc_html( stripslashes( $_REQUEST['s'] ) )
		);
	}
}else if ( isset($_REQUEST['s']) ) {
	// No results were found, and the user was searching for something.
	$search_title = 'No results found';
	$search_content = "Your search for <em>&quot;". esc_html(stripslashes($_REQUEST['s'])) ."&quot;</em> was not found.";
}


$article_id = "post-search";

if ( $page_query->have_posts() ) {
	$article_id = 'post-' . $page_query->posts[0]->ID;
}

$header_image = get_header_image();

get_header( 'simple' );
?>
<div class="header-image-wrap <?php echo $header_image ? 'has-header-image' : 'no-header-image'; ?>">

	<?php if ( $header_image ) { ?>
	<div class="header-image">
		<div class="inside">
			<img src="<?php echo esc_attr($header_image); ?>" alt="<?php echo esc_attr( smart_media_alt($header_image) ); ?>">
		</div>
	</div>
	<?php } ?>


	<div class="layout-row has-sidebar clearfix">
		<div class="inside">

			<div id="main">

				<article id="<?php echo esc_attr( $article_id ); ?>" <?php post_class('loop-single loop-search loop-search-main'); ?>>

					<?php if ( $search_title ) { ?>
						<div class="loop-header">
							<h1 class="loop-title"><?php echo esc_html( $search_title ); ?></h1>

							<?php if ( $search_content ) { ?>
								<h3 class="loop-subtitle"><?php echo do_shortcode( $search_content ); ?></h3>
							<?php } ?>
						</div>
					<?php } ?>

					<?php get_search_form(); ?>

				</article><!-- #post-## -->

				<?php
				if ( $search_query->have_posts() ) {
					?>
					<div class="search-result-container">

						<?php
						global $wp_query;
						$wp_query = $search_query;

						sports_pagination();

						while ( $search_query->have_posts() ) : $search_query->the_post();

							$templates = array(
								'views/search-' . get_post_type() . '.php',
								'views/search.php',
								'views/archive-' . get_post_type() . '.php',
								'views/archive.php'
							);

							// Pick the first template from the above array and load it.
							// This allows us to fall back to an archive template if no search template is available.
							$locate_search = locate_template( $templates );

							if ( $locate_search ) include( $locate_search );

						endwhile;

						sports_pagination(false);

						wp_reset_query();
						?>

					</div>

					<?php
				}
				?>
			</div>
			<!-- /#main -->

			<div id="sidebar">
				<?php get_sidebar(); ?>
			</div>

		</div>
		<!-- /.inside -->

	</div>
	<!-- /.layout-row -->

</div>
<!-- .header-image-wrap -->

<?php
get_footer();