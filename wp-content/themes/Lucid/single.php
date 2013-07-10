<?php get_header(); ?>

<?php $et_full_post = get_post_meta( get_the_ID(), '_et_full_post', true ); ?>

<div id="content-area" class="clearfix<?php if ( 'on' == $et_full_post ) echo ' fullwidth'; ?>">
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'single'); ?>
		<?php get_template_part('loop', 'single'); ?>
	</div> <!-- end #left_area -->
	<h1>single post</h1>
	<?php if ( 'on' != $et_full_post ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>