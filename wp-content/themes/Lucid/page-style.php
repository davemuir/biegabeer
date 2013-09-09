<?php
/*
Template Name: Pages by Style
*/
?>
<?php get_header(); ?>

<div id="content-area" class="clearfix">
	
	<div id="left-area">
		<?php get_template_part('includes/breadcrumbs', 'page'); ?>
<!--start wrap-->
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix'); ?>>
		<?php
			$thumb = '';
			$width = (int) apply_filters('et_blog_image_width',630);
			$height = (int) apply_filters('et_blog_image_height',210);
			$classtext = '';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Singleimage');
			$thumb = $thumbnail["thumb"];
		?>
		<?php if ( '' != $thumb && 'on' == et_get_option('lucid_page_thumbnails') ) { ?>
			<div class="post-thumbnail">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>
				<div class="post_content clearfix">
			<h1 class="title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
<div class="alphaSelector">
			<a href="#a">A</a>
			<a href="#b">B</a>
			<a href="#c">C</a>
			<a href="#d">D</a>
			<a href="#e">E</a>
			<a href="#f">F</a>
			<a href="#g">G</a>
			<a href="#h">H</a>
			<a href="#i">I</a>
			<a href="#j">J</a>
			<a href="#k">K</a>
			<a href="#l">L</a>
			<a href="#m">M</a>
			<a href="#n">N</a>
			<a href="#o">O</a>
			<a href="#p">P</a>
			<a href="#q">Q</a>
			<a href="#r">R</a>
			<a href="#s">S</a>
			<a href="#t">T</a>
			<a href="#u">U</a>
			<a href="#v">V</a>
			<a href="#w">W</a>
			<a href="#x">X</a>
			<a href="#y">Y</a>
			<a href="#z">Z</a>
			</div>
<!--end wrap for original gets-->

<h3 id="a" class="byCountryLetter" >A</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "A"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>		
<h3 id="b" class="byCountryLetter" >B</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "B"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>		
<h3 id="c" class="byCountryLetter" >C</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "C"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="d" class="byCountryLetter" >D</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "D"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="e" class="byCountryLetter" >E</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "E"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="f" class="byCountryLetter" >F</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "F"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="g" class="byCountryLetter" >G</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "G"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>
<h3 id="h" class="byCountryLetter" >H</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "H"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="i" class="byCountryLetter" >I</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "I"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="k" class="byCountryLetter" >K</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "K"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="l" class="byCountryLetter" >L</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "L"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="m" class="byCountryLetter" >M</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "M"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>
<h3 id="o" class="byCountryLetter" >O</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "O"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>
<h3 id="p" class="byCountryLetter" >P</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "P"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="r" class="byCountryLetter" >R</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "R"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="s" class="byCountryLetter" >S</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "S"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="t" class="byCountryLetter" >T</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "T"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>	
<h3 id="v" class="byCountryLetter" >V</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "V"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>
<h3 id="w" class="byCountryLetter" >W</h3>
<ul>
<?php
$args = array(
  'orderby' => 'name',
  'parent' => 0
  );
$categories = get_categories( $args );



foreach ( $categories as $category) { 
	
	$catName = $category->name;
	$categoryLetter = substr($catName, 0, 1);

	if( $categoryLetter == "W"){
	echo '<li><a href="' . get_category_link( $category->term_id ) . '"><h4 class="beerStyle">' . $category->name . '</h4></a></li>';
	}

}
?>
</ul>					
<!--start wrap again-->
		

			<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Lucid').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_attr__('Edit this page','Lucid')); ?>			
				</div> 	<!-- end .post_content -->
	</article> <!-- end .entry -->
<?php endwhile; // end of the loop. ?>	
		
<!--end wrap again-->		
		
		
		<?php if ( 'on' == et_get_option('lucid_show_pagescomments') ) comments_template('', true); ?>
		
		
	</div> <!-- end #left-area -->
	
	<?php if ( ! $fullwidth ) get_sidebar(); ?>
</div> 	<!-- end #content-area -->

<?php get_footer(); ?>