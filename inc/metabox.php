<?php 

add_action( 'add_meta_boxes', 'jap_create_meta_box' );
add_action( 'save_post', 'jap_meta_box_save', 10, 2 );

function jap_create_meta_box() {
	add_meta_box( 'japibas-thumbnail-meta', __( 'Thumbnail', 'japibas' ), 'jap_meta_box', 'post', 'normal', 'high' );
}

function jap_meta_box( $object, $box ) { ?>

    <input type="hidden" name="japibas_meta_box_nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ); ?>" />
    
    <p>
        <label for="japibas-thumbnail"><?php _e( 'Thumbnail', 'japibas' ); ?></label>
        <br />
        <input type="text" name="japibas-thumbnail" id="japibas-thumbnail" value="<?php echo esc_url( get_post_meta( $object->ID, 'thumbnail', true ) ); ?>" size="30" tabindex="30" style="width: 30%;" />
        <span><strong>No need to use this</strong> if you're using the 'Featured Image' function</span>
    </p>
    
	<p>
        <label for="featured_image"><?php _e( 'Slider Image', 'japibas' ); ?></label>
        <br />
        <input type="text" name="japibas-featured-image" id="featured_image" value="<?php echo esc_url( get_post_meta( $object->ID, 'featured_image', true ) ); ?>" size="30" tabindex="30" style="width: 30%;" />
        <span>You'll only need this if you want the image in the slider to be different from the featured image/thumbnail</span>
    </p>

<?php
}

function jap_meta_box_save( $post_id, $post ) {
	
	/* Verify that the post type supports the meta box and the nonce before preceding. */
	if ( !isset( $_POST['japibas_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['japibas_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$meta = array(
		'thumbnail' => esc_url_raw( $_POST['japibas-thumbnail'] ),
		'featured_image' => esc_url_raw( $_POST['japibas-featured-image'] ),
	);
	
	foreach ( $meta as $meta_key => $new_meta_value ) :

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
			
	endforeach;
}

?>