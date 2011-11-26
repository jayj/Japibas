<?php
/**
 * Japibas Theme Options
 *
 * Initializes all the theme settings page functions.
 * Thanks to Twenty Eleven for much of the code!
 */

/**
 * Enqueue styles and scripts for the theme options page
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Japibas 2.0
 */
function japibas_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'japibas-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2.0' );
	wp_enqueue_script( 'japibas-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2.0' );
	wp_enqueue_style( 'farbtastic' );
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'japibas_admin_enqueue_scripts' );

/**
 * Register the form setting for our japibas_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, japibas_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since Japibas 2.0
 */
function japibas_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === japibas_get_theme_options() )
		add_option( 'japibas_theme_options', japibas_get_default_theme_options() );

	register_setting( 'japibas_options', 'japibas_theme_options', 'japibas_theme_options_validate' );
}

add_action( 'admin_init', 'japibas_theme_options_init' );

/**
 * Change the capability required to save the 'japibas_options' options group.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function japibas_option_page_capability( $capability ) {
	return 'edit_theme_options';
}

add_filter( 'option_page_capability_japibas_options', 'japibas_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Japibas 2.0
 */
function japibas_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'japibas' ),   // Name of page
		__( 'Theme Options', 'japibas' ),   // Label in menu
		'edit_theme_options',               // Capability required
		'theme_options',                    // Menu slug, used to uniquely identify the page
		'japibas_theme_options_render_page' // Function that renders the options page
	);
}

add_action( 'admin_menu', 'japibas_theme_options_add_page' );

/**
 * Returns an array of color schemes registered for Japibas.
 *
 * It looks for .css files in the colors/ folder
 *
 * @since Japibas 2.0
 */
function japibas_color_schemes() {

	// Default color scheme
	$color_scheme_options = array(
		'green' => array(
			'value' => 'green',
			'label' => __( 'Green', 'japibas' ),
			'thumbnail' => get_template_directory_uri() . '/images/green.png',
			'default_link_color' => '#768c22',
		)
	);

	// Find color schemes from the colors/ folder
	foreach ( glob( get_template_directory() . '/colors/*.css' ) as $style ) { 

		// Get info about the color scheme from the header
		$data = get_file_data( $style, array( 'name' => 'Name', 'slug' => 'Slug', 'description' => 'Description', 'linkcolor' => 'Link color' ), 'japibas' );

		$color_scheme_options[ sanitize_title( $data['slug'] ) ] = array(
			'value' => sanitize_title( $data['slug'] ),
			'label' => esc_html( $data['name'] ),
			'thumbnail' => esc_url( get_template_directory_uri() . '/colors/' . $data['slug'] . '/thumbnail.png' ),
			'default_link_color' => '#' . strtolower( ltrim( $data['linkcolor'], '#' ) )
		);
	}

	return $color_scheme_options;
}

/**
 * Returns an array of layout options registered for Japibas.
 *
 * @since Japibas 2.0
 */
function japibas_layouts() {
	$layout_options = array(
		'sidebar-right' => array(
			'value' => 'sidebar-right',
			'label' => __( 'Content on left', 'japibas' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-left' => array(
			'value' => 'sidebar-left',
			'label' => __( 'Content on right', 'japibas' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
		'no-sidebar' => array(
			'value' => 'no-sidebar',
			'label' => __( 'One-column, no sidebar', 'japibas' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content.png',
		),
	);

	return $layout_options;
}

/**
 * Returns an array of logos registered for Japibas.
 *
 * @since Japibas 2.0
 */
function japibas_logos() {
	$logos = array(
		'japibas-logo' => array(
			'url' => get_template_directory_uri() . '/images/logo.png',
			'thumbnail_url' => get_template_directory_uri() . '/images/logo.png',
			'description' => __( 'Logo.png from the Japibas images folder', 'japibas' )
		),
	);
	
	// Look in each color scheme for a logo.png
	foreach ( glob( get_template_directory() . '/colors/*.css' ) as $style ) { 
		// Get the color scheme name and slug from the header
		$data = get_file_data( $style, array( 'name' => 'Name', 'slug' => 'Slug' ), 'japibas' );
		$slug = $data['slug'];
		$logo = get_template_directory_uri() . '/colors/' . sanitize_title( $slug ) . '/logo.png';
		
		if ( file_exists( get_template_directory() . '/colors/' . sanitize_title( $slug ) . '/logo.png' ) )
			$logos["{$slug}-logo"] = array(
				'url' => $logo,
				'thumbnail_url' => $logo,
				'description' => sprintf( __( 'Logo.png from the Japibas %s color scheme images folder', 'japibas' ), $data['name'] )
			);
	}
	
	// If the user is using a child theme, add the logo.png from that as well
	if ( is_child_theme() && file_exists( CHILD_THEME_DIR . '/images/logo.png' ) )
		$logos['japibas-childtheme-logo'] = array(
				'url' => CHILD_THEME_URI . '/images/logo.png',
				'thumbnail_url' => CHILD_THEME_URI . '/images/logo.png',
				'description' => __( 'Logo.png from the Japibas child theme images folder', 'japibas' )
		);

	return $logos;
}

/**
 * Returns the default options for Japibas.
 *
 * @since Japibas 2.0
 */
function japibas_get_default_theme_options() {
	$default_theme_options = array(
		'color_scheme' => 'green',
		'link_color'   => japibas_get_default_link_color( 'green' ),
		'theme_layout' => 'sidebar-right',
		'logo' => 'japibas-logo',
		'exclude_cats' => array(),
		'slider_category' => '',
		'slider_posts' => 5,
		'footer_text' => '<p class="alignleft">' . __( 'Copyright &#169; [the-year] [site-link]', 'japibas' ) . '</p>' . "\n\n" . '<p class="alignright">' . __( 'Powered by [wp-link] and [theme-link]', 'japibas' ) . '</p>'
	);
	
	// Change default footer text if it's a child theme
	if ( is_child_theme() )
		$default_theme_options['footer_text'] = '<p class="alignleft">' . __( 'Copyright &#169; [the-year] [site-link].', 'japibas' ) . '</p>' . "\n\n" . '<p class="alignright">' . __( 'Powered by [wp-link], [theme-link], and [child-link].', 'japibas' ) . '</p>';

	return $default_theme_options;
}

/**
 * Returns the default link color for Japibas, based on color scheme.
 *
 * @since Japibas 2.0
 *
 * @param $string $color_scheme Color scheme. Defaults to the active color scheme.
 * @return $string Color.
 */
function japibas_get_default_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = japibas_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = japibas_color_schemes();

	if ( ! isset( $color_schemes[ $color_scheme ] ) )
		return false;

	return $color_schemes[ $color_scheme ]['default_link_color'];
}

/**
 * Returns the options array for Japibas.
 *
 * @since Japibas 2.0
 */
function japibas_get_theme_options() {
	return get_option( 'japibas_theme_options', japibas_get_default_theme_options() );
}

/**
 * Returns the options array for Japibas.
 *
 * @since Japibas 1.2
 */
function japibas_theme_options_render_page() { ?>

    <div class="wrap">

    <?php screen_icon(); ?>

    <h2><?php printf( __( '%s Theme Options', 'japibas' ), 'Japibas' ); ?></h2>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
		<?php
        	settings_fields( 'japibas_options' );
        	$options = japibas_get_theme_options();
        ?>

        <table class="form-table">

            <tr valign="top" class="image-radio-option color-scheme"><th scope="row"><?php _e( 'Color Scheme', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                    	<legend class="screen-reader-text"><span><?php _e( 'Color Scheme', 'japibas' ); ?></span></legend>

						<?php foreach ( japibas_color_schemes() as $scheme ) : ?>
                            <div class="layout">
                                <label class="description">
                                    <input type="radio" name="japibas_theme_options[color_scheme]" value="<?php echo esc_attr( $scheme['value'] ); ?>" <?php checked( $options['color_scheme'], $scheme['value'] ); ?> />
                                    <input type="hidden" id="default-color-<?php echo esc_attr( $scheme['value'] ); ?>" value="<?php echo esc_attr( $scheme['default_link_color'] ); ?>" />
                                    <span>
										<?php if ( isset( $scheme['thumbnail'] ) ) { ?>
                                        	<img src="<?php echo esc_url( $scheme['thumbnail'] ); ?>" width="136" height="122" alt="" />
                                        <?php } ?>
                                        <?php echo $scheme['label']; ?>
                                    </span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </td>
            </tr>
            
			<tr valign="top" class="image-radio-option custom-logo"><th scope="row"><?php _e( 'Logo', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                    	<legend class="screen-reader-text"><span><?php _e( 'Logo', 'japibas' ); ?></span></legend>

						<div class="layout">
                            <label class="description">
                                <input type="radio" name="japibas_theme_options[logo]" value="no-logo" <?php checked( $options['logo'], 'no-logo' ); ?> />
                                <span> No logo, just text </span>
                            </label>
						</div>
                            
						<?php foreach ( japibas_logos() as $logo_name => $logo ) : ?>
                            <div class="layout">
                                <label class="description">
                                    <input type="radio" name="japibas_theme_options[logo]" value="<?php echo esc_attr( $logo_name ); ?>" <?php checked( $options['logo'], $logo_name ); ?> />
									<?php if ( isset( $logo['thumbnail_url'] ) ) { ?>
                                        <img src="<?php echo esc_url( $logo['thumbnail_url'] ); ?>" alt="" />
                                    <?php } ?>
                                    <span><?php echo $logo['description']; ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </td>
            </tr>

            <tr valign="top"><th scope="row"><?php _e( 'Link Color', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                    	<legend class="screen-reader-text"><span><?php _e( 'Link Color', 'japibas' ); ?></span></legend>

                        <input type="text" name="japibas_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />

                        <a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
                        <input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'japibas' ); ?>" />

                        <div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div> <br />

                        <span><?php printf( __( 'Default color: %s', 'japibas' ), '<span id="default-color">' . japibas_get_default_link_color( $options['color_scheme'] ) . '</span>' ); ?></span>
                    </fieldset>
                </td>
            </tr>

            <tr valign="top" class="image-radio-option theme-layout"><th scope="row"><?php _e( 'Default Layout', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                    	<legend class="screen-reader-text"><span><?php _e( 'Color Scheme', 'japibas' ); ?></span></legend>

						<?php foreach ( japibas_layouts() as $layout ) : ?>
                            <div class="layout">
                                <label class="description">
                                    <input type="radio" name="japibas_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
                                    <span>
                                        <img src="<?php echo esc_url( $layout['thumbnail'] ); ?>" width="136" height="122" alt="" />
                                        <?php echo $layout['label']; ?>
                                    </span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </td>
            </tr>

            <tr valign="top"><th scope="row"><?php _e( 'Exclude categories', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Exclude categories', 'japibas' ); ?></span></legend>

                        <label class="description">
                            <select name="japibas_theme_options[exclude_cats][]" multiple="multiple">
                            <?php foreach ( get_categories( array( 'hide_empty' => 0 ) ) as $cat ) { ?>
                            	<?php $selected = ( in_array( $cat->term_id, $options['exclude_cats'] ) ) ? 'selected="selected"' : ''; ?> 
                            	<option value="<?php echo intval( $cat->term_id ); ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
                            <?php } ?>
                            </select>

                            <p><?php _e( 'Want to exclude some categories from the loop? (Hold down <kbd>CTRL/CMD</kbd> to select multiple)', 'japibas' ); ?></p>
                        </label>
                    </fieldset>
            	</td>
            </tr>

		</table>
 
		<h3><?php _e( 'Slider', 'japibas' ); ?></h3>
  
		<table class="form-table">

            <tr valign="top" class="image-radio-option color-scheme"><th scope="row"><?php _e( 'Slider Category', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Slider Category', 'japibas' ); ?></span></legend>

                        <label class="description">
                            <select name="japibas_theme_options[slider_category]">
                            <option value=""></option>
                            <?php foreach ( get_categories( array( 'hide_empty' => 0 ) ) as $cat ) { ?>
                            	<option value="<?php echo intval( $cat->term_id ); ?>" <?php selected( $options['slider_category'], $cat->term_id ); ?>><?php echo $cat->name; ?></option>
                            <?php } ?>
                            </select>

                            <?php _e( 'Choose a category for the slider posts. Leave empty to disable slider', 'japibas' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr valign="top" class="image-radio-option color-scheme"><th scope="row"><?php _e( 'Number of Posts', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e( 'Number of Posts', 'japibas' ); ?></span></legend>

                        <label class="description">
                        	<input type="number" name="japibas_theme_options[slider_posts]" class="small-text" min="-1" value="<?php echo esc_attr( $options['slider_posts'] ); ?>" />
                        	<?php _e( 'Number of posts in the slider. Use <code>-1</code> for all posts in the selected category', 'japibas' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>

		</table>
  
		<h3><?php _e( 'Other settings', 'japibas' ); ?></h3>

		<table class="form-table">

            <tr valign="top"><th scope="row"><?php _e( 'Footer text', 'japibas' ); ?></th>
                <td>
                    <fieldset>
                    	<legend class="screen-reader-text"><span><?php _e( 'Footer text', 'japibas' ); ?></span></legend>
                            <div style="width: 50%;">
                                <?php
                                    wp_editor( $options['footer_text'], 'japibas-footer-text', array(
                                        'textarea_name' => 'japibas_theme_options[footer_text]',
                                        'media_buttons' => false,
                                        'wpautop' => false,
                                        'textarea_rows' => 7
                                    ) );
                                ?>
                            </div>
                            <p class="description"><?php _e( 'You can add custom <acronym title="Hypertext Markup Language">HTML</acronym> and/or shortcodes, which will be automatically inserted into your theme.', 'japibas' ); ?></p>
                            <p><?php printf( __( 'Shortcodes: %s', 'japubas' ), '<code>[the-year]</code>, <code>[site-link]</code>, <code>[wp-link]</code>, <code>[theme-link]</code>, <code>[child-link]</code>, <code>[loginout-link]</code>, <code>[query-counter]</code>' ); ?></p>

                    </fieldset>
                </td>
            </tr>

        </table>

        <?php submit_button(); ?>

    </form>

    </div> <!-- .wrap -->

	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see japibas_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since Japibas 2.0
 */
function japibas_theme_options_validate( $input ) {
	$output = $defaults = japibas_get_default_theme_options();

	// Color scheme
	if ( isset( $input['color_scheme'] ) && array_key_exists( $input['color_scheme'], japibas_color_schemes() ) )
		$output['color_scheme'] = $input['color_scheme'];
	
	// Logo
	if ( isset( $input['logo'] ) && array_key_exists( $input['logo'], array_merge( japibas_logos(), array( 'no-logo' => '' ) ) ) )
		$output['logo'] = $input['logo'];

	// Our defaults for the link color may have changed
	$output['link_color'] = $defaults['link_color'] = japibas_get_default_link_color( $output['color_scheme'] );

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], japibas_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	$output['exclude_cats'] = (array) $input['exclude_cats'];
	$output['slider_category'] = intval( $input['slider_category'] );
	$output['slider_posts'] = intval( $input['slider_posts'] );
	$output['footer_text'] = $input['footer_text'];

	return $output;
}

/**
 * Enqueue the styles for the current color scheme.
 *
 * @since Japibas 2.0
 */
function japibas_enqueue_color_scheme() {
	$options = japibas_get_theme_options();
	$color_scheme = $options['color_scheme'];

	// Don't enqueue the default color scheme
	if ( $color_scheme == 'green' )
		return false;

	if ( file_exists( get_template_directory() . '/colors/' . $color_scheme . '.css' ) )
		wp_enqueue_style( $color_scheme, get_template_directory_uri() . '/colors/' . $color_scheme . '.css', array(), null );
}

add_action( 'wp_enqueue_scripts', 'japibas_enqueue_color_scheme' );

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Japibas 2.0
 */
function japibas_print_link_color_style() {
	$options = japibas_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = japibas_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a/*,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		.widget_japibas_ephemera .comments-link a:hover,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover*/ {
			color: <?php echo $link_color; ?>;
		}
	</style>
<?php
}

add_action( 'wp_head', 'japibas_print_link_color_style' );

/**
 * Adds Japibas layout classes to the array of body classes.
 *
 * @since Japibas 2.0
 */
function japibas_layout_classes( $classes ) {
	$options = japibas_get_theme_options();

	$classes[] = sanitize_html_class( $options['theme_layout'] );

	return $classes;
}

add_filter( 'body_class', 'japibas_layout_classes' );

/**
 * Returns the url of the logo
 *
 * @since Japibas 2.0
 *
 * @param $string $logo Name of the logo. Defaults to the active logo
 * @return $string URL of logo.
 */
function japibas_get_logo( $logo = null ) {
	if ( null === $logo ) {
		$options = japibas_get_theme_options();
		$logo = $options['logo'];
	}

	$logos = japibas_logos();

	if ( ! isset( $logos[ $logo ] ) )
		return false;

	return $logos[ $logo ]['url'];
}


?>