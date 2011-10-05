<?php 

/**
 * Initializes all the theme settings page functions. This function is used to create the themes 
 * settings page
 */

add_action( 'admin_menu', 'japibas_theme_page' );
add_action( 'admin_init', 'japibas_register_settings' );

function japibas_theme_page() {
	add_theme_page( 'Japibas Options', 'Japibas', 'edit_theme_options', 'japibas', 'japibas_theme' );
}

function japibas_register_settings() {
	register_setting( 'japibas_options', 'japibas_theme_options', 'japibas_options_validate' );
}

function japibas_theme() { ?>

    <div class="wrap">
    
		<?php screen_icon(); ?>
        
        <h2><?php printf( __( '%s Theme Options', 'japibas' ), get_current_theme() ); ?></h2>
        <?php settings_errors(); ?>
        
        <form method="post" action="options.php">
			<?php
				settings_fields( 'japibas_options' );
				$options = get_option( 'japibas_theme_options' );
            ?>
            
            <h3><?php _e( 'General settings', 'japibas' ); ?></h3>
            
            <table class="form-table">

                <tr valign="top"><th scope="row"><?php _e( 'Color Scheme', 'japibas' ); ?></th>
                    <td>
                        <fieldset>
                        
                            <legend class="screen-reader-text"><span><?php _e( 'Color Scheme', 'japibas' ); ?></span></legend>
                            
                            <?php
                                /* Get Stylesheets into a drop-down list */
                                $styles = array();
                                
                                foreach ( glob( TEMPLATEPATH . '/css/styles/*.css' ) as $style ) {  
                                    $styles[] = basename( $style );
                                }
                            ?>
                            
                            <label class="description">                              
                                <select name="japibas_theme_options[color_scheme]">
                                    <?php foreach ( $styles as $style ) { ?>
                                        <option value="<?php echo esc_attr( $style ); ?>" <?php selected( $options['color_scheme'], $style ); ?>><?php echo esc_attr( $style ); ?></option>
                                    <?php } ?>
                                </select>
                                
                                <?php _e( 'Which colour scheme would you like?', 'japibas' ); ?>
                            </label>
                        
                        </fieldset>
                    </td>
                </tr>
                
                <tr valign="top"><th scope="row"><?php _e( 'Exclude categories', 'japibas' ); ?></th>
                    <td>
                        <fieldset>
                        
                            <legend class="screen-reader-text"><span><?php _e( 'Exclude categories', 'japibas' ); ?></span></legend>
                            
							<label class="description">
                                <select name="japibas_theme_options[exclude_cats][]" multiple="multiple" style="height: 100%; padding: 5px 20px 5px 5px;">
                                    <?php foreach ( get_categories( 'hide_empty=0' ) as $cat ) { ?>
                                    	<?php $selected = ( in_array( $cat->term_id, $options['exclude_cats'] ) ) ? 'selected="selected"' : ''; ?> 
                                        <option value="<?php echo intval( $cat->term_id ); ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
                                    <?php } ?>
                                </select>
                                
                                <?php _e( 'If you want to exclude some categories from the loop (Hold down ctrl/command to select multiple)', 'japibas' ); ?>
                            </label>
                        
                        </fieldset>
                    </td>
                </tr>
            
            </table>
            
            <h3><?php _e( 'Slider', 'japibas' ); ?></h3>

            <table class="form-table">
                
				<tr valign="top"><th scope="row"><?php _e( 'Slider Category', 'japibas' ); ?></th>
                	<td>
                    	<fieldset>
                        
							<legend class="screen-reader-text"><span><?php _e( 'Slider Category', 'japibas' ); ?></span></legend>
                            
                            <label class="description">
                            
                            	<select name="japibas_theme_options[slider_category]">
                                	<option value=""></option>
                                	 <?php foreach ( get_categories( 'hide_empty=0' ) as $cat ) { ?>
                                        <option value="<?php echo intval( $cat->term_id ); ?>" <?php selected( $options['slider_category'], $cat->term_id ); ?>><?php echo $cat->name; ?></option>
                                    <?php } ?>
                                </select>
                                
                            	<?php _e( 'Choose a category for the slider posts - Leave empty to disable slider', 'japibas' ); ?>
                            </label>
                        
                        </fieldset>
                    </td>
                </tr>
                
				<tr valign="top"><th scope="row"><?php _e( 'Number of Posts', 'japibas' ); ?></th>
                	<td>
                    	<fieldset>
                        
							<legend class="screen-reader-text"><span><?php _e( 'Number of Posts', 'japibas' ); ?></span></legend>
                            
                            <label class="description">
                            
                            	<input type="number" name="japibas_theme_options[slider_posts]" class="small-text" value="<?php echo esc_attr( $options['slider_posts'] ); ?>" />
                            	<?php _e( 'Number of posts in the slider - Use <code>-1</code> for all posts in the selected category', 'japibas' ); ?>
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
                            
                            <label class="description">
                            
                                <textarea name="japibas_theme_options[footer_text]" cols="80" rows="8"><?php echo $options['footer_text']; ?></textarea>
                                
                                <?php _e( 'Edit the footer text and credit links here. Shortcodes and HTML allowed', 'japibas' ); ?>
                            </label>
                        
                        </fieldset>
                    </td>
                </tr>
                
                <?php if ( ! class_exists( 'GA_Admin' ) ) { // Hide the Google Analytics field if the "Google Analytics for WordPress" plugin is activated ?>
                    <tr valign="top"><th scope="row"><?php _e( 'Google Analytics', 'japibas' ); ?></th>
                        <td>
                            <fieldset>
                            
                                <legend class="screen-reader-text"><span><?php _e( 'Google Analytics', 'japibas' ); ?></span></legend>
                                
                                <label class="description">
                                
                                	<textarea name="japibas_theme_options[analytics_code]" cols="80" rows="8"><?php echo $options['analytics_code']; ?></textarea>
                                    
                                    <?php _e( 'Insert your Google Analytics (or other) code her', 'japibas' ); ?>
                                </label>
                            
                            </fieldset>
                        </td>
                    </tr>
                <?php } ?>
            
            </table>
            
            <?php submit_button(); ?>
        
        </form>
    
    </div> <!-- .wrap -->

<?php	
}

function japibas_options_validate( $input ) {
	
	$input['color_scheme'] = esc_attr( $input['color_scheme'] );
	$input['footer_text'] = esc_textarea( $input['footer_text'] );
	$input['analytics_code'] = esc_textarea( $input['analytics_code'] );
	
	$input['exclude_cats'] = (array) $input['exclude_cats'];
	
	$input['slider_category'] = intval( $input['slider_category'] );
	$input['slider_posts'] = intval( $input['slider_posts'] );
	
	return $input;
}