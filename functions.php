<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

add_action( 'after_setup_theme', 'jap_setup' );
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since 2.0
 */
function jap_setup() {

	define( 'THEMEVERSION', '2.0' );

	add_custom_background();
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'japibas' ) );

	/* Load JavaScript */
	add_action( 'wp_enqueue_scripts', 'jap_enqueue_script' );

	/* Sidebars */
	add_action( 'widgets_init', 'jap_sidebars' );

	/* Add new image sizes */
	add_image_size( 'small', 100, 100, true );
	add_image_size( 'slider', 480, 220, true );
	add_image_size( 'slider-large', 920, 220, true );

	/* Load the Get the Image extension if supported. */
	add_theme_support( 'get-the-image' );
	require_if_theme_supports( 'get-the-image', dirname( __FILE__ ) . '/inc/get-the-image.php' );

	/*
	 * Include widgets, admin panel and meta boxes
	 */
	require( dirname( __FILE__ ) . '/inc/widgets.php' );
	
	// Load up the theme options page and related code
	require( dirname( __FILE__ ) . '/inc/theme-options.php' );
	
	if ( is_admin() ) {
		require_once( dirname( __FILE__ ) . '/inc/metabox.php' );
	};

	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
/*	load_theme_textdomain( 'japibas', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );*/

}

/**
 * Loads the theme JavaScript files
 *
 * @since 2.0
 */
function jap_enqueue_script() {
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'anythingslider', get_template_directory_uri() . '/js/jquery.anythingslider.min.js', array( 'jquery' ), '1.5.12', true );
	wp_enqueue_script( 'jap-theme', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '2.0', true );
}

/**
 * Register widgetized areas, including one sidebar, a 404 page, single post and four column widget-ready footer.
 */
function jap_sidebars() {

	register_widget( 'Japibas_Related_Posts_Widget' );

	register_sidebar( array (
		'name' => __( 'Sidebar', 'japibas' ),
		'id' => 'sidebar-widgets',
		'description' => __( 'Widgets for the sidebar', 'japibas' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Single post
	register_sidebar( array (
		'name' => __( 'Single Post', 'japibas' ),
		'id' => 'single-widgets',
		'description' => __( 'These widgets will be displayed after the content on single posts.', 'japibas' ),
		'before_widget' => '<div class="widget single-widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Footer
	register_sidebar( array (
		'name' => __( 'Footer Widgets', 'japibas' ),
		'id' => 'footer-widgets',
		'description' => __( 'Widgets for the footer', 'japibas' ),
		'before_widget' => '<div class="footer-col %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// 404 page
	register_sidebar( array (
		'name' => __( '404 Page', 'japibas' ),
		'id' => 'error-page-widgets',
		'description' => __( 'Widgets for the 404 error page', 'japibas' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

/**
 * Body classes
 *
 * Adds extra body classes, such as the browser,
 * if it's a singular page, and if the slider is disabled
 *
 * @since 1.0
 */
function japibas_body_class( $classes ) {

	if ( is_singular() )
		$classes[] = 'singular';

	if ( japibas_get_setting( 'slider_category' ) && ( is_home() || is_front_page() || is_single() ) )
		$classes[] = 'slider';
	else
		$classes[] = 'no-slider';
	
	if ( ! japibas_get_setting( 'slider_category' ) )
		$classes[] = 'slider-disabled';

	return $classes;
}

add_filter( 'body_class', 'japibas_body_class' );

/**
 * Loads the Japibas theme settings once and allows the input of the specific field the user would
 * like to show.
 *
 * @since 2.0
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
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function japibas_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>

		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'japibas' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'japibas' ), ' ' ); ?></p>

	<?php
		break;
		default :
	?>

        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

            <div id="comment-<?php comment_ID(); ?>">

                <div class="comment-header">
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

                    <div class="comment-meta commentmetadata">
                    	<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
								/* translators: 1: date, 2: time */
								printf( __( '%1$s at %2$s', 'japibas' ), get_comment_date(),  get_comment_time() );
							?>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'japibas' ), ' ' ); ?>
                    </div> <!-- .comment-meta .commentmetadata -->
                </div> <!-- .comment-header -->

                <?php if ( $comment->comment_approved == '0' ) : ?>
                	<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'japibas' ); ?></em>
                	<br />
                <?php endif; ?>

                <div class="comment-body"><?php comment_text(); ?></div>

                <div class="reply">
                	<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div> <!-- .reply -->

            </div> <!-- #comment-<?php comment_ID(); ?>  -->

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

?>