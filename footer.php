
	<div class="clear"></div>
    
</div> <!-- #content -->

<div id="footer">

	<?php echo htmlspecialchars_decode( japibas_get_setting( 'footer_text' ) ); ?>
        
	<?php 
		if ( japibas_get_setting( 'footer_ad' ) )
			echo '<div id="footer_ad">' . htmlspecialchars_decode( japibas_get_setting( 'footer_ad' ) ) . '</div>';
    ?>
   
</div> <!-- #footer -->

</div> <!-- #wrapper -->

	<?php echo htmlspecialchars_decode( japibas_get_setting( 'analytics_code' ) ); ?>
    
    <?php wp_footer(); ?>
    
</body>
</html>