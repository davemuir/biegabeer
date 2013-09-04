<?php
/*
Template Name: Pages by Country
*/
?>
<?php get_header(); ?>

<div id="content-area" class="clearfix fullwidth">
	
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
	'meta_key'         => 'Country',
	'meta_key'         => 'Brewery',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
?>
<ul>
<?php 
session_start(); 
$brew = $_SESSION["brew"];




echo '<a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew='.$brew.'">link</a>';
?>
<h3 id="a" class="byCountryLetter" >A</h3>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Country", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "A" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
				
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
		
	 	<?php } ?>
			

				<?php 
					$the_query = new WP_Query( $args );
					if ( $the_query->have_posts() ) :
						while ( $the_query->have_posts() ) : $the_query->the_post();
						$postBreweryVar = get_post_meta($postID, "Brewery", true );
				
				if($variable == "A" && $postBreweryVar != "" && $setBrewery != $postBreweryVar){
					$permalink = get_permalink($postID);
					$title = get_the_title($postID);
					$setBrewery = $postBreweryVar;
					$brew = $postBreweryVar;
				 ?>		
				<li><a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $brew ?>"> <?php echo $postBreweryVar ?></a></li>
		
	 			<?php } 
					
 
endwhile;
endif;
	?>

				

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>	
<?php echo $thing; ?>		
<ul>
<h3 id="b" class="byCountryLetter" >B</h3>
<?php	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Country", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "B" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
	 	<?php }if($variable == "B" ){
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);	
			 ?>		
			<li><a href="<?php echo $permalink ?>"> <?php echo $title ?></a></li>
		
	 	<?php } ?>

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>			
<ul>
<h3 id="c" class="byCountryLetter" >C</h3>
<?php	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Country", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "C" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
	 	<?php }if($variable == "C" ){
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);	
			 ?>		
			<li><a href="<?php echo $permalink ?>"> <?php echo $title ?></a></li>
		
	 	<?php } ?>

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>			
<ul>
<h3 id="d" class="byCountryLetter" >D</h3>
<?php	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Country", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "D" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
	 	<?php }if($variable == "D" ){
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);	
			 ?>		
			<li><a href="<?php echo $permalink ?>"> <?php echo $title ?></a></li>
		
	 	<?php } ?>

	<?php endforeach; 
	wp_reset_postdata();?>
</ul>
<ul>
<h3 id="e" class="byCountryLetter" >E</h3>
<?php	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Country", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "E" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
	 	<?php }if($variable == "E" ){
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);	
			 ?>		
			<li><a href="<?php echo $permalink ?>"> <?php echo $title ?></a></li>
		
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
	
	
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>