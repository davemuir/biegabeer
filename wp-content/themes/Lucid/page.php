<?php
$page_object = get_queried_object();
$page_id = get_queried_object_id();
?>

<?php 


if($page_id == 201 || $page_id == 3331 || $page_id == 3291 || $page_id == 3311 || $page_id == 3271){
get_header('101'); 
}
else if($page_id == 11 || $page_id == 4201 || $page_id == 4231 || $page_id == 3501){
get_header('about');
}
else if($page_id == 461 || $page_id == 3481 || $page_id == 3461 || $page_id == 3521){
get_header('readings');
}
else if($page_id == 1201 || $page_id == 1141 || $page_id == 1181 || $page_id == 1161 || $page_id == 2151){
get_header('reviews');
}
else if($page_id == 881){
get_header('recipes');
}
else{
get_header(); 
}
?>

<div id="content-area" class="clearfix">

	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'page'); ?>
		<?php get_template_part('loop', 'page'); ?>
		<?php if ( 'on' == et_get_option('lucid_show_pagescomments') ) comments_template('', true); ?>
	</div> <!-- end #left-area -->

	<?php get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>