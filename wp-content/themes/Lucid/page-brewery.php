<?php
/*
Template Name: Pages by Brewery
*/
?>
<?php get_header(); ?>

<div id="content-area" class="clearfix ">
	
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'page'); ?>
<!--start wrap-->
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
		<?php
			$thumb = '';
			$width = (int) apply_filters('et_blog_image_width',630);
			$height = (int) apply_filters('et_blog_image_height',210);
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Singleimage');
			$thumb = $thumbnail["thumb"];
		?>
		<?php if ( '' != $thumb && 'on' == et_get_option('lucid_page_thumbnails') ) { ?>
			<div class="post-thumbnail">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>
				<div class="post_content clearfix">
			<h1 class="title"><?php the_title(); ?></h1>
			<div class="alphaSelector">
			<a href="#a">A</a>
			<a href="#b">B</a>
			<a href="#c">C</a>
			<a href="#d">D</a>
			<a href="#e">E</a>
			<a href="#f">F</a>
			<a href="#g">G</a>
			<a href="#h">H</a>
			<a href="#i">I</a>
			<a href="#j">J</a>
			<a href="#k">K</a>
			<a href="#l">L</a>
			<a href="#m">M</a>
			<a href="#n">N</a>
			<a href="#o">O</a>
			<a href="#p">P</a>
			<a href="#q">Q</a>
			<a href="#r">R</a>
			<a href="#s">S</a>
			<a href="#t">T</a>
			<a href="#u">U</a>
			<a href="#v">V</a>
			<a href="#w">W</a>
			<a href="#x">X</a>
			<a href="#y">Y</a>
			<a href="#z">Z</a>
			</div>
<!--end wrap for original gets country terms-->		
<?php $args = array(
	'posts_per_page'   => 2000,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'meta_value',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => 'Brewery',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
?>

<?php 
session_start(); 
$brew = $_SESSION["brew"];

?>
<h3 id="a" class="byCountryLetter" >A</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "A" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="b" class="byCountryLetter" >B</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "B" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="c" class="byCountryLetter" >C</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "C" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="d" class="byCountryLetter" >D</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "D" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="e" class="byCountryLetter" >E</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "E" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="f" class="byCountryLetter" >F</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "F" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="g" class="byCountryLetter" >G</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "G" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="h" class="byCountryLetter" >H</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "H" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="i" class="byCountryLetter" >I</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "I" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="j" class="byCountryLetter" >J</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "J" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="k" class="byCountryLetter" >K</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "K" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="l" class="byCountryLetter" >L</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "L" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="m" class="byCountryLetter" >M</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "M" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="n" class="byCountryLetter" >N</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "N" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="o" class="byCountryLetter" >O</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "O" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="p" class="byCountryLetter" >P</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "P" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="q" class="byCountryLetter" >Q</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "Q" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="r" class="byCountryLetter" >R</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "R" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="s" class="byCountryLetter" >S</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "S" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="t" class="byCountryLetter" >T</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "T" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="u" class="byCountryLetter" >U</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "U" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="v" class="byCountryLetter" >V</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "V" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="w" class="byCountryLetter" >W</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "W" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="x" class="byCountryLetter" >X</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "X" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="y" class="byCountryLetter" >Y</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "Y" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<h3 id="z" class="byCountryLetter" >Z</h3>
<ul>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php
		
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postBreweryVar, 0, 1);
		
	 	?>
			
			<?php 
			if($variable == "Z" && $setBrewery != $postBreweryVar){ 
				$setBrewery = $postBreweryVar;
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$brew = str_replace("&","%26",$postBreweryVar);
			?>
				
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
				
		
	 	<?php } ?>
			
				
			

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<!--start wrap again-->
		
<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Lucid').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_attr__('Edit this page','Lucid')); ?>			
				</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->
<?php endwhile; // end of the loop. ?>	
		
<!--end wrap again-->		
		
		
		<?php if ( 'on' == et_get_option('lucid_show_pagescomments') ) comments_template('', true); ?>
		
		
	</div> <!-- end #left-area -->
	
	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>