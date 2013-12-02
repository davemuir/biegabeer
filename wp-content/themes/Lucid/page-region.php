<?php
/*
Template Name: Pages by Region
*/
?>
<?php get_header(); ?>
<?php 
	$variable = $_GET['var'];
	
	?>
<div id="content-area" class="clearfix">
	
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
			<h2><?php echo $variable; ?></h2>
</div> 	<!-- end .post_content -->

</article> <!-- end .entry -->
<!--end wrap for original gets-->	


<?php $args = array(
	'posts_per_page'   => 2000,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'meta_value',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => 'Region',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
?>
<?php	


	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
<?php 
	
		$postID = get_the_ID();
		$postRegionVar = get_post_meta($postID, "Region", true );
	
	 	?>

			<?php 
			if($variable == $postRegionVar){ 
				$permalink = get_permalink($postID);
				$title = get_the_title($postID);
				$content = $post->post_content;
				$content = truncate_post(170,false);
				$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $postID));
			?>
			<article id="post-<?php $postID; ?>"   <?php post_class('entry clearfix'); ?>>
			
			<?php	
			echo '<div class="post_content clearfix">
	<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;border-radius:45px;background: url('.$image_thumb[0].') no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;margin-bottom:25px;border:2px solid #fda428;" ></div>';
	?>
	<?php 
	echo '
	<h2 class="title"><a href="'. $permalink .'">'. $title .'</a></h2>';
	echo '<p>'.$content.'</p>';
	?>
	  
		</div>
	</article> <!-- end .entry -->	

	 
	 		<?php } ?>
		
	
	
	<?php endforeach; 
	wp_reset_postdata();?>


<!--start wrap again-->
		

			<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Lucid').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_attr__('Edit this page','Lucid')); ?>			
				
	

	<?php endwhile; // end of the loop. ?>		
<!--end wrap again-->		
		
		
		<?php if ( 'on' == et_get_option('lucid_show_pagescomments') ) comments_template('', true); ?>
		
		
	</div> <!-- end #left-area -->
	
	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>