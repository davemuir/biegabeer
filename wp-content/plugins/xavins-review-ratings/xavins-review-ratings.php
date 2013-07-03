<?php
/*
Plugin Name: Xavin's Review Ratings
Plugin URI: http://www.jonathanspence.com/software/wordpress-plugins/xavins-review-ratings/
Description: Adds a shortcode tag [xrr rating=4/5] to display a rating.
Version: 1.3.1
Author: Jonathan 'Xavin' Spence
Author URI: http://www.jonathanspence.com/
*/

/*  Copyright 2008  Jonathan Spence  (email : gpl@jonathanspence.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );

define( 'XRR_VERSION', '1.3.1' );	  
define( 'XRR_DEFAULT_SINGLE_TEMPLATE', '<p><strong class="rating">*label*</strong>&nbsp;*rating*</p>' );
define( 'XRR_DEFAULT_GROUP_TEMPLATE', '<tr><td><strong class="ratingGroup">*label*</strong></td><td>*rating*</td></tr>' );
define( 'XRR_DEFAULT_GROUP_FRAME_TEMPLATE', '<table><tbody>*ratings*</tbody></table>' );
define( 'XRR_DEFAULT_IMAGE_TEMPLATE', '<img src="*imageurl*" alt="*textstars*" title="*fraction*" />' );

// sets the deafult options
function xrr_set_default_options() {
	update_option('xrr_single_template', XRR_DEFAULT_SINGLE_TEMPLATE);
	update_option('xrr_group_template', XRR_DEFAULT_GROUP_TEMPLATE);
	update_option('xrr_group_frame_template', XRR_DEFAULT_GROUP_FRAME_TEMPLATE);
	update_option('xrr_image_template', XRR_DEFAULT_IMAGE_TEMPLATE);
	update_option('xrr_max_stars', '5');
	update_option('xrr_display_as', 'stars'); // 'stars' 'percentage' 'fraction' 'textstars' 'fraction_stars'
	update_option('xrr_max_fraction', '4'); // none=1 half=2 quarter=4
	update_option('xrr_label', 'Rating:');
	update_option('xrr_imageset', 'default');
	update_option('xrr_fraction_separator', '/');
	update_option('xrr_always_show_decimal', 'false');
	update_option('xrr_version', XRR_VERSION);
}

// checks to make sure options added in new versions exist
function xrr_check_for_upgrade() {
	if (get_option('xrr_version') != XRR_VERSION) {
		
		// we need to upgrade
		$old_version = get_option('xrr_version');
		
		if ($old_version === false) { // 1.2, didn't have version option
			// 1.2 => 1.3
			update_option('xrr_image_template', XRR_DEFAULT_IMAGE_TEMPLATE);
			delete_option('xrr_image_path');
			delete_option('xrr_image_extension');
			$old_version = '1.3';
		}
		
		if ($old_version === '1.3') {
			// 1.3 => 1.3.1
			update_option('xrr_always_show_decimal', 'false');
			$old_version = '1.3.1';		
		}
		
		if ($old_version === '1.3.1') {
			// 1.4 => ???
		
		}		
		
		update_option('xrr_version', XRR_VERSION);
	}
}

// add the options page to admin
function xrr_add_pages() {
	add_options_page("Xavin's Review Ratings", "X Review Ratings", 8, basename(__FILE__), 'xrr_options_page');
}

// display options page
function xrr_options_page() {
	include 'xavins-review-ratings-options.php';
	xrr_options_main();
}

function is_whole_num($num) {
	return((intval($num) - $num) == 0);
}

// converts the rating into a percentage
function xrr_get_intermediate_rating($score, &$max_stars) {
	
	if (strpos($score, '/') != 0) { // fraction
		$parts = explode('/', $score);
		$rating = round( ($parts[0] / $parts[1]) * 100);
		$max_stars = $parts[1]; // pass back the denominator to be the new max_fraction, assuming they set it implicitly
	
	} elseif (strpos($score, '%') != 0) { // percentage
		$parts = explode('%', $score);
		$rating = (int) $parts[0];
	
	} else {
		$rating = 0;
	}	
	
	return $rating;
}

// converts the percentage into the final star value
function xrr_get_final_rating($intermediate_score, $max_stars, $max_fraction) {

	$stars = $intermediate_score / 100 * $max_stars;
	$stars = round($stars * $max_fraction);
	$stars = $stars / $max_fraction;
	
	return $stars;
}

function xrr_process_image_template($content, $imageurl, $textstars, $fraction, $percentage) {
	
	$content = str_replace('*imageurl*', $imageurl, $content);
	$content = str_replace('*textstars*', $textstars, $content);
	$content = str_replace('*percentage*', $percentage.'%', $content);
	$content = str_replace('*fraction*', $fraction, $content);
	
	return $content;
}

function xrr_get_imageset_extension($path) {
	$star_file = $path.'/star';

	if (file_exists($star_file.'.png')) {
		return '.png';
	
	} elseif (file_exists($star_file.'.gif')) {
		return '.gif';
		
	} elseif (file_exists($star_file.'.jpg')) {
		return '.jpg';
	}
	return '';
}

function xrr_render_stars($stars, $score, $atts, $use_images) {
	extract($atts);
	
	$imageset_name = $atts['imageset'];
	global $xrr_imageset_loc;
	global $xrr_imageset_extension;
	if (!is_array($xrr_imageset_loc)) {
		$xrr_imageset_loc = array();
		$xrr_imageset_extension = array();
	}
	
	if (!$xrr_imageset_loc[$imageset_name]) {
	
		// find the location of the current imageset
		if(file_exists( WP_PLUGIN_DIR.'/xavins-review-ratings/'.$imageset_name )) {
			// this is an imageset distributed with the plugin
			$xrr_imageset_extension[$imageset_name] = xrr_get_imageset_extension( WP_PLUGIN_DIR.'/xavins-review-ratings/'.$imageset_name );
			$xrr_imageset_loc[$imageset_name] = WP_PLUGIN_URL.'/xavins-review-ratings/'.$imageset_name.'/';
			
		} else {
			$wud = wp_upload_dir();
			
			if (file_exists( $wud['basedir'].'/xavins-review-ratings/'.$imageset_name )) {
				// this is a user uploaded imageset
				$xrr_imageset_extension[$imageset_name] = xrr_get_imageset_extension( $wud['basedir'].'/xavins-review-ratings/'.$imageset_name );
				$xrr_imageset_loc[$imageset_name] = $wud['baseurl'].'/xavins-review-ratings/'.$imageset_name.'/';
			} else {
				// can't find it at all
				$xrr_imageset_extension[$imageset_name] = '';
				$xrr_imageset_loc[$imageset_name] = '#';
			}
		}
		
	}

	$image_extension = $xrr_imageset_extension[$imageset_name];
	$imageset_url = $xrr_imageset_loc[$imageset_name];
	
	// how many full stars
	$full_stars = floor($stars);
	
	// how many partial stars
	$fraction = $stars - $full_stars;
	switch($fraction) {
		case 0.25:
			$mid_star = 'quarter_star';
			$mid_star_text = '&frac14;';
			break;
		case 0.5:
			$mid_star = 'half_star';
			$mid_star_text = '&frac12;';
			break;
		case 0.75:
			$mid_star = 'threequarter_star';
			$mid_star_text = '&frac34;';
			break;
		default:
			$mid_star = '';
			$mid_star_text = '';
			break;
	}
	
	// how many empty stars
	if ($mid_star == '') { 
		$partial_star = 0;
		$blank_stars =  $max_stars - $full_stars;
	} else {
		$partial_star = 1;
		$blank_stars =  $max_stars - $full_stars - 1;
	}
	
	// render the stars
	$final_fraction = xrr_render_fraction($stars, $atts);
	if ($use_images === 'true') {
		
		$content_images = '';
		// full stars
		$templated = xrr_process_image_template(get_option('xrr_image_template'), $imageset_url.'star'.$image_extension, '&#9733;', $final_fraction, $score);
		$content_images .= str_repeat ($templated, $full_stars);
		// partial star
		$templated = xrr_process_image_template(get_option('xrr_image_template'), $imageset_url.$mid_star.$image_extension, $mid_star_text, $final_fraction, $score);
		$content_images .= str_repeat ($templated, $partial_star);
		// empty stars
		$templated = xrr_process_image_template(get_option('xrr_image_template'), $imageset_url.'blank_star'.$image_extension, '&#9734;', $final_fraction, $score);
		$content_images .= str_repeat ($templated, $blank_stars);
		
		$content .= $content_images;
		
	} else {
		$content .= str_repeat ('&#9733;' , $full_stars);
		$content .= str_repeat ($mid_star_text , $partial_star);
		$content .= str_repeat ('&#9734;' , $blank_stars);
	}	
	
	return $content;
}


function xrr_render_fraction($stars, $atts) {
	$frac = $stars;
	if (is_whole_num($stars) && $atts['always_show_decimal'] === 'true')
		$frac .= '.0';
	$frac .= $atts['fraction_separator'];
	$frac .= $atts['max_stars'];
	if (is_whole_num($atts['max_stars']) && $atts['always_show_decimal'] === 'true')
		$frac .= '.0';

	return $frac;
}

function xrr_render_percentage($score, $atts) {
	return $score.'%';
}


// replaces the [xrr] shortcode with the rating
function xrr_process($args = array(), $inner_text=null) {
		
	$atts = shortcode_atts(array(
		'rating'				=> '',
		'max_stars'				=> (int)get_option('xrr_max_stars'),
		'display_as'			=> get_option('xrr_display_as'), 
		'max_fraction'			=> (int)get_option('xrr_max_fraction'), 
		'group'					=> 'xrr',
		'overall'				=> 'false',
		'label'					=> get_option('xrr_label'),
		'escape'				=> 'false',
		'imageset'  			=> get_option('xrr_imageset'),
		'fraction_separator'	=> get_option('xrr_fraction_separator'),
		'always_show_decimal'	=> get_option('xrr_always_show_decimal') ), $args );
		
	extract($atts);
	
	if ($escape != 'true') {
	
		//**** Score Calculation
		global $xrr_scores;
	
		if ($overall === 'true') {
			// this is an average rating
			if ($xrr_scores[$group]) {
				$score = round( array_sum($xrr_scores[$group])/count($xrr_scores[$group]) );
			} else {
				$score = 0;
			}
			
		} else {
			// a normal rating
			$score = xrr_get_intermediate_rating($rating, $max_stars);
			
			if (array_key_exists('max_stars', $args)) {
				$max_stars = $atts['max_stars']; // they explicitly used the max_stars tag, so ignore the denominator of the rating
			} else {
				$atts['max_stars'] = $max_stars; // assume they want to set the new max_stars value implicitly from the rating denominator
			}
						
			if (!$xrr_scores[$group])
				$xrr_scores[$group] = array();
			array_push($xrr_scores[$group], $score);
		}
	
		//**** Render Rating
		global $xrr_in_grouping;
		if ($xrr_in_grouping != true) 
			$content = get_option('xrr_single_template');
		else
			$content = get_option('xrr_group_template');
			
		if (is_feed() && $display_as === 'stars') {
			// only show the text
			$display_as = 'textstars';
		}
		
		$star_render = '';
		$stars = xrr_get_final_rating($score, $max_stars, $max_fraction);		
		$display_types = explode('_', $display_as);
		
		foreach ($display_types as $value) {
		
			switch($value) {
				case 'stars':
					$star_render .= xrr_render_stars($stars, $score, $atts, 'true');
					break;
					
				case 'textstars':				
					$star_render .= xrr_render_stars($stars, $score, $atts, 'false');
					break;

				case 'percentage':
					$star_render .= xrr_render_percentage($score, $atts);
					break;
					
				case 'fraction':
					$star_render .= xrr_render_fraction($stars, $atts);
					break;				
			}
			$star_render .= '&nbsp;';
		}
		
		// put any inner text after the rating. This is buggy in 2.6.1 if there are multiple tags in one post
		if (!is_null($inner_text)) {
			$star_render .= $inner_text;
		}
		
		$content = str_replace('*label*', $label, $content);
		$content = str_replace('*rating*', $star_render, $content);
		
	} else {
		// escape is true, we want to show the shortcode instead of processing it
		$content = '[xrr';
		foreach ($args as $key => $value) {
			if ($key != 'escape')
				$content .= ' '.$key.'="'.$value.'"';
		}
		$content .= ']';
	}
	
	return $content;	
}

// Processes [xrrgroup] shortcode
function xrrgroup_process($args = '', $inner_text=null) {
	$atts = shortcode_atts(array(
		'escape'	=> 'false' ), $args );
		
	extract($atts);
	
	if ($escape != 'true') {
	
		if (!is_null($inner_text)) {
			//strip out any <p>tags</p> as they will just mess up the table rendering
			//$inner_text = preg_replace('/<\/*p>/i', '', $inner_text); // wordpress can't handle this
		
			global $xrr_in_grouping;
			$xrr_in_grouping = true;
			$content = get_option('xrr_group_frame_template');
			$content = str_replace('*ratings*', do_shortcode($inner_text), $content);
			$xrr_in_grouping = false;
		}
		
	} else {
		// escape is true, we want to show the shortcode instead of processing it
		$content = '[xrrgroup';
		foreach ($args as $key => $value) {
			if ($key != 'escape')
				$content .= ' '.$key.'="'.$value.'"';
		}
		$content .= ']';
	}
	
	return $content;	

}

xrr_check_for_upgrade();

register_activation_hook(__FILE__, 'xrr_set_default_options');

add_action('admin_menu', 'xrr_add_pages');

add_shortcode('xrr', 'xrr_process');
add_shortcode('rating', 'xrr_process');
add_shortcode('xrrgroup', 'xrrgroup_process');
?>