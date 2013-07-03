<?php
function xrr_options_main() {
	
	if ($_REQUEST['Submit']) {
		xrr_update_options();
	}
	
	if ($_REQUEST['Reset']) {
		xrr_set_default_options();
		?><div id="message" class="updated fade">
			<p>Options <strong>Reset to Defaults</strong>.</p>
		</div><?php		
	}
	
	?><div class="wrap"><h2>Xavin's Review Ratings</h2><?php
	xrr_print_form();
	
	?></div><?php
}

function xrr_update_options() {
	update_option('xrr_single_template', stripslashes($_REQUEST['xrr_single_template']));
	update_option('xrr_group_template', stripslashes($_REQUEST['xrr_group_template']));
	update_option('xrr_group_frame_template', stripslashes($_REQUEST['xrr_group_frame_template']));
	update_option('xrr_image_template', stripslashes($_REQUEST['xrr_image_template']));
	update_option('xrr_max_stars', $_REQUEST['xrr_max_stars']);
	update_option('xrr_display_as', $_REQUEST['xrr_display_as']);
	update_option('xrr_max_fraction', $_REQUEST['xrr_max_fraction']);
	update_option('xrr_label', $_REQUEST['xrr_label']);
	update_option('xrr_imageset', $_REQUEST['xrr_imageset']);
	update_option('xrr_fraction_separator', $_REQUEST['xrr_fraction_separator']);
	update_option('xrr_always_show_decimal', $_REQUEST['xrr_always_show_decimal']);
	
	?><div id="message" class="updated fade">
		<p>Options <strong>Saved</strong>.</p>
	</div><?php
}

function xrr_get_directory_list($path) {
	
	$results = array();
	if (file_exists($path)) {
		$handle = opendir($path);
		
		// run through directory contents
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..' && is_dir($path. "/" . $file) ) {
				// check to see if there is actually an image here
				$ext = xrr_get_imageset_extension($path. "/" . $file);
				if ($ext != '') {
					$results[] = $file;
				}
			}
		}
		closedir($handle);
	}
	
	return $results;
}

function xrr_get_admin_img($url, $file, $ext) {
	return '<img src="'.$url.'/'.$file.$ext.'" />';
}

function xrr_print_form() {
?>
	<form method="post">
		
		<h3>Global Settings</h3>
		<p>These settings are for all [xrr] tags.</p>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="xrr_single_template">Normal Item Template:</label></th>
					<td>
						<input type="text" name="xrr_single_template" size="100" value="<?php echo htmlspecialchars(get_option('xrr_single_template'));?>" /><br />
						This is the template for the standalone [xrr] tag. Valid variables are:<br />
						<ul><li>*label* - Outputs the label.</li><li>*rating* - Outputs the rating.</li></ul>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="xrr_group_frame_template">Group Surround Template:</label></th>
					<td>
						<input type="text" name="xrr_group_frame_template" size="100" value="<?php echo htmlspecialchars(get_option('xrr_group_frame_template'));?>" /><br />
						This is the template for the [xrrgroup] tag. Valid variables are:<br />
						<ul><li>*ratings* - All the surrounded ratings</li></ul>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row"><label for="xrr_group_template">Group Item Template:</label></th>
					<td>
						<input type="text" name="xrr_group_template" size="100" value="<?php echo htmlspecialchars(get_option('xrr_group_template'));?>" /><br />
						This is the template for the [xrr] tags surrounded by [xrrgroup]. Valid variables are:<br />
						<ul><li>*label* - Outputs the label.</li><li>*rating* - Outputs the rating.</li></ul>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="xrr_image_template">Star Image Template:</label></th>
					<td>
						<input type="text" name="xrr_image_template" size="100" value="<?php echo htmlspecialchars(get_option('xrr_image_template'));?>" /><br />
						This is the template for the &lt;img&gt; tags for each star. Valid variables are:<br />
						<ul><li>*imageurl* - The full url for the correct star.</li>
						<li>*textstars* - Outputs the text representation of the star.</li>
						<li>*percentage* - Outputs the percentage of the rating.</li>
						<li>*fraction* - Outputs the fraction of the rating.</li></ul>
					</td>
				</tr>		

			</tbody>
		</table>
		
		<h3>Defaults</h3>
		<p>These settings can be overriden in each individual tag.</p>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="xrr_max_stars"><?php _e('Max Stars:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<input type="text" name="xrr_max_stars" size="2" value="<?php echo get_option('xrr_max_stars');?>" /> Display your rating as ? out of Max Stars.
					</td>
				</tr>			
				<tr valign="top">
					<th scope="row"><label for="xrr_label"><?php _e('Label:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<input type="text" name="xrr_label" size="20" value="<?php echo get_option('xrr_label');?>" />	
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="xrr_imageset"><?php _e('Image Set:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<input type="text" name="xrr_imageset" size="20" value="<?php echo get_option('xrr_imageset');?>" />
						<br />The name of the directory, either in the plugin directory for imagesets distributed with the plugin, 
						or in the wp-content/uploads/xavins-review-ratings/ directory for user created imagesets.
						<br /><br />
						Detected Imagesets:
						<ul>
						<?php 
							$builtin_dirs = xrr_get_directory_list( WP_PLUGIN_DIR.'/xavins-review-ratings/' );
							$path = WP_PLUGIN_DIR.'/xavins-review-ratings/';
							$url = WP_PLUGIN_URL.'/xavins-review-ratings/';

							foreach($builtin_dirs as $value) {
								$ext = xrr_get_imageset_extension($path.'/'.$value);
								print '<li>'.$value.' - ';
								print xrr_get_admin_img($url.$value, 'star', $ext);
								print xrr_get_admin_img($url.$value, 'threequarter_star', $ext);
								print xrr_get_admin_img($url.$value, 'half_star', $ext);
								print xrr_get_admin_img($url.$value, 'quarter_star', $ext);
								print xrr_get_admin_img($url.$value, 'blank_star', $ext);
								print '</li>';
							}						

							
							$wud = wp_upload_dir();							
							$user_dirs = xrr_get_directory_list( $wud['basedir'].'/xavins-review-ratings/' );
							$path = $wud['basedir'].'/xavins-review-ratings/';
							$url = $wud['baseurl'].'/xavins-review-ratings/';
						
							foreach($user_dirs as $value) {
								$ext = xrr_get_imageset_extension($path.'/'.$value);
								print '<li>'.$value.' - ';
								print xrr_get_admin_img($url.$value, 'star', $ext);
								print xrr_get_admin_img($url.$value, 'threequarter_star', $ext);
								print xrr_get_admin_img($url.$value, 'half_star', $ext);
								print xrr_get_admin_img($url.$value, 'quarter_star', $ext);
								print xrr_get_admin_img($url.$value, 'blank_star', $ext);
								print '</li>';

							}						
						?>
						</ul>
					</td>
				</tr>				
				<tr valign="top">
					<th scope="row"><label for="xrr_display_as"><?php _e('Display As:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<select name="xrr_display_as">
							<option value="stars"<?php selected('stars', get_option('xrr_display_as')); ?>><?php _e('Image Stars', 'xavins-review-ratings'); ?></option>
							<option value="textstars"<?php selected('textstars', get_option('xrr_display_as')); ?>><?php _e('Text Stars', 'xavins-review-ratings'); ?></option>
							<option value="percentage"<?php selected('percentage', get_option('xrr_display_as')); ?>><?php _e('Percentage', 'xavins-review-ratings'); ?></option>
							<option value="fraction"<?php selected('fraction', get_option('xrr_display_as')); ?>><?php _e('Fraction', 'xavins-review-ratings'); ?></option>
							<option value="fraction_stars"<?php selected('fraction_stars', get_option('xrr_display_as')); ?>><?php _e('Fraction and Image Stars', 'xavins-review-ratings'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="xrr_fraction_separator"><?php _e('Fraction Separator:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<input type="text" name="xrr_fraction_separator" size="5" value="<?php echo get_option('xrr_fraction_separator');?>" />	 e.g. 3<?php echo get_option('xrr_fraction_separator');?>5 
					</td>
				</tr>					
				<tr valign="top">
					<th scope="row"><label for="xrr_max_fraction"><?php _e('Max Fraction:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<select name="xrr_max_fraction">
							<option value="4"<?php selected('4', get_option('xrr_max_fraction')); ?>><?php _e('Quarter Stars', 'xavins-review-ratings'); ?></option>
							<option value="2"<?php selected('2', get_option('xrr_max_fraction')); ?>><?php _e('Half Stars', 'xavins-review-ratings'); ?></option>
							<option value="1"<?php selected('1', get_option('xrr_max_fraction')); ?>><?php _e('Full Stars', 'xavins-review-ratings'); ?></option>
						</select>
						The limit for how much you want to break down each star.
					</td>
				</tr>
					<tr valign="top">
					<th scope="row"><label for="xrr_always_show_decimal"><?php _e('Always Show Decimal:', 'xavins-review-ratings'); ?></label></th>
					<td>
						<select name="xrr_always_show_decimal">
							<option value="true"<?php selected('true', get_option('xrr_always_show_decimal')); ?>><?php _e('True', 'xavins-review-ratings'); ?></option>
							<option value="false"<?php selected('false', get_option('xrr_always_show_decimal')); ?>><?php _e('False', 'xavins-review-ratings'); ?></option>
						</select>
						If this is set to true, whole numbers will always show with a decimal, like '5.0'.
					</td>
				</tr>	
			</tbody>
		</table>
		<p class="submit">
			<?php wp_nonce_field('xavins-review-ratings'); ?>
			<input type="submit" name="Submit" class="button" value="<?php _e('Save Changes', 'xavins-review-ratings'); ?>" />
			<input type="submit" name="Reset" class="button" value="<?php _e('Reset to Defaults', 'xavins-review-ratings'); ?>" />
		</p>		
		
	</form>
	
	

<?php
}
?>