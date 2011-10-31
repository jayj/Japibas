
<?php if ( is_active_sidebar( 'sidebar-widgets' ) && japibas_get_setting( 'theme_layout' ) != 'no-sidebar' ) : ?>
    
    <div id="sidebar">
    	<?php dynamic_sidebar( 'sidebar-widgets' ); ?>    
    </div> <!-- #sidebar -->
    
<?php endif; ?>