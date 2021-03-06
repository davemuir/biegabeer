<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php if (et_get_option('lucid_integration_single_top') <> '' && et_get_option('lucid_integrate_singletop_enable') == 'on') echo (et_get_option('lucid_integration_single_top')); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
		

		<?php
			global $wp_embed;
			$thumb = '';
			$et_full_post = get_post_meta( get_the_ID(), '_et_full_post', true );
			$width = (int) apply_filters('et_blog_image_width',630);
			if ( 'on' == $et_full_post ) $width = (int) apply_filters( 'et_single_fullwidth_image_width', 960 );
			$height = (int) apply_filters('et_blog_image_height',210);
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Singleimage');
			$thumb = $thumbnail["thumb"];

			$et_video_url = get_post_meta( get_the_ID(), '_et_lucid_video_url', true );
		?>

		<div class="post_content clearfix">
			<h1 class="title"><?php the_title(); ?></h1>
			<?php 
			$id = get_the_ID();
			$brewery = get_post_meta($id, "Brewery", true ); 
			$country = get_post_meta($id, "Country", true ); 
			$region = get_post_meta($id, "Region", true ); 
			$abv = get_post_meta($id, "ABV", true ); 
			$postImg = get_post_meta($id, "postImage", true );
			$brewerInfo = get_post_meta($id, "breweryInfo", true );
			$waterMark = get_post_meta($id, "Watermark", true );
			$style = get_the_category();
			$category_id = get_cat_ID( $style[0]->cat_name );
			$breweryURL = str_replace("&","%26",$brewery);
			 ?>
			
			<?php if($waterMark == true){ ?>
			<img class="waterMark" src="http://biegabeerandwine.s3.amazonaws.com/wp-content/uploads/2013/12/biegastampb2.png">
			
			 <?php } ?>
			<!-- End watermark loop -->
			<div class="clear"></div>
			<?php if($brewery != ""){ ?>
			
			<img class="postImage" src="<?php echo $postImg; ?>" />
			
			<ul class="beerStats">
			<li>Style : <a href="http://biegamanmaptest.herokuapp.com/?page_id=2591&brew=<?php echo $category_id; ?>&style=<?php echo $style[0]->cat_name; ?>"><?php echo $style[0]->cat_name; ?></a></li>
			<li>Brewery : <a href="http://biegamanmaptest.herokuapp.com/?page_id=1771&brew=<?php echo $breweryURL; ?> "><?php echo $brewery; ?></a></li>
			<li>Country : <a href="http://biegamanmaptest.herokuapp.com/?page_id=1161#<?php echo $country; ?>"><?php echo $country; ?> </a></li>
			
			<li>Region : <?php echo $region; ?></li>
			<li>ABV : <?php echo $abv; ?></li>
			</ul>
		<?php } ?>
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Lucid').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_attr__('Edit this page','Lucid')); ?>
		</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->

	<?php if (et_get_option('lucid_integration_single_bottom') <> '' && et_get_option('lucid_integrate_singlebottom_enable') == 'on') echo(et_get_option('lucid_integration_single_bottom')); ?>

	<?php
		if ( et_get_option('lucid_468_enable') == 'on' ){
			if ( et_get_option('lucid_468_adsense') <> '' ) echo( et_get_option('lucid_468_adsense') );
			else { ?>
			   <a href="<?php echo esc_url(et_get_option('lucid_468_url')); ?>"><img src="<?php echo esc_url(et_get_option('lucid_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
	<?php 	}
		}
	?>
	
	<?php
	if($category_id != 881 && $category_id != 922){
		if ( 'on' == et_get_option('lucid_show_postcomments') ) comments_template('', true);
	}
	?>
<?php endwhile; // end of the loop. ?>

		
	
