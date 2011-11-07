
	<div class="clear"></div>

</div> <!-- #main -->

<footer id="colophon" role="contentinfo">

	<?php 
		$footer_text = japibas_get_setting( 'footer_text' );
		echo htmlspecialchars_decode( do_shortcode( $footer_text ) );
	?>

	<div class="clear"></div>

	<?php
		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with three columns of widgets.
		*/
		get_sidebar( 'footer' );
	?>

</footer> <!-- #colophon -->

</div> <!-- #wrapper -->

    <?php wp_footer(); ?>

</body>
</html>