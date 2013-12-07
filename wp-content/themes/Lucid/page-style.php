<?php
/*
Template Name: Pages by Style
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

<!--end wrap for original gets-->

<?php
$args = array(
  'orderby' => 'name',
   'category__not_in' => array(871, 881, 922),
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);
	$brew = $category->cat_ID;
	$style = $catName;

	if($catName != "Uncategorized" && $catName != "Travel" && $catName != "Recipes" && $catName != "Blog"){
	echo '<a href="http://biegamanmaptest.herokuapp.com/?page_id=2591&brew='. $brew .'&style='.$style.'"><h4 class="beerStyle">' . $category->name . '</h4></a>';
	}

}
?>
	
<!--start wrap again-->
		

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