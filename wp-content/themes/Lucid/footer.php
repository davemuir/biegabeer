<?php
	$footer_sidebars = array('footer-area-1','footer-area-2','footer-area-3');
	$any_widget_area_active = is_active_sidebar( $footer_sidebars[0] ) || is_active_sidebar( $footer_sidebars[1] ) || is_active_sidebar( $footer_sidebars[2] );
?>
<div class="container">
			
		<div class="footerSocial">
			<h3 class="midText">What's it all About?</h3>
		<p class="midText">Biega Beer is founded by gastronome Jan Biega and is dedicated to exploring the culture and pleasures of beer.  This website features  reviews of more than 2500 beers from more than 700 breweries and 80 countries.  Jan Biega specializes in consulting and strategic development for craft breweries and has extensively researched online beer communities. </p>
			<div class="socialButtons">
			<a href="#" id="facebookSocial"></a>
			<a href="https://twitter.com/BiegaBeerNWine" id="twitterSocial"></a>
			<a href="http://instagram.com/biegabeerandwine/" id="instaSocial"></a>
			<a href="mailto:biega.jan@gmail.com" id="mailSocial"></a>	
			</div>
		</div>
	</div>
		</div> <!-- end .container -->
	</div> <!-- end #main-area -->
	

<?php wp_footer(); ?>
	
</body>
</html>