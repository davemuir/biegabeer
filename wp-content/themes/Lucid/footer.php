<?php
	$footer_sidebars = array('footer-area-1','footer-area-2','footer-area-3');
	$any_widget_area_active = is_active_sidebar( $footer_sidebars[0] ) || is_active_sidebar( $footer_sidebars[1] ) || is_active_sidebar( $footer_sidebars[2] );
?>
<div class="container">
			
		<div class="footerSocial">
			<h3 class="midText">What's it all About?</h3>
		<p class="midText">Biega Beer is founded by gastronome Jan Biega and is dedicated to exploring the culture and pleasures of beer.  This website features  reviews of more than 2500 beers from more than 700 breweries and 80 countries.  Biega Beer specializes in consulting and strategic development for craft breweries and has extensively researched online beer communities. </p>
			<div class="socialButtons">
			<a href="#" id="facebookSocial"></a>
			<a href="#" id="twitterSocial"></a>
			<a href="#" id=""><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/instaSocial.png"></a>
			<a href="#" id=""><img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/mailSocial.png"></a>	
			</div>
		</div>
	</div>
		</div> <!-- end .container -->
	</div> <!-- end #main-area -->
	

<?php wp_footer(); ?>
	
</body>
</html>