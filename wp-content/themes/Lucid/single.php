<?php get_header(); ?>



<div id="content-area" class="clearfix<?php if ( 'on' == $et_full_post ) echo ' fullwidth'; ?>">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'single'); ?>
		<?php get_template_part('loop', 'single'); ?>
		
	
	</div> <!-- end #left_area -->
	
	<?php if ( 'on' != $et_full_post ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>