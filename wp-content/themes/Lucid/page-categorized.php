<?php
/*
Template Name: Pages by Categorized
*/
?>
<?php get_header(); ?>
<?php $brew = $_GET['brew']; $style = $_GET['style']; ?>		
<div id="content-area" class="clearfix">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'index'); ?>
		<?php 
			$catID = $brew;
			$categor = get_the_category($catID);
			$description = category_description($catID);
			
			 ?>
		<div class="catDescription">
		<h2 class="title"><?php echo  $style; ?></h2>
		<div class="catDescriptionText">
		<p>
		<?php echo $description; ?>
		</p>
		</div>
		</div>
		<?php
query_posts(array(
    'cat' => $brew, // get posts by category name
    'posts_per_page' => -1 // all posts
));
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