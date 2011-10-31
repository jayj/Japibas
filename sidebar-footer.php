<?php
/**
 * The Footer widget areas.
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'footer-area-1'  )
		&& ! is_active_sidebar( 'footer-area-2' )
		&& ! is_active_sidebar( 'footer-area-3'  )
	)
		return;
	// If we get this far, we have widgets. Let do this.
	
	$count = 0;

	if ( is_active_sidebar( 'footer-area-1' ) )
		$count++;

	if ( is_active_sidebar( 'footer-area-2' ) )
		$count++;

	if ( is_active_sidebar( 'footer-area-3' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}
?>


<div id="footer-columns" class="<?php echo esc_attr( $class ); ?> clearfix">
	<?php if ( is_active_sidebar( 'footer-area-1' ) ) : ?>
	<div id="first-footer-col" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'footer-area-1' ); ?>
	</div> <!-- #first-footer-col .widget-area -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'footer-area-2' ) ) : ?>
	<div id="second-footer-col" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'footer-area-2' ); ?>
	</div> <!-- #second-footer-col .widget-area -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'footer-area-3' ) ) : ?>
	<div id="third-footer-col" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'footer-area-3' ); ?>
	</div> <!-- #third-footer-col .widget-area -->
	<?php endif; ?>
</div><!-- #footer-columns -->