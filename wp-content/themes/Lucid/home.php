<?php get_header(); ?>
 <img id="mapBack" src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/backButton.png">
 <a href="http://biegamanmaptest.herokuapp.com/?page_id=2151"><img id="recentBar" src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/recentreviews.png"></a>

<?php include 'mapPack/world.php' ; ?>


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
<div class="shadowBox"><!--shadow box--> 
<div id="atlasMap"><?php build_i_world_map(1); ?></div>	
	<div id="latest-3">
		
	<?php
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(90, 90);
	
	$postCount = 0;
	define(POSTS_PER_PAGE,3);
	$args = array( 'numberposts' => '3','category__not_in' => array(871, 881 , 922),'post_status' => array('publish'), 'tax_query' => array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
				
			)
	) );
	
	$recent_posts = wp_get_recent_posts( $args );
	foreach( $recent_posts as $recent ){
	if(++$postCount !== POSTS_PER_PAGE){
	echo '
	<div class="latest-3-posts">
		<div class="latest-3-header">	
	<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' ?>
<?php 
$recentNew = $recent["post_title"]; 
$leng = strlen($recentNew);
echo substr($recentNew, 0, 35);

if($leng > 35){
echo "...";
} echo'</a> 			
	</div> ';

	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
	$beerStyle = get_the_category( $recent["ID"] );

	echo'<div class="latest-3-info">';
	echo '<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;border-radius:45px;background: url('.$image_thumb[0].') no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;border:2px solid #fda428;" ></div>';
	
	echo '<div class="3Info">
	       <br/>Style <span class="orange">: </span>'.$beerStyle[0]->cat_name.'
	       <br/>Brewery <span class="orange">: </span>';
		print_r(get_post_meta( $recent["ID"], "Brewery", true ));
	echo '<br/>ABV <span class="orange">: </span>';
		print_r(get_post_meta( $recent["ID"], "ABV", true ));
	echo '
		<br/><br/>Read the review <a href="' . get_permalink($recent["ID"]) . '">here</a>
		</div>';
	echo'</div></div>';

}
else{echo '<div class="latest-3-postsLast">
		<div class="latest-3-headerLast">
<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> 			
	  </div> ';
	
	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
	

	echo'<div class="latest-3-infoLast">';
	echo '<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;background: url('.$image_thumb[0].') no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;border:2px solid #fda428;" ></div>';
	
	echo '<div class="3Info">
	       <br/>Style <span class="orange">: </span>'.$beerStyle[0]->cat_name.'
	       <br/>Brewery <span class="orange">: </span>';
		print_r(get_post_meta( $recent["ID"], "Brewery", true ));
	echo '<br/>ABV <span class="orange">: </span>';
		print_r(get_post_meta( $recent["ID"], "ABV", true ));
	echo '
		<br/><br/>Read the review <a href="' . get_permalink($recent["ID"]) . '">here</a>
		</div>';
	echo'</div></div>';
	}}
	?>	
<!--end foreach-->
	</div>
</div><!--shadow box-->
<div class="shadowBox">
	<div class="pagesInfo">
		<div class="pagesInfoBox">


			<div class="pagesInfoBoxHeader">
			<?php
				$pageID = 11;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/hopIcon.png"><a href="'.get_page_link($pageID).'">'.$page->post_title.'</a>';
			?>
			</div>
			<div class="page_excerpt">
				<?php echo '<p>'.$page->post_excerpt.'</p>'; ?>
			</div>
		</div>
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			<?php
				$pageID = 201;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/bottleIcon.png"><a href="'.get_page_link($pageID).'">'.$page->post_title.'</a>';
			?>
			</div>
			<div class="page_excerpt">
				<?php echo '<p>'.$page->post_excerpt.'</p>'; ?>
			</div>
		</div>
		<div class="pagesInfoBoxLast">
			<div class="pagesInfoBoxHeaderLast">
			<?php
				$pageID = 441;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/hopIcon.png"><a href="'.get_page_link($pageID).'">'.$page->post_title.'</a>';
			?>
			</div>
			<div class="page_excerptLast">
				<iframe id="iframecode" onload="" scrolling="no" frameborder="0" width="269" src="http://instaembedder.com/gallery.php?username=biegabeerandwine&amp;hashtag=&amp;width=56&amp;cols=4&amp;frame=1&amp;image_border=3&amp;rows=2&amp;cell_margin=5&amp;display_username=0&amp;likes=0&amp;comments=0&amp;date=0&amp;link=0&amp;caption=0&amp;color=gray" style="height: 155px;"></iframe>
			</div>
		</div>
	</div>
</div><!--end box shadow-->
<div class="shadowBox">
	<div class="pagesInfo">
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			<?php
				$pageID = 451;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/bottleIcon.png"><a href="'.get_page_link($pageID).'">'.$page->post_title.'</a>';
			?>
			</div>
			<div class="page_excerpt">
				<?php echo '<p>'.$page->post_excerpt.'</p>'; ?>
			</div>
		</div>
		<div class="pagesInfoBox">
			<div class="pagesInfoBoxHeader">
			<?php
				$pageID = 461;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/hopIcon.png"><a href="'.get_page_link($pageID).'">'.$page->post_title.'</a>';
				
			?>
			</div>
			<div class="page_excerpt">
				<?php echo '<p>'.$page->post_excerpt.'</p>'; ?>
			</div>
		</div>
		<div class="pagesInfoBoxLast">
			<div class="pagesInfoBoxHeaderLast">
			<?php
				$pageID = 471;
				$page = get_page($pageID);
				//print_r($page);
				echo '<img src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/bottleIcon.png"><a href="http://biegamanmaptest.herokuapp.com/?cat=881">'.$page->post_title.'</a>';
			?>
		

			</div>
			<div class="page_excerptLast">
<?php				
				add_theme_support('post-thumbnails');
				set_post_thumbnail_size(90, 90);
				$postCount = 0;
				define(POSTS_PER_PAGE,2);
				$args = array( 'numberposts' => '2','category__in' => array(881), 'tax_query' => array(
				array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-aside',
				'operator' => 'NOT IN'
				
			)
	) );
	
				$recent_posts = wp_get_recent_posts( $args );
				foreach( $recent_posts as $recent ){
				if(++$postCount !== POSTS_PER_PAGE){
					$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
					$page = get_page($recent["ID"]);

					echo '<div style="height:69px;margin-top:12px;"><div style="margin-right:12px;float:left;margin-left:16px;width:59px;height:59px;-webkit-box-shadow:inset 0 0 0 1px rgba(0, 0, 0, 0.12);box-shadow:inset 0 0 0 1px rgba(0, 0, 0, 0.12);background: url('.$image_thumb[0].') no-repeat;background-size:100% auto;" ></div>';		
			echo '<a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a>' ;
			echo '<p style="font-size:14px;line-height:16px;">'.$page->post_excerpt.'</p></div>'; 
			
				}}
?>
			</div>
		</div>
	</div>
</div><!--end box shadow-->		
	</div>
</div> <!-- end #content-area -->

<?php get_footer(); ?>