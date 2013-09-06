<?php
/*
Template Name: Pages by Brewery
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
<!--end wrap for original gets-->		
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


<ul>
<h3 id="a" class="byCountryLetter" >A</h3>
<?php		
	
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Brewery", true );
		$variable = substr($postRegionVar, 0, 1);
		$once = 1;
	 	?>
			
			<?php 
			if($variable == "A" && $once = 1 && $setRegion != $postRegionVar){ 
				$setRegion = $postRegionVar;
				$once = 2;
			?>
				<h3 class="byCountryName"> <?php echo $postRegionVar ?> </h3>
				
		
	 	<?php }if($variable == "A" ){
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