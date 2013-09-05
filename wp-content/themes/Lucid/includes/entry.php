<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
	<?php
		$index_postinfo = et_get_option('lucid_postinfo1');

		$thumb = '';
		$width = (int) apply_filters('et_blog_image_width',630);
		$height = (int) apply_filters('et_blog_image_height',210);
		$classtext = '';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Blogimage');
		$thumb = $thumbnail["thumb"];

		if ( $index_postinfo ){
			echo '<p class="meta-info">';
			et_postinfo_meta( $index_postinfo, et_get_option('lucid_date_format'), esc_html__('0 comments','Lucid'), esc_html__('1 comment','Lucid'), '% ' . esc_html__('comments','Lucid') );
			echo '</p>';
		}
	?>


	<div class="post_content clearfix">
		<?php if ( 'on' == et_get_option('lucid_thumbnails_index','on') && '' != $thumb ){ ?>
		
			<a href="<?php the_permalink(); ?>">
				
				<div style="float:left;width:90px;height:90px;-webkit-border-radius: 45px;-moz-border-radius:45px;background: url(<?php echo $thumb; ?>) no-repeat;background-size:90px 90px;margin-left:13px;margin-top:9px;margin-right:15px;border:2px solid #fda428;" ></div>
			</a>
		
	<?php } ?><h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			
		<?php
			if ( 'on' == et_get_option('lucid_blog_style') ) the_content('');
			else echo '<p>' . truncate_post(170,false) . '</p>';
		?>
		<a href="<?php the_permalink(); ?>" class="more"><?php esc_html_e( 'Read More', 'Lucid' ); ?></a>
	</div> <!-- end .post_content -->
</article> <!-- end .entry -->