<?php get_header(); ?>
 <img id="mapBack" src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/backButton.png">
 <img id="recentBar" src="http://biegamanmaptest.herokuapp.com/wp-content/themes/Lucid/images/recentreviews.png">

 <div id="canadaMap"><?php build_i_world_map(11);?> </div> 
 <div id="argentinaMap"><?php build_i_world_map(21);?> </div> 	
 <div id="australiaMap"><?php build_i_world_map(31); ?></div>
 <div id="austriaMap"><?php build_i_world_map(41); ?></div>
 <div id="barbadosMap"><?php build_i_world_map(51); ?></div>
 <div id="belgiumMap"><?php build_i_world_map(61); ?></div>
 <div id="bosniaMap"><?php build_i_world_map(71); ?></div>
 <div id="brazilMap"><?php build_i_world_map(81); ?></div>
 <div id="mexicoMap"><?php build_i_world_map(91); ?></div>
<div id="italyMap"><?php build_i_world_map(101); ?></div>
<div id="franceMap"><?php build_i_world_map(111); ?></div>
<div id="greeceMap"><?php build_i_world_map(121); ?></div>
<div id="polandMap"><?php build_i_world_map(131); ?></div>
<div id="czechMap"><?php build_i_world_map(141); ?></div>
<div id="norwayMap"><?php build_i_world_map(151); ?></div>
<div id="swedenMap"><?php build_i_world_map(161); ?></div>
<div id="finlandMap"><?php build_i_world_map(171); ?></div>
<div id="lithuaniaMap"><?php build_i_world_map(181); ?></div>
<div id="denmarkMap"><?php build_i_world_map(191); ?></div>
<div id="croatiaMap"><?php build_i_world_map(201); ?></div>
<div id="estoniaMap"><?php build_i_world_map(211); ?></div>
<div id="germanyMap"><?php build_i_world_map(221); ?></div>
<div id="jamaicaMap"><?php build_i_world_map(231); ?></div>
<div id="ukraineMap"><?php build_i_world_map(241); ?></div>
<div id="russiaMap"><?php build_i_world_map(251); ?></div>
<div id="slovakiaMap"><?php build_i_world_map(261); ?></div>
<div id="hungaryMap"><?php build_i_world_map(271); ?></div>
<div id="latviaMap"><?php build_i_world_map(281); ?></div>
<div id="irelandMap"><?php build_i_world_map(291); ?></div>
<div id="ukMap"><?php build_i_world_map(301); ?></div>
<div id="spainMap"><?php build_i_world_map(311); ?></div>
<div id="unitedStatesMap"><?php build_i_world_map(611); ?></div>
<div id="chinaMap"><?php build_i_world_map(321); ?></div>
<div id="columbiaMap"><?php build_i_world_map(331); ?></div>
<div id="costaRicaMap"><?php build_i_world_map(341); ?></div>
<div id="cubaMap"><?php build_i_world_map(351); ?></div>
<div id="cyprusMap"><?php build_i_world_map(361); ?></div>
<div id="dominicaMap"><?php build_i_world_map(371); ?></div>
<div id="dominicanMap"><?php build_i_world_map(381); ?></div>
<div id="icelandMap"><?php build_i_world_map(391); ?></div>
<div id="indiaMap"><?php build_i_world_map(401); ?></div>
<div id="japanMap"><?php build_i_world_map(411); ?></div>
<div id="kenyaMap"><?php build_i_world_map(421); ?></div>
<div id="southKoreaMap"><?php build_i_world_map(431); ?></div>
<div id="lebanonMap"><?php build_i_world_map(441); ?></div>
<div id="netherlandsMap"><?php build_i_world_map(451); ?></div>
<div id="newZealandMap"><?php build_i_world_map(461); ?></div>
<div id="philippinesMap"><?php build_i_world_map(471); ?></div>
<div id="portugalMap"><?php build_i_world_map(481); ?></div>
<div id="romaniaMap"><?php build_i_world_map(491); ?></div>
<div id="serbiaMap"><?php build_i_world_map(501); ?></div>
<div id="singaporeMap"><?php build_i_world_map(511); ?></div>
<div id="sloveniaMap"><?php build_i_world_map(521); ?></div>
<div id="southAfricaMap"><?php build_i_world_map(531); ?></div>
<div id="srilankaMap"><?php build_i_world_map(541); ?></div>
<div id="switzerlandMap"><?php build_i_world_map(551); ?></div>
<div id="thailandMap"><?php build_i_world_map(561); ?></div>
<div id="trinidadMap"><?php build_i_world_map(571); ?></div>
<div id="turkeyMap"><?php build_i_world_map(581); ?></div>
<div id="venezuelaMap"><?php build_i_world_map(591); ?></div>
<div id="vietnamMap"><?php build_i_world_map(601); ?></div>



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
	$args = array( 'numberposts' => '3','category__not_in' => array(871, 881), 'tax_query' => array(
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

	$image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $recent["ID"]));
	$beerStyle = get_the_category( $recent["ID"] );

	echo'<div class="latest-3-info">';
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