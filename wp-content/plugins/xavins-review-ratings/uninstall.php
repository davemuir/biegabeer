<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
	exit();
	
// deletes all options
delete_option('xrr_image_path'); // depreciated in 1.3, keep for old installs
delete_option('xrr_image_extension'); // depreciated in 1.3, keep for old installs
delete_option('xrr_single_template');
delete_option('xrr_group_template');
delete_option('xrr_group_frame_template');
delete_option('xrr_image_template');
delete_option('xrr_display_as');
delete_option('xrr_max_fraction');
delete_option('xrr_label');
delete_option('xrr_imageset');
delete_option('xrr_fraction_separator');
delete_option('xrr_always_show_decimal');
delete_option('xrr_version');
?>
