<?php
/*
Plugin Name: WP Image Protect Lite
Plugin URI: http://8mediacentral.com/developments/wp-image-protect/
Description: Watermark your images dynamically without modifying the original content.
Author: 8MediaCentral
Version: 2.5
Author URI: http://8MediaCentral.com
*/

/**
 * Description of Watermark WP Image Protect:
 * Prevent, detect and eliminate image misuse by Watermarking images.
 * WP Image Protect utilizes on-the-fly watermark application so original files are unaffected
 * Watermarks can be altered or removed at any time
 *
 * @author 8MediaCentral
 */

//definitions
define( 'WPIPP_VERSION', '2.5' );
define( 'WPIPP_MODE', 'lite' );
define( 'WPIPP_TEXTDOMAIN', 'wpipp' );
define( 'WPIPP_HOMEPAGE_URL', 'http://8mediacentral.com/developments/wp-image-protect-watermark-wordpress-images-plugin/' );
define( 'WPIPP_DIRECTORY_URL', 'http://wordpress.org/extend/plugins/wp-image-protect/' );
define( 'WPIPP_DIRECTORY_SUPPORT', 'http://wordpress.org/support/plugin/wp-image-protect' );
define( 'WPIPP_DOCUMENTATION_URL', 'http://8mediacentral.com/developments/wp-image-protect-watermark-wordpress-images-plugin/documentation/' );

define('VIEW_COUNT_META_KEY', '_wpipp_view_count');
define('HOTLINK_COUNT_META_KEY', '_wpipp_hotlink_count');




//class definition
if(!class_exists("wp_image_protect")){

    class wp_image_protect{

        private $remove_rules = false;

        //constructor
        function wp_image_protect(){                
                
        }


        /**
        * WPIPP Flush Rules, flush the rewrite rules for mod rewrite
        */
        function wpipp_flush_rules()
        {
            global $wp_rewrite;
            $wp_rewrite->flush_rules();
        }


        /**
        * WP Add Rules, add mod rewrite rules
        */
        function wpipp_add_rules()
        {
            //only add rules if the plugin is not being deactivated
            if(!$this->remove_rules){
                global $wp_rewrite;
            
                //consider moving this to a plugin option and regenerate rewrite rules
                $uploads_path = "wp-content/uploads/";

                //write the new .htaccess rules to redirect image serving to the image serving proxy
                $non_wp_rules = array('(.*)'.$uploads_path.'((.*)\.(jpe?g|gif|png))$' => '$1'.$this->get_proxy_location().'?p=br&q=90&src='.$uploads_path.'$2');
                if(class_exists('wpipp_settings')){
                    $wpipp_settings_load = new wpipp_settings();
                    $non_wp_rules = $wpipp_settings_load->get_custom_rewrite_rules();
                }
                if(isset($non_wp_rules)){
                    foreach($non_wp_rules as $array_value){
                        if($array_value != NULL){
                            $wp_rewrite->non_wp_rules  = $array_value + $wp_rewrite->non_wp_rules;
                        }                        
                    }
                }
            }
            
        }

        /**
        * Load the text domain for WPIPP
        */
         function wpipp_load_textdomain(){
            load_plugin_textdomain( 'wpipp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        }

        /**
        * WP Remove Rules, remove rewrite rules
        */
        function wpipp_remove_rules(){          
            
            $this->remove_rules = true;
            remove_action( 'generate_rewrite_rules', 'wpipp_add_rules' );
            $this->wpipp_flush_rules();
        }

        /**
        * over-ride WordPresses hard-coded rule rewrite for no-action rewrites
        */
        function mod_rewrite_rules($rules) {
            $rules = preg_replace('(/-)', '-', $rules);
            return $rules;
        }


        /**
        * cleanly remove cache
        */
        function wpipp_remove_watermark_cache(){
            //attempt to load cache manager (not used for lite)
            @include_once('php/wpipp-cache-manager.php'); 
            if(class_exists('wpipp_cache_manager')){
                $cache_manager = new wpipp_cache_manager();
                if(!is_null($cache_manager)){
                    $cache_manager->clear_cache_remove();
                }
            }          
        }

        /**
        * Add a custom form field filter for attachments to have them excluded from WPIPP watermarking
        */
        function wpipp_add_exclude_watermark_field ($form_fields, $post){
            $wpipp_exclude_from_watermark = (bool) get_post_meta($post->ID, 'wpipp_exclude_from_watermark', true);

            $form_fields['wpipp_exclude_from_watermark'] = array(
            'label' => __('WPIPP Exclude from Watermarking', 'wpipp'),
            'input' => 'html',
            'html' => '<label for="attachments-'.$post->ID.'-wpipp_exclude_from_watermark"> '.
                '<input type="checkbox" id="attachments-'.$post->ID.'-wpipp_exclude_from_watermark" name="attachments['.$post->ID.'][wpipp_exclude_from_watermark]" value="1"'.($wpipp_exclude_from_watermark ? ' checked="checked"' : '').' /> Yes</label>  ',
            'value' => $wpipp_exclude_from_watermark,
            'helps' => __('Check for yes', 'wpipp'),
            );
            return $form_fields;      
        }

        /**
        * Save the exclude watermark field
        */
        function wpipp_add_exclude_watermark_field_save( $post, $attachment ) {
            if( isset( $attachment['wpipp_exclude_from_watermark'] ) ) {
                update_post_meta( $post['ID'], 'wpipp_exclude_from_watermark', $attachment['wpipp_exclude_from_watermark'] );
            } else {
                update_post_meta( $post['ID'], 'wpipp_exclude_from_watermark', false );
            }
                
            return $post;
        }

        /**
        * Add custom field to media library view filter to display the exclude, view count, and hotlink status
        */
        function wpipp_custom_media_column_headings( $defaults ) {
           $defaults['wpipp_watermark_exclude']     = __('Ex. from Watermarking', 'wpipp');  
           $defaults['wpipp_watermark_view_count']     = __('View Count', 'wpipp');  
           $defaults['wpipp_watermark_hotlink_count']     = __('Hotlink Attempts', 'wpipp');  
           return $defaults;
        }

        /**
        * Display data for custom field to media library view filter
        */
        function wpipp_custom_media_column_content( $column_name, $id ) {
            //@todo add checkbox styles
           //$yes = '<span style="background-color:yellow; color:black;">Yes</span>';
           switch ( $column_name ) {
              case 'wpipp_watermark_exclude':
                 $wpipp_exclude_from_watermark = (bool) get_post_meta($id, 'wpipp_exclude_from_watermark', true);
                 echo $wpipp_exclude_from_watermark ? "yes" : "no";
                 break;
            case 'wpipp_watermark_view_count':
                 $wpipp_view_count = get_post_meta($id, VIEW_COUNT_META_KEY, true);
                 echo $wpipp_view_count && $wpipp_view_count != '' ? $wpipp_view_count : '0';
                 break;
            case 'wpipp_watermark_hotlink_count':
                 $wpipp_hotlink_count = get_post_meta($id, HOTLINK_COUNT_META_KEY, true);
                 echo $wpipp_hotlink_count && $wpipp_hotlink_count != '' ? $wpipp_hotlink_count : '0';
                 break;
           }
        }

        /**
        * Add and enque the styles
        */        
        function wpipp_add_styles(){
            wp_register_style( 'wpipp-plugin-styles', plugins_url('css/wpipp-plugin-styles.css', __FILE__) );
            wp_enqueue_style( 'wpipp-plugin-styles' );
        }

        /**
        * Get Proxy Location
        * Returns - (String) Proxy Location
        */
        function get_proxy_location(){
            $proxy_loc = "not set";            
            //get the site url
            $site_url = site_url('/');
            //get plugin url
            $plugin_url = plugins_url();
            //get plugin name
            $plugin_name = plugin_basename(__FILE__);
            //the plugin path without site name
            $plugins_trunc = substr($plugin_url, strlen($site_url));            
            //the name of the wpipp directory
            $wpipp_dir = substr($plugin_name, 0, strpos($plugin_name, "/"));
            //set the proxy location
            $proxy_loc = $plugins_trunc."/".$wpipp_dir."/php/"."wpipp-image-manager.php";
            //return the proxy location
            return $proxy_loc;
        }

        /**
        * Run an installation check to ensure that the WordPress and GD Library are compatible
        * Returns - (Boolean) 
        */
        function wpipp_install_check(){
            @include_once('php/wpipp-install-check-class.php'); 

            //test if the user has specified the option to install anyway
            if(function_exists('get_option')){
                $install_anyway = get_option('wpipp_continue_install');
                if($install_anyway == 'true'){
                    return true;
                }    
            }
            $continue_wpipp_install = isset($_GET['continue-wpipp-install']) ? $_GET['continue-wpipp-install'] : false ;
            if ( isset( $continue_wpipp_install ) && $continue_wpipp_install == 'true') {
                    //update the wordpress option
                    if(function_exists('update_option') && function_exists('add_action')){
                        update_option('wpipp_continue_install', 'true');  
                        add_action('admin_init', array( $this, 'wpipp_flush_rules'));                        
                    }    
                    return true;           
            }   
            
            try{
                if(class_exists('wpipp_install_check')){
                $wpipp_install_check_init = new wpipp_install_check();
                if($wpipp_install_check_init->is_wp_compatible() and $wpipp_install_check_init->is_gd_compatible()){
                    //the installation will be compatible
                    return true;
                } else {
                    //let the user know the installation will not be compatible
                    if(function_exists('add_action')){
                        add_action('admin_notices', array( &$wpipp_install_check_init, 'wpipp_install_check_admin_message'));
                        return false;
                    }                    
                }
            }
            } catch (Exception $e) {
                //surpress errors, these can be caused if the plugin is already installed, but re-install may be required so continue
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            return true;            
        }

        /**
        * Add the settings shortcut to plugin page
        */
        function wpipp_plugin_settings_link($links, $file) { 
            $plugin_name = plugin_basename(__FILE__); 
            if($file == $plugin_name){
                $settings_url = '<a href="options-general.php?page=wpipp_display">' . __("Settings", 'wpipp') . '</a>'; 
                //add link
                array_unshift($links, $settings_url);                
            }
            return $links; 
        }  
        

    }//end class definition wp_image_protect
} 


/*
* dummy class for v2 plugin notification 
*/
//class definition
if(!class_exists('wp_image_protect_v2')){
    class wp_image_protect_v2{
    }
}








//run the plugin
if (class_exists("wp_image_protect")) {
    $wp_image_protect_init = new wp_image_protect();  
    
    

    if($wp_image_protect_init->wpipp_install_check()==true){

        //load the settings file
        @require_once('php/wpipp-settings.php');
        //load the admin messages file (not used for lite)
        @include_once('php/wpipp-messaging.php');
        //load the contact-form-7 fix file
        @include_once('php/wpipp-contact-form-7-fix.php');
        //load the wordpress-seo fix file
        @include_once('php/wpipp-wordpress-seo-fix.php');
        //load the woocommerce fix file
        @include_once('php/wpipp-woocommerce-fix.php');

        /* ADD WPIPP ACTIVATION HOOKS */
        register_activation_hook(__FILE__, array( &$wp_image_protect_init, 'wpipp_flush_rules'));
        //add the options using the WPIPP settings class
        register_activation_hook( __FILE__,  array( 'wpipp_settings', 'wpipp_add_options'));

        //add the activation hook for contact-form-7-fix
        if(function_exists('wpipp_cf_7_fix')){
            register_activation_hook ( __FILE__, 'wpipp_cf_7_fix');
        }
        //add the activation hook for wordpress-seo-fix
        if(function_exists('wpipp_wp_seo_fix')){
            register_activation_hook ( __FILE__, 'wpipp_wp_seo_fix');
            register_activation_hook ( __FILE__, 'wpipp_wp_seo_fix2');
        }
        //add the activation hook for wordpress-seo-fix
        if(function_exists('wpipp_woocommerce_fix')){
            register_activation_hook ( __FILE__, 'wpipp_woocommerce_fix');
        }


        /* ADD WPIPP DEACTIVATION HOOKS */
        register_deactivation_hook( __FILE__, array( &$wp_image_protect_init, 'wpipp_remove_rules' ));
        register_deactivation_hook( __FILE__,  array( &$wp_image_protect_init, 'wpipp_remove_watermark_cache' ));
        //delete the options using the WPIPP settings class
        register_deactivation_hook( __FILE__,  array( 'wpipp_settings', 'wpipp_remove_options'));
        

        /* ADD WPIPP ACTIONS */            
        add_action( 'generate_rewrite_rules', array( &$wp_image_protect_init, 'wpipp_add_rules'));
        add_action( 'init',  array( &$wp_image_protect_init, 'wpipp_load_textdomain'));
        add_action( 'manage_media_custom_column', array( &$wp_image_protect_init, 'wpipp_custom_media_column_content'), 10, 2 );
        add_action( 'admin_init',   array( &$wp_image_protect_init, 'wpipp_add_styles'));                        

        /* ADD WPIPP CUSTOM FILTERS */
        add_filter( 'attachment_fields_to_edit', array( &$wp_image_protect_init, 'wpipp_add_exclude_watermark_field'), 10, 2 );
        add_filter( 'attachment_fields_to_save', array( &$wp_image_protect_init, 'wpipp_add_exclude_watermark_field_save'), 10, 2 );
        add_filter( 'manage_media_columns', array( &$wp_image_protect_init, 'wpipp_custom_media_column_headings'), 10, 1 );
        add_filter( 'plugin_action_links', array( &$wp_image_protect_init, 'wpipp_plugin_settings_link'), 10, 2 );
        add_filter('mod_rewrite_rules', array( &$wp_image_protect_init, 'mod_rewrite_rules'));
        

    }



    if( class_exists('wpipp_messaging')){

        $wpipp_messaging_init = new wpipp_messaging();

        /* WPIPP MESSAGING DEACTIVATION HOOKS */
        register_deactivation_hook( __FILE__,  array( $wpipp_messaging_init, 'remove_message_acknowledgements'));  

        /* WPIPP MESSAGING ACTIONS */
        add_action( 'admin_notices', array( $wpipp_messaging_init, 'display_html_messages'));
        add_action( 'admin_init',   array( $wpipp_messaging_init, 'dismiss_wp_html_admin_messages'));

    }

    
}


?>