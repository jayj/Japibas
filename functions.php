<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

add_action( 'after_setup_theme', 'japibas_setup' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Japibas 2.0
 */
function japibas_setup() {

	define( 'THEMEVERSION', '2.0' );

	$template_directory = get_template_directory();

	add_custom_background();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'japibas' ) );

	/* Load JavaScript and CSS styles */
	add_action( 'wp_enqueue_scripts', 'japibas_enqueue_scripts' );

	/* Sidebars */
	add_action( 'widgets_init', 'japibas_sidebars' );

	/* Add new image sizes */
	add_image_size( 'small', 100, 100, true );
	add_image_size( 'slider', 480, 220, true );
	add_image_size( 'slider-large', 920, 220, true );

	/* Load the "Get the Image" extension */
	include( $template_directory . '/inc/get-the-image.php' );

	/* Load the shortcodes */
	include( $template_directory . '/inc/shortcodes.php' );

	/* Load custom widgets */
	require( $template_directory . '/inc/widgets.php' );

	/* Load up the theme options page and related code */
	require( $template_directory . '/inc/theme-options.php' );

	/* Load metaboxes and upgrade functionality */
	if ( is_admin() ) {
		require_once( $template_directory . '/inc/metabox.php' );
		require_once($template_directory . '/inc/upgrade.php' );
	}

	/* Remove default gallery style */
	add_filter( 'use_default_gallery_style', '__return_false' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'japibas', $template_directory . '/languages' );

	$locale = get_locale();
	$locale_file = $template_directory . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

}

/**
 * Loads the theme JavaScript files
 *
 * @since Japibas 2.0
 */
function japibas_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );

	// Load slider script
	if ( japibas_get_setting( 'slider_category' ) && ( is_home() || is_front_page() ) )
		wp_enqueue_script( 'sudoSlider', get_template_directory_uri() . '/js/jquery.sudoSlider.min.js', array( 'jquery' ), '2.1.6', true );

	// Load the theme JS
	wp_enqueue_script( 'japibas-theme', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '2.0', true );

	// Load Open Sans font
	wp_enqueue_style( 'Open-Sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700' );
}

/**
 * Register widgetized areas, including one sidebar, a 404 page, single post and four column widget-ready footer.
 */
function japibas_sidebars() {

	// Register the Related Posts widget
	register_widget( 'Japibas_Related_Posts_Widget' );

	// Sidebar
	register_sidebar( array (
		'name' => __( 'Sidebar', 'japibas' ),
		'id' => 'sidebar-widgets',
		'description' => __( 'Widgets for the sidebar', 'japibas' ),
		'before_widget' => '<aside class="widget %2$s" id="%1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	// Single post
	register_sidebar( array (
		'name' => __( 'Single Post', 'japibas' ),
		'id' => 'single-widgets',
		'description' => __( 'These widgets will be displayed after the content on single posts.', 'japibas' ),
		'before_widget' => '<aside class="widget single-widget %2$s" id="%1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Footer
	register_sidebar( array(
		'name' => __( 'Footer Area One', 'japibas' ),
		'id' => 'footer-area-1',
		'description' => __( 'An optional widget area for your site footer', 'japibas' ),
		'before_widget' => '<aside class="footer-widget %2$s" id="%1$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'japibas' ),
		'id' => 'footer-area-2',
		'description' => __( 'An optional widget area for your site footer', 'japibas' ),
		'before_widget' => '<aside class="footer-widget %2$s" id="%1$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'japibas' ),
		'id' => 'footer-area-3',
		'description' => __( 'An optional widget area for your site footer', 'japibas' ),
		'before_widget' => '<aside class="footer-widget %2$s" id="%1$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	// 404 page
	register_sidebar( array (
		'name' => __( '404 Page', 'japibas' ),
		'id' => 'error-page-widgets',
		'description' => __( 'Widgets for the 404 error page', 'japibas' ),
		'before_widget' => '<aside class="widget %2$s" id="%1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

/**
 * Add extra body classes
 *
 * @since 1.0
 */
function japibas_body_class( $classes ) {

	$options = japibas_get_theme_options();

	// Is it a singular page? (posts, pages, attachments)
	if ( is_singular() )
		$classes[] = 'singular';

	// Slider
	if ( japibas_get_setting( 'slider_category' ) && ( is_home() || is_front_page() || is_single() ) )
		$classes[] = 'slider';
	else
		$classes[] = 'no-slider';

	// Slider is disabled
	if ( ! $options['slider_category'] )
		$classes[] = 'slider-disabled';

	// No sidebar on 404 pages
	if ( is_404() )
		$classes[] = 'no-sidebar';

	// Add the layout classes
	$classes[] = sanitize_html_class( $options['theme_layout'] );

	// Add current color scheme
	$classes[] = 'color-scheme-' . sanitize_html_class( $options['color_scheme'] );

	return $classes;
}

add_filter( 'body_class', 'japibas_body_class' );

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Japibas 2.0
 * @return string|bool URL or false when no link is present.
 */
function japibas_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Loads the Japibas theme settings once and allows the input of the specific field the user would
 * like to show.
 *
 * @since Japibas 2.0
 * @uses get_option() Gets an option from the database.
 * @param string $option The specific theme setting the user wants.
 * @return string|int|array $settings[$option] Specific setting asked for.
 */
function japibas_get_setting( $option = '' ) {

	if ( ! $option )
		return false;

	$japibas_settings = get_option( 'japibas_theme_options' );

	if ( ! is_array( $japibas_settings ) || empty( $japibas_settings[$option] ) )
		return false;

	if ( is_array( $japibas_settings[$option] ) )
		return $japibas_settings[$option];
	else
		return wp_kses_stripslashes( $japibas_settings[$option] );
}

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function japibas_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_length', 'japibas_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function japibas_continue_reading_link() {
	return ' <a href="' . get_permalink() . '" class="excerpt-more-link">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'japibas' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and japibas_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function japibas_auto_excerpt_more( $more ) {
	return ' &hellip;' . japibas_continue_reading_link();
}

add_filter( 'excerpt_more', 'japibas_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function japibas_custom_excerpt_more( $output ) {

	if ( has_excerpt() && ! is_attachment() )
		$output .= japibas_continue_reading_link();

	return $output;
}
add_filter( 'get_the_excerpt', 'japibas_custom_excerpt_more' );

/**
 * Add contact methods 
 *
 * @since Japibas 2.0
 */
function japibas_contactmethods( $contactmethods ) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['google_profile'] = 'Google Profile URL';

	return $contactmethods;
}

add_filter( 'user_contactmethods', 'japibas_contactmethods', 10, 1 );

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since 1.0
 */
function japibas_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'japibas' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'japibas' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
						<?php
							// Avatar size: 42px for normal comments, 32px for replies
                            $avatar_size = 42;
                            if ( '0' != $comment->comment_parent )
                                $avatar_size = 32;

                            echo get_avatar( $comment, $avatar_size );
                        ?>

                        <?php printf( __( '%s <span class="says">says:</span>', 'japibas' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                    </div> <!-- .comment-author .vcard -->

                    <div class="commentmetadata">
                    	<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
								/* translators: 1: date, 2: time */
								printf( __( '%1$s at %2$s', 'japibas' ), get_comment_date(),  get_comment_time() );
							?>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'japibas' ), ' ' ); ?>
                    </div> <!-- .comment-meta .commentmetadata -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'japibas' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'japibas' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

/**
 * Paginate page navigation
 *
 * @credits http://wpengineer.com/2133/wordpress-pagination-again/
 */
function japibas_paginate_links( $args = '' ) {

    global $wp_rewrite, $wp_query;

    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

    $defaults = array(
        'base' => @add_query_arg( 'paged','%#%' ),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'prev_text' => __( '&laquo; Older Posts', 'japibas' ),
        'next_text' => __( 'Newer Posts &raquo;', 'japibas' ),
        'end_size' => 1,
        'mid_size' => 2,
        'show_all' => false,
        'type' => 'list'
    );

	$pagination = wp_parse_args( $args, $defaults );

    if ( $wp_rewrite->using_permalinks() )
            $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
    if ( ! empty( $wp_query->query_vars['s'] ) )
            $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

	if ( $wp_query->max_num_pages > 1 )
		echo '<div class="pagination clearfix">' . paginate_links( $pagination ) . '</div> <!-- .pagination -->';
}

/**
 * Adds theme/plugin custom images sizes added with add_image_size() to the image uploader/editor.  This 
 * allows users to insert these images within their post content editor.
 *
 * @since Japibas 2.0
 * @param array $sizes Selectable image sizes.
 * @return array $sizes
 */
function japibas_image_size_names_choose( $sizes ) {

	/* Get all intermediate image sizes. */
	$intermediate_sizes = get_intermediate_image_sizes();
	$add_sizes = array();

	/* Loop through each of the intermediate sizes, adding them to the $add_sizes array. */
	foreach ( $intermediate_sizes as $size )
		$add_sizes[$size] = $size;

	/* Merge the original array, keeping it intact, with the new array of image sizes. */
	$sizes = array_merge( $add_sizes, $sizes );

	/* Return the new sizes plus the old sizes back. */
	return $sizes;
}

add_filter( 'image_size_names_choose', 'japibas_image_size_names_choose' );

/**
 * Function for using a debug stylesheet when developing.  To develop with the debug stylesheet, 
 * SCRIPT_DEBUG must be set to 'true' in the 'wp-config.php' file.  This will check if a 'style.dev.css'
 * file is present within the theme folder and use it if it exists.  Else, it defaults to 'style.css'.
 *
 * @since Japibas 2.0
 * @param string $stylesheet_uri The URI of the active theme's stylesheet.
 * @param string $stylesheet_dir_uri The directory URI of the active theme's stylesheet.
 * @return string $stylesheet_uri
 */
function japibas_debug_stylesheet( $stylesheet_uri, $stylesheet_dir_uri ) {

	/* If SCRIPT_DEBUG is set to true and the theme supports 'dev-stylesheet'. */
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		/* Remove the stylesheet directory URI from the file name. */
		$stylesheet = str_replace( trailingslashit( $stylesheet_dir_uri ), '', $stylesheet_uri );

		/* Change the stylesheet name to 'style.dev.css'. */
		$stylesheet = str_replace( '.css', '.dev.css', $stylesheet );

		/* If the stylesheet exists in the stylesheet directory, set the stylesheet URI to the dev stylesheet. */
		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $stylesheet ) )
			$stylesheet_uri = trailingslashit( $stylesheet_dir_uri ) . $stylesheet;
	}

	/* Return the theme stylesheet. */
	return $stylesheet_uri;
}

add_filter( 'stylesheet_uri', 'japibas_debug_stylesheet', 10, 2 );

?>