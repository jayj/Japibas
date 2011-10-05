<!doctype html>
<!--[if lt IE 7]> <html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

    <meta charset="<?php bloginfo('charset'); ?>" />
    
    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;
    
        wp_title( '|', true, 'right' );
    
        // Add the blog name.
        bloginfo( 'name' );
    
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";
    
        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', 'japibas' ), max( $paged, $page ) );
    
        ?></title>

    <link href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:regular,bold" rel="stylesheet" />
    
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

<div id="wrapper">
	
    <div id="header">
    
    	<?php /* @todo Header image */ ?>
		<h1 id="site-title"><span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2> 

    	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
    
    </div> <!-- #header -->
    
    <?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template ?>
    
    <?php
		// Load slider
		if ( japibas_get_setting( 'slider_category' ) && ( is_home() || is_front_page() ) )
    		get_template_part( 'slider' );
		elseif( japibas_get_setting( 'slider_category' ) && is_single() )
			get_template_part( 'slider', 'single' );
	?>
    
<div id="content">