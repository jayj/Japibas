<?php
/**
 * Makes a widget for displaying Related Posts, based on category and post format
 */
class Japibas_Related_Posts_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 */
	function Japibas_Related_Posts_Widget() {
		$widget_ops = array( 'classname' => 'widget_japibas_related_posts', 'description' => __( 'Use this widget to list related posts to the current viewed post based on category and post format', 'japibas' ) );
		$this->WP_Widget( 'widget_japibas_related_posts', __( 'Japibas: Related Posts', 'japibas' ), $widget_ops );
		$this->alt_option_name = 'widget_japibas_related_posts';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {

		// Only show it if it's a single post
		if ( ! is_single() )
			return;

		// Get the widget settings
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', $instance['title'] );

		// Get the number of posts - Default to 5
		if ( ! isset( $instance['number'] ) )
			$instance['number'] = 5;

		if ( ! $number = absint( $instance['number'] ) )
			$number = 5;

		$post_id = get_the_ID();

		// Get related posts from post meta
		$related_posts = get_post_meta( $post_id, 'related', false );

		// No related posts found, get them! */
		if ( empty( $related_posts ) ) :
			$this->get_related_posts( $post_id, $number );
	
			// Get the post meta again
			$related_posts = get_post_meta( $post_id, 'related', false );
		endif; // empty( $related_posts )


		echo $before_widget;

		echo $before_title . $title . $after_title;
	?>

            <ul class="clearfix">
				<?php
					// Run through the related posts
					if ( ! empty( $related_posts ) ) :
						foreach( $related_posts as $post ) :
                ?>
                    <li>
                        <a href="<?php echo get_permalink( $post['post_id'] ); ?>" title="Read <?php echo esc_attr( $post['title'] ); ?>">
							<?php
								if ( ! empty( $post['thumbnail'] ) )
									echo wp_get_attachment_image( $post['thumbnail'], 'small', false, array( 'title' => esc_attr( $post['title'] ) ) );
								else
									echo ( empty( $post['title'] ) ) ? '<span>(Untitled)</span>' : '<span>' . $post['title'] . '</span>';
                            ?>
                        </a>
                    </li>
                <?php
                		endforeach;
                	else :
                		_e( 'No related posts', 'japibas' );
                	endif;
                ?>
            </ul>

		<?php

		echo $after_widget;
	}

	function get_related_posts( $post_id, $number ) {

		// Put the categories in an array for related posts
		$terms = get_the_terms( $post_id, 'category' );
		$cat__in = array();

		foreach ( $terms as $term ) {
			$cat__in[] = $term->slug;
		}

		// Get the post format
		$format = ( get_post_format() ) ? 'post-format-' . get_post_format() : '';

		// Fire up the query
		$related_query = array( 
			'posts_per_page' => $number,
			'orderby' => 'random',
			'ignore_sticky_posts' => true,
			'post__not_in' => array( $post_id ),
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'post_format',
					'terms' => array( $format ),
					'field' => 'slug',
				),
				array(
					'taxonomy' => 'category',
					'terms' => $cat__in,
					'field' => 'slug',
				),
			)
		);

		$related = new WP_Query( $related_query );

		if ( $related->have_posts() )  while ( $related->have_posts() ) : $related->the_post(); 

			// Add each related post in the 'related' custom field along with some basic information
			add_post_meta( $post_id, 'related', array(
				'permalink' => get_permalink(),
				'title' => get_the_title(),
				'post_id' => get_the_ID(),
				'thumbnail' => get_post_thumbnail_id()
			), false );

		endwhile; wp_reset_query();
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		return $instance;
	}

	function flush_widget_cache( $post_ID ) {

		$related_meta = get_post_meta( $post_ID, 'related', false );

		// Delete the related post meta for all the related posts
		if ( isset( $related_meta ) ) : 
			$related_posts = array();
			foreach ( $related_meta as $related ) {
				$related_posts[] = $related['post_id'];
			}

			$allposts = get_posts( array( 'include' => $related_posts, 'post_type' => 'post', 'post_status' => 'any' ) );

			foreach( $allposts as $postinfo ) {
				delete_post_meta( $postinfo->ID, 'related' );
			}
		endif;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'japibas' ); ?></label>
<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'japibas' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
	}
}

?>