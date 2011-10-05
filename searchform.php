<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 */
?>

<?php
	// Set the value on the search input
	if ( is_search() )
		$value = 'value="' . esc_attr( get_search_query() ) . '"'; // Search query for the search page
	elseif ( is_404() )
		$value = 'value="' . esc_attr( basename($_SERVER['REQUEST_URI']) ) . '"'; // Requested URI for 404 page
	else
		$value= 'placeholder="' . esc_attr__( 'Search this site...', 'japibas' ) . '"'; // Or Search this site... as placeholder
?>

	<form method="get" class="searchform" action="<?php echo trailingslashit( home_url() ); ?>">
        <div>
            <input type="search" name="s" <?php echo $value; ?> />
            <input type="submit" value="<?php esc_attr_e( 'Search', 'japibas' ); ?>" />
        </div>
    </form> <!-- .search-form -->