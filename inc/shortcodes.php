<?php
/**
 * Shortcodes bundled for use with theme
 *
 * @credits Hybrid Core http://themehybrid.com/hybrid-core
 */

/* Register shortcodes */
add_action( 'init', 'japibas_add_shortcodes' );

/**
 * Creates new shortcodes for use in any shortcode-ready area.  This function uses the add_shortcode() 
 * function to register new shortcodes with WordPress.
 *
 * @since Japibas 2.0
 * @uses add_shortcode() to create new shortcodes.
 * @link http://codex.wordpress.org/Shortcode_API
 * @return void
 */
function japibas_add_shortcodes() {
	add_shortcode( 'the-year', 'japibas_the_year_shortcode' );
	add_shortcode( 'site-link', 'japibas_site_link_shortcode' );
	add_shortcode( 'wp-link', 'japibas_wp_link_shortcode' );
	add_shortcode( 'theme-link', 'japibas_theme_link_shortcode' );
	add_shortcode( 'child-link', 'japibas_child_link_shortcode' );
	add_shortcode( 'loginout-link', 'japibas_loginout_link_shortcode' );
	add_shortcode( 'query-counter', 'japibas_query_counter_shortcode' );
	add_shortcode( 'entry-shortlink', 'japibas_entry_shortlink_shortcode' );
}

/**
 * Shortcode to display the current year.
 *
 * @since Japibas 2.0
 * @uses date() Gets the current year.
 * @return string
 */
function japibas_the_year_shortcode() {
	return date( __( 'Y', 'japibas' ) );
}

/**
 * Shortcode to display a link back to the site.
 *
 * @since Japibas 2.0
 * @uses get_bloginfo() Gets information about the install.
 * @return string
 */
function japibas_site_link_shortcode() {
	return '<a class="site-link" href="' . home_url() . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home"><span>' . get_bloginfo( 'name' ) . '</span></a>';
}

/**
 * Shortcode to display a link to WordPress.org.
 * 
 * @since Japibas 2.0
 * @return string
 */
function japibas_wp_link_shortcode() {
	return '<a class="wp-link" href="http://wordpress.org" title="' . esc_attr__( 'Powered by WordPress, state-of-the-art semantic personal publishing platform', 'japibas' ) . '"><span>' . __( 'WordPress', 'japibas' ) . '</span></a>';
}

/**
 * Shortcode to display a link to the japibas theme page.
 *
 * @since Japibas 2.0
 * @uses get_theme_data() Gets theme (parent theme) information.
 * @return string
 */
function japibas_theme_link_shortcode() {
	$data = get_theme_data( trailingslashit( get_template_directory() ) . 'style.css' );
	return '<a class="theme-link" href="' . esc_url( $data['URI'] ) . '" title="' . esc_attr( $data['Name'] ) . '"><span>' . esc_attr( $data['Name'] ) . '</span></a>';
}

/**
 * Shortcode to display a link to the child theme's page.
 *
 * @since Japibas 2.0
 * @uses get_theme_data() Gets theme (child theme) information.
 * @return string
 */
function japibas_child_link_shortcode() {
	$data = get_theme_data( trailingslashit( get_stylesheet_directory() ) . 'style.css' );
	return '<a class="child-link" href="' . esc_url( $data['URI'] ) . '" title="' . esc_attr( $data['Name'] ) . '"><span>' . esc_html( $data['Name'] ) . '</span></a>';
}

/**
 * Shortcode to display a login link or logout link.
 *
 * @since Japibas 2.0
 * @uses wp_loginout() Creates a login or logout URL.
 * @return string
 */
function japibas_loginout_link_shortcode() {
	return wp_loginout( esc_url( $_SERVER['HTTP_REFERER'] ), false );
}

/**
 * Displays query count and load time if the current user can edit themes.
 *
 * @since Japibas 2.0
 * @uses current_user_can() Checks if the current user can edit themes.
 * @return string
 */
function japibas_query_counter_shortcode() {
	if ( current_user_can( 'edit_theme_options' ) )
		return sprintf( __( 'This page loaded in %1$s seconds with %2$s database queries.', 'japibas' ), timer_stop( 0, 3 ), get_num_queries() );
	return '';
}

/**
 * Displays the shortlinke of an individual entry.
 *
 * @since Japibas 2.0
 * @return string
 */
function japibas_entry_shortlink_shortcode( $attr ) {
	global $post;

	$attr = shortcode_atts(
		array(
			'text' => __( 'Shortlink', 'japibas' ),
			'title' => the_title_attribute( array( 'echo' => false ) ),
			'before' => '',
			'after' => ''
		),
		$attr
	);

	$shortlink = esc_url( wp_get_shortlink( $post->ID ) );

	return $attr['before'] . "<a class='shortlink' href='{$shortlink}' title='" . esc_attr( $attr['title'] ) . "' rel='shortlink'>{$attr['text']}</a>" . $attr['after'];
}

?>