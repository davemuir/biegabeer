<?php
$page_object = get_queried_object();
$page_id = get_queried_object_id();
$page_cat = get_query_var('cat'); 
?>
<?php 
if($page_id == 881){
get_header('recipes'); 
}
else{
get_header();
}
 ?>


<div id="content-area" class="clearfix">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'index'); ?>
		<?php 
			$catID = get_the_ID();
			$categor = get_the_category($catID);
			$description = category_description($catID);
			 ?>
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part('includes/entry', 'index'); ?>
		<?php
		endwhile;
			if (function_exists('wp_pagenavi')) { wp_pagenavi(); }
			else { get_template_part('includes/navigation','entry'); }
		else:
			get_template_part('includes/no-results','entry');
		endif; ?>
	</div> <!-- end #left-area -->

	<?php get_sidebar(); ?>
</div> <!-- end #content-area -->

<?php get_footer(); ?>