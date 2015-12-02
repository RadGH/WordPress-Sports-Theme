<article <?php post_class('loop-archive'); ?>>

	<div class="loop-header">
		<?php the_title( '<h2 class="loop-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</div>

	<div class="loop-meta meta-primary">
		<div class="post-date"><?php the_time(get_option('date_format')); ?></div>
	</div>

	<div class="loop-body clearfix">

		<?php if ( has_post_thumbnail() ) { ?>
		<div class="loop-body-thumbnail">
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail-uncropped' ); ?></a>
		</div>
		<?php } ?>

		<div class="loop-summary">
			<?php the_excerpt(); ?>

			<p class="read-more"><a href="<?php the_permalink(); ?>" class="button">Read More</a></p>
		</div><!-- .loop-summary -->

	</div><!-- .loop-body -->

</article>