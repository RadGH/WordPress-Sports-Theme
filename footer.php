	</div> <!-- /#content -->

	<footer id="footer">
		<div class="inside clearfix">
			<div class="footer-right">
				<div class="copyright">
					<p>
						<a href="http://radforest.com/" target="_blank" rel="external"><img src="<?php echo get_stylesheet_directory_uri(); ?>/includes/images/defaults/radforest-white.png" alt="Powered by RadForest"></a><br>
						&copy;2015 Copyright Camille Dozois<br>
						All Rights Reserved
					</p>
				</div>
			</div>

			<div class="footer-left">
				<?php
				if ( $menu = ld_nav_menu( 'footer', 'primary' ) ) {
					echo '<nav class="nav-menu nav-footer nav-primary">';
					echo $menu;
					echo '</nav>';
				}

				if ( $menu = ld_nav_menu( 'footer', 'secondary' ) ) {
					echo '<nav class="nav-menu nav-footer nav-secondary">';
					echo $menu;
					echo '</nav>';
				}
				?>
			</div>

		</div>
	</footer> <!-- /#footer -->

</div> <!-- /#site -->
<?php wp_footer(); ?>
</body>
</html>