<?php
/*
* The image proxy
* This file renders images with WP Image Protect
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*
*/

//error_reporting(E_ALL);



 $wpipp_visible_enabled = NULL;
 $wpipp_visible_enabled_string = NULL;
 $wpipp_minimum_image_size = NULL;
 $wpipp_minimum_image_size_string = NULL;
 $wpipp_watermark_text = NULL;
 $wpipp_watermark_text_string = NULL;
 $wpipp_watermark_text_font = NULL;
 $wpipp_watermark_text_font_string = NULL;
 $wpipp_watermark_text_size = NULL;
 $wpipp_watermark_text_size_string = NULL;
 $wpipp_watermark_text_colour = NULL;
 $wpipp_watermark_text_colour_string = NULL;
 $wpipp_watermark_text_border_width = NULL;
 $wpipp_watermark_text_border_width_string = NULL;
 $wpipp_watermark_text_background_colour = NULL;
 $wpipp_watermark_text_background_colour_string = NULL;
 $wpipp_watermark_image_url = NULL;
 $wpipp_watermark_image_url_string = NULL;
 $wpipp_watermark_position = NULL;
 $wpipp_watermark_position_string = NULL;
 $wpipp_watermark_transparency = NULL;
 $wpipp_watermark_transparency_string = NULL;
 $wpipp_caching_option = NULL;
 $wpipp_caching_option_string = NULL;
 $wpipp_hotlinking_option = NULL;
 $wpipp_hotlinking_option_string = NULL;
 $wpipp_watermark_scale = NULL;
 $wpipp_watermark_scale_string = NULL;
 $font = NULL;
 $font_size = NULL;
 $font_angle = NULL;
 $original_image_path = NULL;
 $relative_path = NULL;
 $full_image_src = NULL;
 $original_image = NULL;
 $original_image_post_id = NULL;
 $wpipp_exclude_from_watermark = NULL;
 $watermark_width = NULL;
 $watermark_height = NULL;
 $original_image_width = NULL;
 $original_image_height = NULL;
 $wpipp_debug_message_string = "";


	
//attempt to load premium file (not used for lite)
@include_once( dirname(dirname(dirname(__FILE__))) . '/wp-image-protect-premium/php/wpipp-image-manager-premium.php');



/*
* Load WP variables
*/
function load_wp_variables(){

	global $wpipp_visible_enabled, $wpipp_visible_enabled_string, $wpipp_minimum_image_size, $wpipp_minimum_image_size_string, $wpipp_watermark_text, $wpipp_watermark_text_string, $wpipp_watermark_text_font, $wpipp_watermark_text_font_string, $wpipp_watermark_text_size, $wpipp_watermark_text_size_string, $wpipp_watermark_text_colour, $wpipp_watermark_text_colour_string, $wpipp_watermark_text_border_width, $wpipp_watermark_text_border_width_string, $wpipp_watermark_text_background_colour, $wpipp_watermark_text_background_colour_string, $wpipp_watermark_image_url, $wpipp_watermark_image_url_string, $wpipp_watermark_position, $wpipp_watermark_position_string, $wpipp_watermark_transparency, $wpipp_watermark_transparency_string, $wpipp_caching_option, $wpipp_caching_option_string, $wpipp_hotlinking_option, $wpipp_hotlinking_option_string, $wpipp_watermark_scale, $wpipp_watermark_scale_string, $wpipp_debug_option, $wpipp_debug_option_string;
	

	//get wordpress variables
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	define('WPIPP_WP_BASE', $parse_uri[0]);
	$wp_load = WPIPP_WP_BASE.'wp-load.php';
	define('SHORTINIT', true);

	define('VIEW_COUNT_META_KEY', '_wpipp_view_count');
	define('HOTLINK_COUNT_META_KEY', '_wpipp_hotlink_count');
	//load required  wordpress modules
	@require_once($wp_load);
	@require_once(WPIPP_WP_BASE . WPINC . '/formatting.php');
	@require_once(WPIPP_WP_BASE . WPINC . '/link-template.php');
	@require_once(WPIPP_WP_BASE . WPINC . '/post.php');
	@require_once(WPIPP_WP_BASE . WPINC . '/meta.php');
	

	
	//visible_enabled
	$wpipp_visible_enabled = get_option('wpippDisplay_visible_enabled');
	$wpipp_visible_enabled_string = $wpipp_visible_enabled['text_string'];
	//minimum image size to watermark
	$wpipp_minimum_image_size = get_option('wpippDisplay_watermark_on_size');
	$wpipp_minimum_image_size_string = $wpipp_minimum_image_size['text_string'];
	//watermark_text
	$wpipp_watermark_text = get_option('wpippDisplay_watermark_text');
	$wpipp_watermark_text_string = $wpipp_watermark_text['text_string'];
	//watermark_text_font
	$wpipp_watermark_text_font = get_option('wpippDisplay_watermark_text_font');
	$wpipp_watermark_text_font_string = $wpipp_watermark_text_font['text_string'];
	//watermark_text_size
	$wpipp_watermark_text_size = get_option('wpippDisplay_watermark_text_size');
	$wpipp_watermark_text_size_string = $wpipp_watermark_text_size['text_string'];
	//watermark_text_colour
	$wpipp_watermark_text_colour = get_option('wpippDisplay_watermark_text_colour');
	$wpipp_watermark_text_colour_string = $wpipp_watermark_text_colour['text_string'];
	//watermark_text_border_width
	$wpipp_watermark_text_border_width = get_option('wpippDisplay_watermark_text_border_width');
	$wpipp_watermark_text_border_width_string = $wpipp_watermark_text_border_width['text_string'];
	//watermark_background_colour
	$wpipp_watermark_text_background_colour = get_option('wpippDisplay_watermark_text_background_colour');
	$wpipp_watermark_text_background_colour_string = $wpipp_watermark_text_background_colour['text_string'];
	//watermark url
	$wpipp_watermark_image_url = get_option('wpippDisplay_wpipp_watermark_image_url');
	$wpipp_watermark_image_url_string = $wpipp_watermark_image_url['text_string'];
	//watermark position
	$wpipp_watermark_position = get_option('wpippDisplay_watermark_position');
	$wpipp_watermark_position_string = $wpipp_watermark_position['text_string'];
	//watermark transparency
	$wpipp_watermark_transparency = get_option('wpippDisplay_watermark_transparency');
	$wpipp_watermark_transparency_string = $wpipp_watermark_transparency['text_string'];
	//caching
	$wpipp_caching_option = get_option('wpippDisplay_caching_option');
	$wpipp_caching_option_string = $wpipp_caching_option['text_string'];
	//hotlinking prevention
	$wpipp_hotlinking_option = get_option('wpippDisplay_hotlinking_option');
	$wpipp_hotlinking_option_string = $wpipp_hotlinking_option['text_string'];
	//render
	$wpipp_render_option = get_option('wpippDisplay_render_option');
	$wpipp_render_option_string = $wpipp_render_option['text_string'];
	//watermark_scale
	$wpipp_watermark_scale = get_option('wpippDisplay_watermark_scale');
	$wpipp_watermark_scale_string = $wpipp_watermark_scale['text_string'];
	//watermark_debug
	$wpipp_debug_option = get_option('wpippDisplay_debug_option');
	$wpipp_debug_option_string = $wpipp_debug_option['text_string'];


} //end load_wp_variables

/*
* set the font variables
*/
function set_font_variables(){
	global $font, $wpipp_watermark_text_font_string, $font_size, $wpipp_watermark_text_size_string, $font_angle;
	
	set_font_environment();
	// Name the font to be used (note use without the .ttf extension)
	$font = $wpipp_watermark_text_font_string;

	//font size
	$font_size = intval($wpipp_watermark_text_size_string);

	//font angle
	$font_angle = 0;
}//end set_font_variables


//pluggable function set_font_environment
if(!function_exists('set_font_environment')){
	function set_font_environment(){
		// Set the enviroment variable for GD
		putenv('GDFONTPATH=' . realpath(dirname(dirname(__FILE__)).'/fonts/'));
	}
}



/*
* set original image properties 
*/
function load_original_image_properties(){
	global $original_image_post_id, $original_image_path, $relative_path, $full_image_src;

	//image file path
	$original_image_path = isset($_GET['src']) ? $_GET['src'] : "";

	//define relative path to root of wp-content
	$relative_path = '../../../../';
	//following does not work well outside core
	//$upload_dir = wp_upload_dir();
	//$relative_path = $upload_dir['baseurl'];

	//retain the full image src
	$full_image_src = site_url("/") . $original_image_path;

	if($original_image_path == ""){
		//set a default watermark
		$original_image_path = '../img/wpipp_scenery.JPG';
	} else {
		//append the relative file path to the image path
		$original_image_path = $relative_path . $original_image_path;
	}

	//get the post id for the url, will return 0 if no post id
	$original_image_post_id = get_post_id_from_url($full_image_src);

	populate_original_image_size_from_filename($original_image_path);

}//end set_original image_properties

/*
* load original image
*/
function load_original_image(){
	global $original_image_path, $original_image, $image_width, $image_height, $original_image_post_id, $full_image_src;

	$file_type_str = substr($original_image_path,strlen($original_image_path)-4,4);
	$file_type_str = strtolower($file_type_str);
	if($file_type_str == ".gif") $original_image = @imagecreatefromgif($original_image_path);
	if($file_type_str == ".jpg" || $file_type_str == "jpeg") $original_image = @imagecreatefromjpeg($original_image_path);
	if($file_type_str == ".png") $original_image = @imagecreatefrompng($original_image_path);
	if (!$original_image){
        /* Create a black image */
        $original_image  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($original_image, 255, 255, 255);
        $tc  = imagecolorallocate($original_image, 0, 0, 0);

        imagefilledrectangle($original_image, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($original_image, 1, 5, 5, 'Error loading ' . $original_image_path, $tc);
        die();
	}

	//fix original image alpha transparencies
	imagealphablending($original_image, true); 
	imagesavealpha($original_image, true);

	//repopulate/get the dimensions of the image (just incase this could not be loadeded in load_original_image_properties)
	$image_width = imagesx($original_image);
	$image_height = imagesy($original_image);

		
}//end load_orginal_image

/**
* increments the image view counter
*/
function increment_image_view_counter(){
	global $original_image_post_id;

	$image_view_count = get_post_meta($original_image_post_id, VIEW_COUNT_META_KEY, true);
	if(!$image_view_count || $image_view_count==''){
		$image_view_count = '0';
	}

	$image_view_count = intval($image_view_count) + 1;

	update_post_meta($original_image_post_id, VIEW_COUNT_META_KEY, $image_view_count);

}

/*
* populate original image size from filename
* volatile
*/
function populate_original_image_size_from_filename($filename){
	global $original_image_width, $original_image_height;
	if(file_exists($filename)){
		//0 is width, 1 is height
		$size = getimagesize($filename);
		$original_image_width = $size[0];
		$original_image_height = $size[1];
	}
}

/*
* exclude from watermark test
*/
function exclude_from_watermark_functions(){
	global $original_image_post_id, $wpipp_exclude_from_watermark;
	//if the image is excluded from watermarking, do not watermark
	if($original_image_post_id>0){
		$wpipp_exclude_from_watermark =  (bool) get_post_meta($original_image_post_id, 'wpipp_exclude_from_watermark', true);	
	}

	if($wpipp_exclude_from_watermark){
		//if image is excluded return the original image unaltered and exit
		render_original_image();
	}
}//end exclude_from_watermark_functions


/*
* minimum image size functions
*/
function minimum_image_size_functions(){
	global $wpipp_minimum_image_size_string, $image_width, $image_height;
	//if the orginal image width and height is less than the minimum required image size specified in settings, do not watermark
	$wpipp_minimum_image_size_int = 0;

	if(is_numeric($wpipp_minimum_image_size_string)){
		$wpipp_minimum_image_size_int = intval($wpipp_minimum_image_size_string);
	}

	//ensure image is loaded by ensuring $image_width is greater than 0
	if($image_width < $wpipp_minimum_image_size_int and $image_height < $wpipp_minimum_image_size_int and $image_width > 0){
		//if the image is too small for watermarking, return the original image unaltered and exit
		render_original_image();
	}

}//end minimum_image_size_functions




/*
* text watermark
*/
function text_watermark($text = NULL, $background_colour = NULL, $text_colour = NULL){
	global $wpipp_watermark_text_string, $original_image_post_id, $wpipp_watermark_text_border_width_string, $wpipp_watermark_text_colour_string, $wpipp_watermark_text_background_colour_string, $font_size, $font_angle, $font;

	if(pathinfo($font, PATHINFO_EXTENSION)==''){
		//add ttf extension
		$font = $font . '.ttf';
	}


	if($text == NULL){
		$text = $wpipp_watermark_text_string;
		if(function_exists('render_special_text') && $original_image_post_id)
		{
			$text = render_special_text($text, $original_image_post_id);
		}

	}
	//assign default text if no src
	if($text == "" ){
		$text = "WPIPP - Text Undefined";
	}
	if($background_colour == NULL){
		$background_colour = $wpipp_watermark_text_background_colour_string;
	}
	if($text_colour == NULL){
		$text_colour = $wpipp_watermark_text_colour_string;
	}
	
	//set the border, default to 5
	$wpipp_watermark_text_border_width_int = 5;
	if(is_null($wpipp_watermark_text_border_width_string) or $wpipp_watermark_text_border_width_string=="0") {
		//default border to 1/4 of the font size
		$wpipp_watermark_text_border_width_int == $font_size/4;
	} else {
		$wpipp_watermark_text_border_width_int = intval($wpipp_watermark_text_border_width_string);
	}
	
	//peg lower limit at 1
	if($wpipp_watermark_text_border_width_int<1){
		$wpipp_watermark_text_border_width_int = 1;
	}
	//peg upper limit at 100
	if($wpipp_watermark_text_border_width_int>100){
		$wpipp_watermark_text_border_width_int = 100;
	}

	$border =  $wpipp_watermark_text_border_width_int;

	// First we create our bounding box for the first text
	$bbox = imagettfbbox($font_size, $font_angle, $font, $text);		

	// This is our cordinates for X and Y
	$bbox_x = ($bbox[4]- $bbox[0]) ;
	$bbox_y = ($bbox[5]-$bbox[1])*-1;

	// Create the watermark image
	$watermark = imagecreatetruecolor($bbox_x + ($border*2), $bbox_y +  ($border*2)) ;

	if($background_colour==""){
		$background_colour = "none";
	}

	//make the background image transparent
	if($background_colour=="none"){
		//make backgground transparent
		$transparent_colour = imagecolorallocatealpha($watermark, 0, 0, 0, 127);
		imagefill($watermark, 0, 0, $transparent_colour);
	} else {
		$fillcolourarray = get_rgb_from_hex($background_colour);
		$fillcolour = imagecolorallocate($watermark, $fillcolourarray['red'], $fillcolourarray['green'], $fillcolourarray['blue']);
		imagefill($watermark, 0, 0, $fillcolour);
	}
	

	// Create some colors
	$white = imagecolorallocate($watermark, 255, 255, 255);
	$grey = imagecolorallocate($watermark, 128, 128, 128);
	$black = imagecolorallocate($watermark, 0, 0, 0);
	//imagefilledrectangle($watermark, 0, 0, $bbox_x+($border*2), $bbox_y+($border*2), $grey);
	
	//bounding box
	//imagefilledrectangle($watermark, $border, $border, $bbox_x+$border, $bbox_y+$border, $white);

	$font_colour = $black;
	if($text_colour){
		$custom_colour = get_rgb_from_hex($text_colour);
		$font_colour = imagecolorallocate($watermark, $custom_colour['red'], $custom_colour['green'], $custom_colour['blue']);
	}



	// Add the text
	imagettftext($watermark, $font_size, $font_angle, $border, $font_size+$border, $font_colour, $font, $text);
	return $watermark;	
		
	die();
}//end text_watermark


/*
* scale watermark
* scales the watermark
* watermark - the watermark to be used
* original_image - the original target image
* returns - the scaled watermark
*/
function scale_watermark_to_image($watermark, $original_image){
	global $watermark_width, $watermark_height, $original_image_width, $original_image_height, $wpipp_watermark_scale_string, $wpipp_debug_message_string;

	if($wpipp_watermark_scale_string=="on"){
		//get the width and height of the watermark and original image
		$watermark_width = imagesx($watermark);
		$watermark_height = imagesy($watermark);
		$original_image_width = imagesx($original_image);
		$original_image_height = imagesy($original_image);

		//scaling factor is 266 h
		$scaling = (( $watermark_height / 266 ) * $original_image_height) / $watermark_height;

		$new_width = $watermark_width * $scaling;
		$new_height = $watermark_height * $scaling;

		$resized_watermark = imagecreatetruecolor($new_width, $new_height);
		//keep transparent aspects
		imagealphablending($resized_watermark, false);

		$success = imagecopyresampled($resized_watermark, $watermark, 0, 0, 0, 0, $new_width, $new_height, $watermark_width, $watermark_height);

		if($success){
			return $resized_watermark;
		} else {
			$wpipp_debug_message_string = $wpipp_debug_message_string . " " . "Could not resize watermark";
			return $watermark;
		}

	} else {
		return $watermark;
	}

}


/*
* place watermark on image
* watermark - the watermark to be used
* original_image - the image to place the watermark on
* position - the position of the watermark
* returns - the original_image with watermark applied in position
*/
function place_watermark_on_image($watermark, $original_image, $position){
	global $watermark_width, $watermark_height, $original_image_width, $original_image_height, $wpipp_watermark_transparency_string;
	
	//get the width and height of the watermark and original image
	$watermark_width = imagesx($watermark);
	$watermark_height = imagesy($watermark);
	$original_image_width = imagesx($original_image);
	$original_image_height = imagesy($original_image);
	

	if($position == "rp"){
		//Logic for  repeat x,y

		$y_pos = 0;			
		//repeat y start until > watermark height
		while($y_pos < $original_image_height){
			$x_pos = 0;
			//repeat x start until > watermark width
			while($x_pos < $original_image_width){
				if(function_exists('wpipp_copy_and_merge')){
					$original_image = wpipp_copy_and_merge($original_image, $watermark, $x_pos, $y_pos, $watermark_width, $watermark_height, $wpipp_watermark_transparency_string);
				} else {
					imagecopy($original_image, $watermark, $x_pos, $y_pos, 0, 0, $watermark_width, $watermark_height);
				}
				
				//next x position
				$x_pos = $x_pos + $watermark_width;
			}
			//next y position
			$y_pos = $y_pos + $watermark_height;
		}		
	}else{
		//logic for no repeat x, y
		$location_array = calculate_destination_coordinates($watermark, $original_image, $position);
		$x_pos = $location_array['dest_x'];
		$y_pos = $location_array['dest_y'];

		//use imagecopy if opacity = 100 (ie none), otherwise alpha is disregarded with imagecopymerge
		if(function_exists('wpipp_copy_and_merge')){
			$original_image = wpipp_copy_and_merge($original_image, $watermark, $x_pos, $y_pos, $watermark_width, $watermark_height, $wpipp_watermark_transparency_string);
		} else {
			imagecopy($original_image, $watermark, $x_pos, $y_pos, 0, 0, $watermark_width, $watermark_height);
		}
	}

	return $original_image;
}//end place_watermark_on_image

/*
* calculate destination coordinates
* returns destination coordinates in array('dest_x' => $dest_x, 'dest_y' => $dest_y);
*/
function calculate_destination_coordinates($watermark, $original_image, $position){
	global $original_image_width, $original_image_height, $watermark_width, $watermark_height;

	//@todo - check max proportions of watermark compared with orginal and resize if necessary - suggest 25% of image height			

	if($position == ""){
		//set position as bottom right if not set
		$position = "br";
	}

	//defaults
	$dest_x = 0;
	$dest_y = 0;
	

	if($position == "tl"){
		//top left

		// Set the destination positions of the watermark
		//x is 0
		$dest_x = 0;
		//y is 0
		$dest_y = 0;		
	} elseif($position == "tc"){
		//top centre

		// Set the destination positions of the watermark
		//x is (image width - watermark width)/2 
		$dest_x = ($original_image_width - $watermark_width)/2;
		//y is 0
		$dest_y = 0;
	} elseif($position == "tr"){
		//top right

		// Set the destination positions of the watermark
		//x is image width - watermark width
		$dest_x = $original_image_width - $watermark_width;
		//y is 0
		$dest_y = 0;
	} elseif($position == "cl"){
		//centre left

		// Set the destination positions of the watermark
		//x is 0
		$dest_x = 0;
		//y is (image height - watermark height)/2 
		$dest_y = ($original_image_height - $watermark_height)/2;
	} elseif($position == "cc"){
		//centre centre

		// Set the destination positions of the watermark
		//x is (image width - watermark width)/2 
		$dest_x = ($original_image_width - $watermark_width)/2;
		//y is (image height - watermark height)/2 
		$dest_y = ($original_image_height - $watermark_height)/2;
	} elseif($position == "cr"){
		//centre right

		// Set the destination positions of the watermark
		//x is image width - watermark width
		$dest_x = $original_image_width - $watermark_width;
		//y is (image height - watermark height)/2 
		$dest_y = ($original_image_height - $watermark_height)/2;
	} elseif($position == "bl"){
		//bottom right

		// Set the destination positions of the watermark
		//x is 0
		$dest_x = 0;
		//y is image height - watermark height
		$dest_y = $original_image_height - $watermark_height;
	} elseif($position == "bc"){
		//bottom centre

		// Set the destination positions of the watermark
		//x is (image width - watermark width)/2 
		$dest_x = ($original_image_width - $watermark_width)/2;
		//y is image height - watermark height
		$dest_y = $original_image_height - $watermark_height;
	} elseif($position == "br"){
		//bottom right

		// Set the destination positions of the watermark
		//x is img width- watermark width
		$dest_x = $original_image_width - $watermark_width;
		//y is image height - watermark height
		$dest_y = $original_image_height - $watermark_height;
	} 

	return array('dest_x' => $dest_x, 'dest_y' => $dest_y);

}//end calculate_destination_coordinates


/**
* converts a hex colour to an rgb representation
* returns (array) the RGB values for the parameter hex_colour supplied
*/
function get_rgb_from_hex($hex_colour) {
   $hex_colour = str_replace("#", "", $hex_colour);

   if(strlen($hex_colour) == 6) {
      $red = hexdec(substr($hex_colour,0,2));
      $green = hexdec(substr($hex_colour,2,2));
      $blue = hexdec(substr($hex_colour,4,2));      
   } else {
      //repeat the hex value for shortcode
      $red_hex = substr($hex_colour,0,1);
      $green_hex = substr($hex_colour,1,1);
      $blue_hex = substr($hex_colour,2,1);
      $red = hexdec($red_hex.$red_hex);
      $green = hexdec($green_hex.$green_hex);
      $blue = hexdec($blue_hex.$blue_hex);
   }
   $rgb = array('red' => $red, 'green' => $green, 'blue' => $blue);
   return $rgb; 
}


/**
* returns a post id for the image url supplied
* returns (int) post id for image url or 0 if not found
*/
function get_post_id_from_url($url_string){
	global $wpdb;
    $result = 0;
    //cast the url to the original url guid if it's a thumbnail, large etc.
	$url_string = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url_string );
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts where guid = %s AND post_type = 'attachment'", $url_string ) );
	foreach ( $results as $row ) {  
        $result = $row->ID ;  
    }  
	return $result;	

}


/*
* render original image
*/
function render_original_image(){
	global $original_image_path, $wpipp_render_option_string;

	//attempt to open the file, surpressing errors
	$file_passthrough = @fopen($original_image_path, 'rb');
	if($file_passthrough!=false){
		// Set the content-type
		header('Content-Type: image/jpeg');
		// process the image
		fpassthru($file_passthrough);
	} else {
		render_text("Cannot load original image");
	}
	exit;
}//end render_original_image



/*
* render text
* text - the text to render
*/
function render_text($text){
	global $wpipp_render_option_string;
	$text_image_display = imagecreate(600, 50);

	// White background and blue text
	$bg = imagecolorallocate($text_image_display, 255, 255, 255);
	$textcolor = imagecolorallocate($text_image_display, 0, 0, 255);

	// Write the string at the top left
	imagestring($text_image_display, 5, 0, 0, $text, $textcolor);

	// Set the content-type
	if($wpipp_render_option_string=="PNG"){
		header('Content-Type: image/png');	
		imagepng($text_image_display);
	} else {
		header('Content-Type: image/jpeg');	
		imagejpeg($text_image_display);
	}	
	imagedestroy($text_image_display);
	exit;
}//end render_text

/*
* render watermarked image
* watermarked_image - the watermarked image to be rendered
*/
function render_watermark_image($watermarked_image){
	global $wpipp_render_option_string, $original_image;

	// Using imagepng() results in clearer text compared with imagejpeg()
	// todo - we should be using this notation, but appears incompatible with PHP 5 - imagepng($original_image, NULL, $q);
	if($wpipp_render_option_string=="PNG"){
		header('Content-Type: image/png');	
		imagepng($original_image);
	} else {
		header('Content-Type: image/jpeg');	
		imagejpeg($original_image);
	}

}//end render_watermarked_image


/*
* hotlinking functions
*/
function lite_hotlinking_functions(){
	global $wpipp_hotlinking_option_string;
	//hotlinking prevention
	$wp_site_url = site_url("/");
	$is_hotlink_detected = wpipp_lite_is_hotlink($wp_site_url);
		
	if($is_hotlink_detected){
		//hotlinking action
		increment_hotlink_counter();

		//increment hotlink attempt counter
		if($wpipp_hotlinking_option_string=="true"){
			if(function_exists('render_hotlink')){
				render_hotlink();
				return;
			}
			
		}
		
	} else{
		//none hotlinking action
		//do nothing
	}
}//end hotlinking_functions

/**
* increments the hotlink counter
*/
function increment_hotlink_counter(){
	global $original_image_post_id;

	$hotlink_count = get_post_meta($original_image_post_id, HOTLINK_COUNT_META_KEY, true);
	if(!$hotlink_count || $hotlink_count==''){
		$hotlink_count = '0';
	}

	$hotlink_count = intval($hotlink_count) + 1;

	update_post_meta($original_image_post_id, HOTLINK_COUNT_META_KEY, $hotlink_count);

}

/**
* dummy method for plugging wp_is_post_revision and allowing update of post_meta
*/
function wp_is_post_revision(){
	return false;
}


/**
* returns referring site
*/
function wpipp_lite_get_referrer(){
  //not referrer is spelt incorrectly by php
  $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
  return $referrer;
}	


/**
* returns boolean for if resource is being hotlinked
* allow non-http referrs or those with no ref?
*/
function wpipp_lite_is_hotlink($sitename){
  $referrer = wpipp_lite_get_referrer();

  //needs to be triple equality as will return false if not found (otherwise will typecast)
  if(strpos($referrer, $sitename)===0){
      return false;
  } else {
      return true;
  }
}
	


/**
* debug functionality
*/
function debug_wpipp(){
	global $wpipp_visible_enabled, $wpipp_visible_enabled_string, $wpipp_minimum_image_size, $wpipp_minimum_image_size_string, $wpipp_watermark_text, $wpipp_watermark_text_string, $wpipp_watermark_text_font, $wpipp_watermark_text_font_string, $wpipp_watermark_text_size, $wpipp_watermark_text_size_string, $wpipp_watermark_text_colour, $wpipp_watermark_text_colour_string, $wpipp_watermark_text_border_width, $wpipp_watermark_text_border_width_string, $wpipp_watermark_text_background_colour, $wpipp_watermark_text_background_colour_string, $wpipp_watermark_image_url, $wpipp_watermark_image_url_string, $wpipp_watermark_position, $wpipp_watermark_position_string,  $wpipp_watermark_scale,  $wpipp_watermark_scale_string, $wpipp_watermark_transparency, $wpipp_watermark_transparency_string, $wpipp_caching_option, $wpipp_caching_option_string, $wpipp_hotlinking_option, $wpipp_hotlinking_option_string, $original_image_post_id, $original_image_path, $relative_path, $full_image_src,  $wpipp_debug_message_string, $wpipp_debug_option_string;

	
	$wpipp_debug = isset($_GET['wpipp_debug']) ? $_GET['wpipp_debug'] : "";

	if(isset($wpipp_debug_option_string) and $wpipp_debug_option_string=="true")
	{
		$wpipp_debug = "true";
	}
	



	if($wpipp_debug=="true"){
			echo "<h1>WP Image Protect Debug Values";
			echo "<h2>WordPress Options Values</h2>";
			echo "wpipp_visible_enabled_string" . "->" . $wpipp_visible_enabled_string;
			echo "<br/>";
			echo "wpipp_minimum_image_size_string" . "->" . $wpipp_minimum_image_size_string;
			echo "<br/>";
			echo "wpipp_watermark_text_string" . "->" . $wpipp_watermark_text_string;
			echo "<br/>";
			echo "wpipp_watermark_text_font_string" ."->" . $wpipp_watermark_text_font_string;
			echo "<br/>";
			echo "wpipp_watermark_text_size_string" . "->" . $wpipp_watermark_text_size_string;
			echo "<br/>";
			echo "wpipp_watermark_text_colour_string" . "->" . $wpipp_watermark_text_colour_string;
			echo "<br/>";
			echo "wpipp_watermark_text_border_width_string" . "->" . $wpipp_watermark_text_border_width_string;
			echo "<br/>";
			echo "wpipp_watermark_text_background_colour_string" . "->" . $wpipp_watermark_text_background_colour_string;
			echo "<br/>";
			echo "wpipp_watermark_image_url_string" ."->" . $wpipp_watermark_image_url_string;
			echo "<br/>";
			echo "wpipp_watermark_position_string" . "->" . $wpipp_watermark_position_string;
			echo "<br/>";
			echo "wpipp_watermark_scale_string" . "->" . $wpipp_watermark_scale_string;
			echo "<br/>";
			echo "wpipp_watermark_transparency_string" . "->" . $wpipp_watermark_transparency_string;
			echo "<br/>";
			echo "wpipp_caching_option_string" ."->" . $wpipp_caching_option_string;
			echo "<br/>";
			echo "wpipp_hotlinking_option_string" . "->" . $wpipp_hotlinking_option_string;
			echo "<br/>";
			echo "<h2>Image Properties</h2>";
			echo "original_image_path" . "->" . $original_image_path;
			echo "<br/>";
			echo "relative_path" . "->" . $relative_path;
			echo "<br/>";
			echo "full_image_src" . "->" . $full_image_src;
			echo "<br/>";
			echo "original_image_post_id" . "->" . $original_image_post_id;
			echo "<br/>";
			echo "exclude from watermark (evaluation)" . "->" .  get_post_meta($original_image_post_id, 'wpipp_exclude_from_watermark', true);
			echo "<br/>";
			echo "additional debug info" . "->" .   $wpipp_debug_message_string;
			exit(0);
	}




}



load_wp_variables();
set_font_variables();
load_original_image_properties();
debug_wpipp();
increment_image_view_counter();
if(function_exists('exclude_from_watermark_functions')){
	exclude_from_watermark_functions();
}
lite_hotlinking_functions();
if(function_exists('caching_functions')){
	caching_functions();
}
load_original_image();
if(function_exists('minimum_image_size_functions')){
	minimum_image_size_functions();
}
$watermark = NULL;
$watermark_type = $wpipp_visible_enabled_string;
if($watermark_type=="text"){
	$watermark = text_watermark();
} elseif($watermark_type=="image") {
	if(function_exists('image_watermark')){
		$watermark = image_watermark();
	} else {
		echo "error loading premium files";
	}	
} else {
	render_original_image();
}

if(!is_null($watermark)){

	$watermark = scale_watermark_to_image($watermark, $original_image);
	$watermarked_image = place_watermark_on_image($watermark, $original_image, $wpipp_watermark_position_string);

	render_watermark_image($watermarked_image);

	imagedestroy($watermark);
	imagedestroy($watermarked_image);			
}

imagedestroy($original_image);


?>