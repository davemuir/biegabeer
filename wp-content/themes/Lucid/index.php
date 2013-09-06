<?php get_header(); ?>

<div id="content-area" class="clearfix">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'index'); ?>
		<?php 
			$catID = get_the_ID();
			$categor = get_the_category($catID);
			$description = category_description($catID);
			 ?>
		<div class="catDescription">
		<p>
		<h2 class="title"><?php echo $categor[0]->cat_name ; ?></h2>
		<?php echo $categor[0]->description; ?>
		</p>
</div>
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