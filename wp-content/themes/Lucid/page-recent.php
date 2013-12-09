<?php
/*
Template Name: Pages by Recent
*/
?>
<?php get_header(); ?>

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
			<?php the_content(); ?>
		</div> 	<!-- end .post_content -->

</article> <!-- end .entry -->

<!--end wrap for original gets-->		

	<?php
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(90, 90);
	
	$postCount = 0;
	
	$args = array( 'posts_per_archive_page' => 10,'nopaging' => false,
	'orderby' => 'date', 
	'post_status' => array('publish'), 		
	'prev_next'    => True,
	'prev_text'    => '<-Previous',
'current'      => 0,

'paged' => get_query_var('paged'), 

			   'category__not_in' => array(871, 881 , 922),'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
			
			)
	) );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
	 ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
	<?php
		$index_postinfo = et_get_option('lucid_postinfo1');

		$thumb = '';
		$width = (int) apply_filters('et_blog_image_width',630);
		$height = (int) apply_filters('et_blog_image_height',210);
		$classtext = '';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Blogimage');
		$thumb = $thumbnail["thumb"];

		
	?>	

	<?php
	

	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
	$beerStyle = get_the_category( $recent["ID"] );
	$post = get_post($recent["ID"]);	
	$content = $post->post_content;
	$content = truncate_post(170,false);	


	echo '<div class="post_content2 clearfix">
	<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;border-radius:45px;background: url('.$image_thumb[0].') no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;margin-bottom:25px;border:2px solid #fda428;" ></div>';
	?>
	<?php 
	echo '
	<h2 class="title"><a href="'. get_permalink($recent["ID"]).'">'. $recent["post_title"] .'</a></h2>';
	echo '<p>'.$content.'</p>';
	?>
	  </div>

	</article> <!-- end .entry -->
	<?php



}




	?>		
<!--start wrap again-->

	
				
	

<?php endwhile; // end of the loop. ?>	

<div id="pagination">
<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

query_posts(array(
	'post_type'      => 'post', // You can add a custom post type if you like
	'paged'          => $paged,
	'posts_per_page' => 10
));

?>
</div>
<?php my_pagination();?>
	</div> <!-- end #left-area -->	
<?php if ( ! $fullwidth ) get_sidebar(); ?>
		
	
</div> 	<!-- end #content-area -->



<?php get_footer(); ?>