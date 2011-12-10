<!doctype html>
<!--[if lt IE 7]> <html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

    <meta charset="<?php bloginfo('charset'); ?>" />

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
    <!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
    
    <?php
        /* Color scheme */
        /*$colorscheme = ( japibas_get_setting( 'color_scheme' ) ) ? japibas_get_setting( 'color_scheme' ) : 'green.css';	
        echo '<link rel="stylesheet" media="all" href="' . get_template_directory_uri() . '/css/styles/' . esc_attr( $colorscheme ) . '" />';*/
    ?>

<?php
	/* Add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_head();
?>

</head>

<body <?php body_class(); ?>>

<div id="wrapper" class="hfeed">

    <header id="branding" role="banner">

        <hgroup>
            <?php
				// Get the site title, either by logo or by text
				if ( $title = get_bloginfo( 'name' ) ) {
					
					// Get URL of the logo
					$logo = japibas_get_logo( japibas_get_setting( 'logo' ) );

					// Check if there's a header image, else return the blog name
					$maybe_image = ( $logo ) ? '<span class="assistive-text">' . $title . '</span><img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $title ) . '" />' : '<span>' . $title . '</span>';
					echo '<h1 id="site-title"><a href="' . home_url() . '" title="' . esc_attr( $title ) . '" rel="home">' . $maybe_image . '</a></h1>';
				}
			?>
            <h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
        </hgroup> 

        <nav id="access" role="navigation">
            <h3 class="assistive-text"><?php _e( 'Main menu', 'japibas' ); ?></h3>
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '' ) ); ?>
        </nav><!-- #access -->

    </header> <!-- #branding -->

    <?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template ?>

    <?php
		// Load slider
		if ( japibas_get_setting( 'slider_category' ) && ( is_home() || is_front_page() ) )
    		get_template_part( 'slider' );
		elseif( japibas_get_setting( 'slider_category' ) && is_single() )
			get_template_part( 'slider', 'single' );
	?>

<div id="main">