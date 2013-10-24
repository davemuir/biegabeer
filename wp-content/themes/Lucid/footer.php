<?php
	$footer_sidebars = array('footer-area-1','footer-area-2','footer-area-3');
	$any_widget_area_active = is_active_sidebar( $footer_sidebars[0] ) || is_active_sidebar( $footer_sidebars[1] ) || is_active_sidebar( $footer_sidebars[2] );
?>

		</div> <!-- end .container -->
	</div> <!-- end #main-area -->
	<footer id="main-footer">
	<?php if ( $any_widget_area_active ) { ?>
		<div id="footer-divider"></div>
	<?php } ?>
		<div class="container">
			<div id="footer-widgets" class="clearfix">
				<?php
					if ( $any_widget_area_active ) {
						foreach ( $footer_sidebars as $key => $footer_sidebar ){
							if ( is_active_sidebar( $footer_sidebar ) ) {
								echo '<div class="footer-widget' . (  2 == $key ? ' last' : '' ) . '">';
								dynamic_sidebar( $footer_sidebar );
								echo '</div> <!-- end .footer-widget -->';
							}
						}
					}
				?>
			</div> <!-- end #footer-widgets -->
		</div> <!-- end .container -->

		<?php if ( 'on' == et_get_option( 'lucid_728_enable', 'false' ) ){ ?>
			<div id="bottom-advertisment">
				<div class="container">
					<?php
						if ( ( $lucid_728_adsense = et_get_option('lucid_728_adsense') ) && '' != $lucid_728_adsense ) echo( $lucid_728_adsense );
						else { ?>
						   <a href="<?php echo esc_url(et_get_option('lucid_728_url')); ?>"><img src="<?php echo esc_url(et_get_option('lucid_728_image')); ?>" /></a>
					<?php } ?>
				</div> <!-- end .container -->
			</div>
		<?php } ?>
	<div class="container">
		<div class="footerSocial">
			<div class="socialButtons">
			<a href="#" id="facebookSocial"><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/facebookSocial.png"></a>
			<a href="#" id=""><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/twitterSocial.png"></a>
			<a href="#" id=""><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/instaSocial.png"></a>
			<a href="#" id=""><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/mailSocial.png"></a>	
			</div>
		</div>
	</div>
	</footer> <!-- end #main-footer -->


	<?php wp_footer(); ?>
</body>
</html>