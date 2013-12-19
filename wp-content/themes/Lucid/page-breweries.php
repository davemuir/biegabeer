<?php
/*
Template Name: Pages by Breweries
*/
?>
<?php
$page_object = get_queried_object();
$page_id = get_queried_object_id();
?>
<?php 
get_header('reviews');

?>

<div id="content-area" class="clearfix">
	
	<div id="left-area">
	
		<?php get_template_part('includes/breadcrumbs', 'page'); ?>
<!--start wrap-->
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
<?php 
$brew = $_GET['brew']; 
$target = array("\'","%26");
$replace = array("'","&");
$brewSan = str_replace($target,$replace,$brew);

?>		
	<?php $count = 1; ?>
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
	'suppress_filters' => true ); ?>
	
		


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
			<h1 class="title"><?php echo $brewSan; ?></h1>	
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$postBreweryInfoVar = get_post_meta($postID, "breweryInfo", true );
		$breweryLink =  get_post_meta($postID, "breweryLink", true );
		$permalink = get_permalink($postID);	
	 	?>
		
		<?php 
			
			if($brewSan == $postBreweryVar && $count <= 1 ){ 
						
			?>
			<p class="breweryInfo">
				<?php echo $postBreweryInfoVar; ?><br/>
				<a href="<?php echo $breweryLink ;?>">visit the official <?php echo $brewSan; ?> website</a>			
			</p>
				
		
		
	 	<?php 

$count= 2;  } ?>
		


				

	<?php endforeach; 
	wp_reset_postdata();?>
	
			


	
<!--start wrap again-->
		
<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Lucid').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_attr__('Edit this page','Lucid')); ?>			
				</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->
<!--end wrap for original gets country terms-->		

<?php $args = array(
	'posts_per_page'   => 2000,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'title',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => 'Brewery',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true ); ?>
	
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
		$postID = get_the_ID();
		$postBreweryVar = get_post_meta($postID, "Brewery", true );
		$permalink = get_permalink($postID);	
	 	?>
		
		<?php 
			if($brewSan == $postBreweryVar){ 
						
			?>
			<?php
	

	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
	$beerStyle = get_the_category( $recent["ID"] );
	$post = get_post($recent["ID"]);	
	$content = $post->post_content;
	$content = truncate_post(170,false);	
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
<?php
	echo '

<div class="post_content2 clearfix">
	<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;border-radius:45px;background: url('.$image_thumb[0].') no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;margin-bottom:25px;border:2px solid #fda428;" ></div>';
	?>
	<?php 
	echo '
	<h2 class="title"><a href="'. $permalink .'">'. get_the_title($postID) .'</a></h2>';
	echo '<p>'.$content.'</p>';
	?>
	  </div>
	  </article>
		
	 	<?php } ?>
		


				

	<?php endforeach; 
	wp_reset_postdata();?>
	
<?php endwhile; // end of the loop. ?>	
		
<!--end wrap again-->		
		
		
		<?php if ( 'on' == et_get_option('lucid_show_pagescomments') ) comments_template('', true); ?>
		
		
	</div> <!-- end #left-area -->
	
	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>