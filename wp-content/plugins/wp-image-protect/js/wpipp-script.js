/**
*   Copyright 2012 8MediaCentral, All Rights Reserved
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

jQuery(document).ready(function($) {  

	//set the initial visible fields
	visible_enabled_change($('#wpippDisplay_visible_enabled').attr('value'));

	hide_wpipp_advanced_settings_rows();

	add_show_wpipp_settings_link();



});


function visible_enabled_change($element){
	//console.log($element);
	if($element=="none"){
		hide_wpipp_text_rows();
		hide_wpipp_image_rows();
		hide_wpipp_basic_rows();
	}

	if($element=="text"){
		hide_wpipp_image_rows();
		show_wpipp_text_rows();
		show_wpipp_basic_rows();
	}

	if($element=="image"){
		hide_wpipp_text_rows();
		show_wpipp_image_rows();
		show_wpipp_basic_rows();
	}
}

function hide_wpipp_text_rows(){
	jQuery('.wpipp_text').parent('td').parent('tr').hide();
}

function show_wpipp_text_rows(){
	jQuery('.wpipp_text').parent('td').parent('tr').show();
}

function hide_wpipp_image_rows(){
	jQuery('.wpipp_image').parent('td').parent('tr').hide();
}

function show_wpipp_image_rows(){
	jQuery('.wpipp_image').parent('td').parent('tr').show();
}

function hide_wpipp_basic_rows(){
	jQuery('.wpipp_basic').parent('td').parent('tr').hide();
}

function show_wpipp_basic_rows(){
	jQuery('.wpipp_basic').parent('td').parent('tr').show();
}

function hide_wpipp_advanced_settings_rows(){
	jQuery('.wpipp_advanced_options').parent('td').parent('tr').hide();
	add_show_wpipp_settings_link();
}

function show_wpipp_advanced_settings_rows(){
	if(confirm('Are you sure you wish to show these settings?')){
		jQuery('.wpipp_advanced_options').parent('td').parent('tr').show();
		add_hide_wpipp_settings_link();
	}
	
}

function add_show_wpipp_settings_link(){
	jQuery('#show_advanced_wpipp_settings_container').html("(<a href = '#' title = 'show advanced settings' onclick = 'show_wpipp_advanced_settings_rows(); return false;'>Currently Hidden - Click to show settings</a>)");	
}

function add_hide_wpipp_settings_link(){
	jQuery('#show_advanced_wpipp_settings_container').html("(<a href = '#' title = 'show advanced settings' onclick = 'hide_wpipp_advanced_settings_rows(); return false;'>Click to hide settings</a>)");	
}

function font_change($element){
	$ele_name = jQuery('#'+$element+" option:selected").text();
	$new_licence_url = jQuery('#'+$ele_name).attr('licence_url');
	jQuery('#licence_url').attr('href', $new_licence_url);
}