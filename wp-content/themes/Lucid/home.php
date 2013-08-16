<?php get_header(); ?>
 
 <div id="atlasMap"><?php build_i_world_map(1); ?></div>
 <div id="canadaMap"><?php build_i_world_map(11);?> </div> 	
<?php if ( 'on' == et_get_option('lucid_featured', 'on') && is_home() ) get_template_part( 'includes/featured', 'home' ); ?>

<?php
	$recent_sidebars = array('recent-area-1','recent-area-2','recent-area-3');
	if ( is_active_sidebar( $recent_sidebars[0] ) || is_active_sidebar( $recent_sidebars[1] ) || is_active_sidebar( $recent_sidebars[2] ) ) {
		echo '<div id="recent-categories" class="clearfix">';
		foreach ( $recent_sidebars as $key => $recent_sidebar ){
			if ( is_active_sidebar( $recent_sidebar ) ) {
				echo '<div class="recent-category' . (  2 == $key ? ' last' : '' ) . '">';
				dynamic_sidebar( $recent_sidebar );
				echo '</div> <!-- end .recent-category -->';
			}
		}
		echo '</div> <!-- end #recent-categories -->';
	}
?>

<div id="content-area" class="clearfix">
	
	<div id="latest-3">
		
	<?php
	$postCount = 0;
	define(POSTS_PER_PAGE,3);
	$args = array( 'numberposts' => '3', 'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
			
			)
	) );
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
	if(++$postCount !== POSTS_PER_PAGE){echo '
	<div class="latest-3-posts">
		<div class="latest-3-header">	
	<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> 			
	</div> ';
	
	echo'<div class="latest-3-info">';
	print_r(get_post_meta( $recent["ID"], "ABV", true ));
	echo'</div></div>';

}
else{echo '<div class="latest-3-postsLast">
		<div class="latest-3-headerLast">
<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> 			
	  </div> ';
	

	echo'<div class="latest-3-infoLast">';
	print_r(get_post_meta( $recent["ID"], "ABV", true ));
	echo'</div></div>';
	}}
	?>
	
		

	
	</div>
	<div class="pagesInfo">
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			</div>
		</div>
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			</div>
		</div>
		<div class="pagesInfoBoxLast">
			<div class="pagesInfoBoxHeader">
			</div>
		</div>
	</div>

	<div class="pagesInfo">
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			</div>
		</div>
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			</div>
		</div>
		<div class="pagesInfoBoxLast">
			<div class="pagesInfoBoxHeader">
		

			</div>
		</div>
	</div>
		
	</div>
</div> <!-- end #content-area -->

<?php get_footer(); ?>