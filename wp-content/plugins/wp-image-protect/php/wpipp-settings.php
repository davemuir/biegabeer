<?php
/*
* WP Image Protect - Settings File
* Settings API helper class
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*  
*/



class wpipp_settings {


    private $font_list;


     //constructor
    function wpipp_settings() {
        global $wpipp_settings;

        //attempt to load premium file (not used for lite)
        @include_once('wpipp-settings-premium.php');
        
        //initiliaze variables
        $wpipp_settings  = $this->plugin_initialize_options_array();  

        //add actions
        if (function_exists('add_action')) {
          add_action('admin_init', array( &$this, 'plugin_admin_init'));
          add_action('admin_menu', array( &$this, 'plugin_admin_add_page'));
        }

        if(function_exists('get_option')){
          $wpipp_watermarks_not_set_ignore = get_option('wpipp_watermarks_not_set_ignore');
          $wpipp_current_setting = get_option('wpippDisplay_visible_enabled');
        }


        //test that watermarks are being applied, if not alert the user
        if((isset($wpipp_current_setting) and $wpipp_current_setting['text_string'] != "none") or (isset($wpipp_watermarks_not_set_ignore) and $wpipp_watermarks_not_set_ignore == true )){
          //ok, do nothing
        } else {
          if (function_exists('add_action')) {
            //else display a warning that watermarks are not set
            add_action('admin_footer', array( &$this, 'wpipp_watermarks_not_set_warning'));
          }
        }

        //test permalinks are not default - alert the user if they are
        if((isset($wpipp_current_setting) and $wpipp_current_setting['text_string'] != "none")){
          if (function_exists('add_action') && function_exists('get_option')) {
            //alert the user if permalinks are not set as this will cause issues
            if(get_option('permalink_structure') == false or get_option('permalink_structure') == ""){
              add_action('admin_footer', array( &$this, 'wpipp_permalinks_not_set_warning'));  
            }
            
          }
        } else {         

        }

        
        
          
    }

    /**
    * this function displays a warning on admin pages if the watermarks are not set
    */
    function wpipp_watermarks_not_set_warning(){
          global $page_name, $wpipp_watermarks_not_set_warning_called;
          if(isset($wpipp_watermarks_not_set_warning_called))
            return;
          if(function_exists('get_current_screen')){
            $screen = get_current_screen();
          }
          if(isset($_GET['ignore-wpipp-watermarks-not-set-warning'])){
            $this->ignore_wpipp_watermarks_not_set_warning();
          } elseif (isset($page_name) and $page_name == $screen->id){
            //echo "<div id='message' class='error'>";
            //echo "<p><b>Watermarking not enabled</b> - configure your Watermark Settings on this page</p>";
            //echo "</div>";
          } else {
            echo "<div id='message' class='error'>";
            echo "<p><strong>" . __( "You've actived WP Image Protect but not configured it - No watermarks will be displayed yet. ", 'wpipp' ) . "</strong> " ;
            printf( __( "You must %sgoto to the settings page%s to configure site watermarks", 'wpipp' ), "<a href='".admin_url('options-general.php?page=wpipp_display')."'>", "</a>" ) ;
            echo " <a href='".admin_url('options-general.php?page=wpipp_display')."' class='button'>" . __( "Settings", 'wpipp' ) . "</a>";
            echo " <a href='?ignore-wpipp-watermarks-not-set-warning=true' class='button'>" . __( "Dismiss this Message", 'wpipp' ) . "</a>";
            echo "</p>";
            echo "</div>";
          }
          //stop the dialog being displayed twice
          $wpipp_watermarks_not_set_warning_called = true;          
    
    }

    /**
    * this function sets the ignore not set warning 
    */
    function ignore_wpipp_watermarks_not_set_warning() {
        $ignore_wpipp_watermarks_not_set = $_GET['ignore-wpipp-watermarks-not-set-warning'];
        if ( isset( $ignore_wpipp_watermarks_not_set ) && $ignore_wpipp_watermarks_not_set == 'true') {
                //update the wordpress option
            if(function_exists('update_option')){
              update_option('wpipp_watermarks_not_set_ignore', 'true');
            }               
        }             
    }


    /**
    * this function displays a warning on the wpipp-settings page if Permalinks are not set
    */
    function wpipp_permalinks_not_set_warning(){
          global $page_name, $wpipp_permalinks_not_set_warning_called;
          if(isset($wpipp_permalinks_not_set_warning_called))
            return;
          if(function_exists('get_current_screen')){
            $screen = get_current_screen();
          }
          if (isset($page_name) and $page_name == $screen->id){
            echo "<div id='message' class='error'>";
            echo "<p><strong>" . __( "Permalinks have not been set or are set to default (watermarks will not be displayed)", 'wpipp' ) . "</strong> " ;
            echo "<br/>";
            printf( __( "You must %sgoto to the permalink settings page%s to configure permalinks", 'wpipp' ), "<a href='".admin_url('options-permalink.php')."'>", "</a>" ) ;
            echo " <a href='".admin_url('options-permalink.php')."' class='button'>" . __( "Permalink Settings", 'wpipp' ) . "</a>";
            echo "</p>";
            echo "</div>";
          } else {

            if($screen->base == 'options-permalink'){
              echo "<div id='message' class='updated fade'>";
              echo "<p><strong>" . __( "WP Image Protect - Set a Permalink Option other than Default on this page to enable watermarks", 'wpipp' ) . "</strong> " ;
              echo "</p>";
              echo "</div>";

            }

            
          }
          //stop the dialog being displayed twice
          $wpipp_permalinks_not_set_warning_called = true;
          
    
    }

    

     /**
     * enqueue the stylesheets
     */ 
    function wpipp_options_enqueue_scripts() {  
        wp_register_script( 'wpipp-script', plugins_url( '/js/wpipp-script.js' , dirname(__FILE__) ) , array('jquery','media-upload','thickbox') );  
        if(class_exists('wpipp_settings_premium')){
          wpipp_options_register_premium_scripts(); 
        }
        wp_enqueue_script('jquery');  
        wp_enqueue_script('thickbox');  
        wp_enqueue_style('thickbox');  
        wp_enqueue_script('media-upload');  
        wp_enqueue_script('wpipp-script');  
        if(class_exists('wpipp_settings_premium')){
          wp_enqueue_script('wpipp-script-premium');
        }
        wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');
          
    } 


     /**
     * return the settings
     */ 
    function plugin_initialize_options_array(){

          @include_once('wpipp-font-manager.php');
          //atempt to load font manager (premium plugin) else assign defaults
          if(class_exists('wpipp_font_manager')){
            $font_manager = new wpipp_font_manager();
            $this->font_list = $font_manager->get_font_list_array();
          } else {
            $this->font_list = array (
              '/Carrois_Gothic/CarroisGothic-Regular.ttf' => array ('path' => '/Carrois_Gothic/CarroisGothic-Regular.ttf', 'font_name' => 'CarroisGothic-Regular', 'licence_file' => plugins_url('/fonts/Carrois_Gothic/OFL.txt', dirname(__FILE__)) ),
              '/Erica_One/EricaOne-Regular.ttf' => array ('path' => '/Erica_One/EricaOne-Regular.ttf', 'font_name' => 'EricaOne-Regular', 'licence_file' => plugins_url('/fonts/Erica_One/OFL.txt', dirname(__FILE__)) ),
              '/Kite_One/KiteOne-Regular.ttf' => array ('path' => '/Kite_One/KiteOne-Regular.ttf', 'font_name' => 'KiteOne-Regular', 'licence_file' => plugins_url('/fonts/Kite_One/OFL.txt', dirname(__FILE__)) ),
              );
          }
          
          
          //if premium load premium values
          if(!function_exists('wpipp_premium_headings')){
            $group = __( "wpippDisplay", 'wpipp'); // define group
            $page_name = __( "wpipp_display", 'wpipp'); // eg media/discussion/reading or custom   
            $title = __( "WP Image Protect Lite Settings", 'wpipp');  // admin page title 
            $intro_text = __( "This page allows you to configure image watermarking and other settings for WP Image Protect Lite.", 'wpipp'); // text displayed below title
            $nav_title = __( "WP Image Protect Settings", 'wpipp'); // name of page in context menu
          } else {
            $headings = wpipp_premium_headings();
            $group = $headings['group'];
            $page_name = $headings['page_name'];
            $title = $headings['title'];
            $intro_text = $headings['intro_text'];
            $nav_title = $headings['nav_title'];

          }
           
          /*  SECTIONS ARRAY
             * title: the title of the section
             * description: description of the section
             * fields: a array of field items key => array of options
              FIELD ARRAY OPTIONS
              * label: field label.
              * description: the field description displayed adjacent to the field. 
              * suffix: eg px, em, diplayed in italics adjacent to the field
              * default_value: default value of field when empty
              * dropdown: a drop down function, specify the drop down parameter name 
              * function: optional function to render field
              * onchange: option javascript call on dropdown change (currently only for dropdown items)
              * callback: optional function to validate field
              * field_class: the class to be assigned to the field
          */

           
          //if premium load premium values
          $sections = array(
             'wpipp_visible_watermark_settings' => array(
              'title' => '<i class="icon-eye-open icon-2x"></i> ' . '<span>' . __("Visible Watermark Settings", 'wpipp') . '</span>',
              'description' => __( "This section controls how visible watermarks appear on your content", 'wpipp'),
              'fields' => $this->wpipp_visible_options() + $this->wpipp_image_options() + $this->wpipp_text_options() + $this->wpipp_position_options() + $this->wpipp_transparency_options() ),

             'wpipp_live_preview' => array(
                    'title' => '<i class="icon-ok icon-2x"></i> ' . '<span>' . 'Preview'  . '</span>',
                    'description' => __( "Preview of how watermarks will appear on site images (click <b>Save Changes</b> below to view)", 'wpipp') . "<br/><br/>" . __( "This is only a guide, for best result check your website. Be sure to clear caches if watermarks do not appear correctly at first", 'wpipp'),
                    'fields' => array(
                      'watermark_live_preview' => array (
                        'label' => __("Current Image Preview", 'wpipp'),
                        'description' => __( "How your watermark will appear on images", 'wpipp'),
                        'function' => 'wpipp_watermark_live_preview',
                        'default_value' =>  "NA"
                        ),
                      ),
                    ),

                'wpipp_advanced_options' => array(
                'title' =>  '<i class="icon-gears icon-2x"></i> ' . '<span>' . __("Advanced Options", 'wpipp') . '</span>',
                'description' => __( "Additional options for WP Image Protect", 'wpipp') . " <span id = 'show_advanced_wpipp_settings_container'></span>",
                'fields' => $this->wpipp_premium_advanced_options() + $this->wpipp_standard_advanced_options()           
                ),

                
              );
          



           //Dropdown Options
          $dropdown_options = array (
              'dd_text_colour' => array (
                  '#f00' => __( "Red", 'wpipp') ,
                  '#0f0' => __( "Green", 'wpipp'),
                  '#00f' => __( "Blue", 'wpipp'),
                  '#fff' => __( "White", 'wpipp'),
                  '#000' => __( "Black", 'wpipp'),
                  '#aaa' => __( "Gray", 'wpipp'),
                  ),
              'dd_background_colour' => array (
                  'none' => __( "Transparent (None)", 'wpipp') ,
                  '#f00' => __( "Red", 'wpipp') ,
                  '#0f0' => __( "Green", 'wpipp'),
                  '#00f' => __( "Blue", 'wpipp'),
                  '#fff' => __( "White", 'wpipp'),
                  '#000' => __( "Black", 'wpipp'),
                  '#aaa' => __( "Gray", 'wpipp'),
                  ),
              'dd_position' => array (
                  'tl' => __( "Top Left", 'wpipp'),
                  'tc' => __( "Top Middle", 'wpipp'),
                  'tr' => __( "Top Right", 'wpipp'),
                  'cl' => __( "Middle Left", 'wpipp'),
                  'cc' => __( "Middle", 'wpipp'),
                  'cr' => __( "Middle Right", 'wpipp'),
                  'bl' => __( "Bottom Left", 'wpipp'),
                  'bc' => __( "Bottom Middle", 'wpipp'),
                  'br' => __( "Bottom Right", 'wpipp'),
                  'rp' => __( "Tile X and Y", 'wpipp'),
                  ),
              'dd_boolean' => array (
                  'true' => __( "Enabled", 'wpipp'),
                  'false' => __( "Disabled", 'wpipp'),
                  ),
              'dd_render' => array (
                  'JPG' => __( "JPG", 'wpipp'),
                  'PNG' => __( "PNG", 'wpipp'),
                  ),
              'dd_onoff' => array (
                  'on' => __( "On", 'wpipp'),
                  'off' => __( "Off", 'wpipp'),
                  ),
              );
            
            
            if(!function_exists('wpipp_premium_visible_options')){
              $dropdown_options['dd_visible_option'] = array (
                  'none' => __( "None", 'wpipp'),
                  'text' => __( "Text", 'wpipp'),
                  );
            } else {
              $dropdown_options['dd_visible_option'] = wpipp_premium_visible_options();
            }
            


          $vars = array(
                'group' => $group,
                'page_name' => $page_name,
                'title' => $title,
                'intro_text' => $intro_text,
                'nav_title' => $nav_title,
                'sections' => $sections,
                'dropdown_options' => $dropdown_options,
                'font_list' => $this->font_list
              );


          return $vars;

         

    }


    function wpipp_visible_options(){
     return array( 'visible_enabled' => array (
                    'label' => __("Enabled", 'wpipp'),
                    'description' => __( "Sets the watermark option across the site", 'wpipp'),
                    'dropdown' => "dd_visible_option",
                    'onchange' => 'visible_enabled_change(this.value)',
                    'default_value' => "none"
                    ),
                'watermark_on_size' => array(
                    'label' => __("Watermark only Size", 'wpipp'),
                    'description' => __( "Specify the minimum height or width of images before watermarks are applied", 'wpipp'),
                    'length' => "4",
                    'suffix' => "px",
                    'field_class' => 'wpipp_basic',
                    'default_value' => "300"
                    ),
                
                );
    }

    function wpipp_image_options(){
      if(function_exists('wpipp_image_options_values')){
        return wpipp_image_options_values();
      } else {
        return array();
      } 
    }

    function wpipp_text_options(){
      return array( 'watermark_text' => array (
                    'label' => __("Watermark Text", 'wpipp'),
                    'description' => __( "Text to display on images", 'wpipp'),
                    'field_class' => 'wpipp_text',
                    'default_value' => get_bloginfo(),
                    ),
                'watermark_text_font' => array (
                    'label' => __("Text Font", 'wpipp'),
                    'description' => __( "Name of font to be used", 'wpipp'),
                    'function' => 'plugin_font_dropdown',
                    'field_class' => 'wpipp_text',
                    'onchange' => 'font_change(this.id)',
                    'default_value' => key($this->font_list),
                    ),
                'watermark_text_size' => array (
                    'label' => __("Text Size", 'wpipp'),
                    'description' => __( "Font size of text", 'wpipp'),
                    'length' => "2",
                    'suffix' => "px",
                    'callback' => 'validate_text_size_entry',
                    'field_class' => 'wpipp_text',
                    'default_value' => "12"
                    ),
                'watermark_text_colour' => array(
                    'label' => __("Text Colour", 'wpipp'),
                    'description' => __( "Choose the display text colour you'd like", 'wpipp'),
                    'dropdown' => "dd_text_colour",
                    'field_class' => 'wpipp_text',
                    'default_value' => "#000"
                    ),
                'watermark_text_border_width' => array (
                    'label' => __("Text Margin", 'wpipp'),
                    'description' => __( "Size of the text border", 'wpipp'),
                    'length' => "5",
                    'suffix' => "px",
                    'callback' => 'validate_text_border_width_entry',
                    'field_class' => 'wpipp_text',
                    'default_value' => "5"
                    ),
                'watermark_text_background_colour' => array (
                    'label' => __("Background Colour", 'wpipp'),
                    'description' => __( "Colour of the text box", 'wpipp'),
                    'dropdown' => "dd_background_colour",                  
                    'field_class' => 'wpipp_text',
                    'default_value' => "#fff"
                    ),  
                );
    }


    function wpipp_position_options(){
      return array ('watermark_position' => array(
                    'label' => __("Watermark Position", 'wpipp'),
                    'description' => __( "Position of watermark on image", 'wpipp'),
                    'dropdown' => "dd_position",
                    'field_class' => 'wpipp_basic',
                    'default_value' => "br"
                    ),
                    'watermark_scale' => array(
                    'label' => __("Watermark Scaling", 'wpipp'),
                    'description' => __( "Whether to scale the watermark relative to the image size", 'wpipp'),
                    'dropdown' => "dd_onoff",
                    'field_class' => 'wpipp_basic',
                    'default_value' => "off"
                    ),
                  );
    }

    function wpipp_transparency_options(){
      if(function_exists('wpipp_transparency_options_values')){
        return wpipp_transparency_options_values();
      } else {
        return array();
      } 
    }

    function wpipp_premium_advanced_options(){
      if(function_exists('wpipp_premium_advanced_options_values')){
        return wpipp_premium_advanced_options_values();
      } else {
        return array();
      }
       
    }

    function wpipp_standard_advanced_options(){
      return array( 'render_option' => array(
                    'label' => __("Render Images", 'wpipp'),
                    'description' => __( "Choose how you wish the Watermarked images to be rendered (JPG is fastest)", 'wpipp'),
                    'dropdown' => "dd_render",
                    'field_class' => 'wpipp_advanced_options',
                    'default_value' => "false"
                    ), 
                   'htaccess_option' => array(
                    'label' => __("Rewrite Rules", 'wpipp'),
                    'field_class' => 'wpipp_advanced_options',
                    'function' => 'plugin_setting_textarea',
                    'description' => __( "Caution - do not edit the rewrite rules unless you know what you are doing<br/>", 'wpipp'),
                    'callback' => 'flush_rewrite_rules',
                    'default_value' => $this->get_rewrite_rule(),
                    ),
                    'debug_option' => array(
                    'label' => __("Debug Option", 'wpipp'),
                    'field_class' => 'wpipp_advanced_options',
                    'dropdown' => 'dd_boolean',
                    'description' => __( "Enable debug option for watermarks <br/>", 'wpipp'),
                    'default_value' => 'false',
                    ),    
        );
    }



    /*
    * return the default rewrite rule
    */
    function get_rewrite_rule(){
        $uploads_path = "wp-content/uploads/";
        $nextgen_path = "wp-content/gallery/";

        //write the new .htaccess rules to redirect image serving to the image serving proxy
        $non_wp_rules = '(.*)'.$uploads_path.'((.*)\.(jpe?g|gif|png))$' . '=>' . '$1'.$this->get_proxy_location().'?src='.$uploads_path.'$2' . ',' . '(.*)'.$nextgen_path.'((.*)\.(jpe?g|gif|png))$' . '=>' . '$1'.$this->get_proxy_location().'?src='.$nextgen_path.'$2';

        return $non_wp_rules;
    }

    /*
    * flush the rewrite_rules after they have been set
    */
    function flush_rewrite_rules($input){
        //TODO: Add function to activate rewrite_rules immediately
        //implemented in the renderer when the post request includes settings-updated=true
        return $input;
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
    * gets the custom rewrite rules from user options
    */
    function get_custom_rewrite_rules(){
      //load rewrite rules
      $wpipp_htaccess_option = get_option('wpippDisplay_htaccess_option');
      $wpipp_htaccess_option_string = $wpipp_htaccess_option['text_string'];

      //not set /created at all
      if($wpipp_htaccess_option == NULL){
        $wpipp_htaccess_option_string = $this->get_rewrite_rule();
      }

      return $this->return_rewrite_rules($wpipp_htaccess_option_string);
    }

    /**
    * returns the custom rewrite rules as an array of from=>to
    */
    function return_rewrite_rules($custom_rules_string){
      $custom_rules = array();

      $custom_rules_string_array = explode(",", $custom_rules_string);

      foreach($custom_rules_string_array as $value){
        $current_rule = $this->return_rule($value);
        if($current_rule != NULL && $current_rule[0] != NULL){
          array_push($custom_rules, array(trim($current_rule[0]) => trim($current_rule[1])));
        }
        
      }

      return $custom_rules;
    }

    /** 
    * return rule in the form A1 => A2
    */
    function return_rule($rule_string){
      return  explode("=>", $rule_string);
    }

     
      /**
     * add this page to the Settings tab in the admin panel
     */ 
    function plugin_admin_add_page() {
      global $wpipp_settings, $page_name;
      $page_name = add_options_page($wpipp_settings['title'], $wpipp_settings['nav_title'], 'manage_options', $wpipp_settings['page_name'], array( &$this,'plugin_options_page'));

      // Using registered $page handle to hook script load
      add_action('admin_print_scripts-' . $page_name, array( &$this, 'wpipp_options_enqueue_scripts'));
    }
     

     /**
     * load the options page
     */ 
    function plugin_options_page() {
      global $wpipp_settings;
      printf('</pre>
      <div class = "wrap">
      <div id="icon-options-general" class="icon32"><br /></div>
      <h2>%s</h2>
      <p>%s</p>',$wpipp_settings['title'],$wpipp_settings['intro_text']);
      echo "<div class = 'wpipp-box-left wpipp-settings-panel'>";
      echo "<form action='options.php' method='post'>";

       settings_fields($wpipp_settings['group']);
       $this->wpipp_do_settings_sections($wpipp_settings['page_name']);
       printf('<br/><br/>&nbsp;<input type="submit" name="Submit" value="%s" /></form>
              <pre>
              ',__('Save Changes'));
       echo "</div>  <!-- end wpipp-box-left -->";
       echo "<div class = 'wpipp-box-right wpipp-settings-panel'>";
       $this->wpipp_side_boxes();
       echo "</div> <!-- end wpipp-box-right -->";

    }

    /**
    * custom settings section
    */
    function wpipp_do_settings_sections( $page ) {
      global $wp_settings_sections, $wp_settings_fields;

      if ( ! isset( $wp_settings_sections ) || !isset( $wp_settings_sections[$page] ) )
        return;

      foreach ( (array) $wp_settings_sections[$page] as $section ) {
        echo "<div class = 'postbox'>";
        if ( $section['title'] ){
          echo "<h3 class ='section-title'>{$section['title']}</h3>\n";
        }
          
        echo "<div class = 'setting-content'>";
        if ( $section['callback'] )
          call_user_func( $section['callback'], $section );

        if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
          continue;
        echo '<table class="form-table">';
        do_settings_fields( $page, $section['id'] );
        echo '</table>';
        echo "</div> <!-- end setting-content -->"; //end setting-content
        echo "</div> <!-- end postbox -->"; //end postbox
      }
    }

    
    /**
     * add the settings
     */ 
    function plugin_admin_init(){
      global $wpipp_settings;
      foreach ($wpipp_settings["sections"] AS $section_key=>$section_value) :
        add_settings_section($section_key, $section_value['title'], array( &$this, 'plugin_section_text'), $wpipp_settings['page_name'], $section_value);
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          $function = (!empty($field_value['dropdown'])) ? array( &$this, 'plugin_setting_dropdown' ) : array( &$this, 'plugin_setting_string' );
          $function = (!empty($field_value['function'])) ? array( &$this,  $field_value['function'] ) : $function;
          $callback = (!empty($field_value['callback'])) ? array( &$this,  $field_value['callback'] ) : NULL;
          add_settings_field($wpipp_settings['group'].'_'.$field_key, $field_value['label'], $function, $wpipp_settings['page_name'], $section_key,array_merge($field_value,array('name' => $wpipp_settings['group'].'_'.$field_key)));
          register_setting($wpipp_settings['group'], $wpipp_settings['group'].'_'.$field_key,$callback);
          endforeach;
        endforeach;
    }
     
     /**
     * add options to wordpress options API for the WP Image Protect Premium Plugin
     * initialize these options
     */
     function wpipp_add_options(){
      
      global $wpipp_settings;
      foreach ($wpipp_settings["sections"] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          add_option($wpipp_settings['group'].'_'.$field_key, array("text_string" => $field_value['default_value']));
          endforeach;
        endforeach; 

      //update options for versions etc.
      update_option('wpipp_version', WPIPP_VERSION);
      update_option('wpipp_mode', WPIPP_MODE);
      update_option('wpipp_textdomain', WPIPP_TEXTDOMAIN);  
      update_option('wpipp_active', true);    
    }

    /**
     * remove options from wordpress options API for the WP Image Protect Premium Plugin
     */
    function wpipp_remove_options(){
      global $wpipp_settings;

      /* As of v0.83 - settings no longer deleted */
      /*
      foreach ($wpipp_settings["sections"] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          delete_option($wpipp_settings['group'].'_'.$field_key);
          endforeach;
        endforeach; 
      */

      delete_option('wpipp_version');
      delete_option('wpipp_mode');
      delete_option('wpipp_textdomain');
      delete_option('wpipp_active');
      delete_option('wpipp_continue_install');
      delete_option('wpipp_watermarks_not_set_ignore');
      delete_option('wpipp_premium_install_ignore');
    }


    function plugin_section_text($value = NULL) {
      global $wpipp_settings;
      printf("
    %s
     
    ",$wpipp_settings['sections'][$value['id']]['description']);
    }
     

    /*
    * Renderer for a standard string option
    */  
    function plugin_setting_string($value = NULL) {
      $options = get_option($value['name']);

      //special case for 0 string use asci &#48;
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : "&#48;";
      printf('<input id="%s" type="text" name="%1$s[text_string]" class="%2$s" value="%3$s" size="40" /> %4$s %5$s',
        $value['name'],
        (!empty ($value['field_class'])) ? $value['field_class'] : NULL,
        (!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
        (!empty ($value['suffix'])) ? $value['suffix'] : NULL,
        (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }
     

     /*
     * Renderer for a dropdown option
     */
    function plugin_setting_dropdown($value = NULL) {
      global $wpipp_settings;
      $options = get_option($value['name']);
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
      $onchange = (!empty ($value['onchange'])) ? $value['onchange'] : NULL;
      $current_value = ($options['text_string']) ? $options['text_string'] : $default_value;
        $chooseFrom = "";
        $choices = $wpipp_settings['dropdown_options'][$value['dropdown']];
      foreach($choices AS $key=>$option) :
        $chooseFrom .= sprintf('<option value="%s" %s>%s</option>',
          $key,($current_value == $key ) ? ' selected="selected"' : NULL,$option);
        endforeach;
        printf('
    <select id="%s" name="%1$s[text_string]" class="%2$s" onchange="%3$s" >%4$s</select>
    %5$s',$value['name'], (!empty ($value['field_class'])) ? $value['field_class'] : NULL, $onchange, $chooseFrom,
      (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }


      /*
     * Renderer for font dropdown option
     */
    function plugin_font_dropdown($value = NULL) {
      global $wpipp_settings;
      $options = get_option($value['name']);
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
      $onchange = (!empty ($value['onchange'])) ? $value['onchange'] : NULL;
      $current_value = ($options['text_string']) ? $options['text_string'] : $default_value;
        $chooseFrom = "";
        $choices = $wpipp_settings['font_list'];
      foreach($choices AS $key=>$option) :
        $chooseFrom .= sprintf('<option value="%s" id="%4$s" licence_url="%2$s" %3$s>%4$s</option>',
          $key,  $option['licence_file'], ($current_value == $key ) ? ' selected="selected"' : NULL, $option['font_name']);
        if($current_value == $key ){
          //set current licence file url for selected item
          $licence_file_url = $option['licence_file'];
        }
        endforeach;
        printf('
    <select id="%s" name="%1$s[text_string]" class="%2$s" onchange="%3$s" >%4$s</select>
    %5$s   (<a id="licence_url" href="%6$s" target="_blank">Click to view font licence</a>)',$value['name'], (!empty ($value['field_class'])) ? $value['field_class'] : NULL, $onchange, $chooseFrom,
      (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL, $licence_file_url);
    }

    /*
    * Renderer for the watermark image selector
    */
    function wpipp_watermark_image($value = NULL) {  
      if(function_exists('wpipp_watermark_image_premium')){
          wpipp_watermark_image_premium($value);
        }
    } 


    /*
    * Renderer for the uploaded watermark image preview
    */
    function wpipp_uploaded_watermark_preview($value = NULL) {  
        if(function_exists('wpipp_uploaded_watermark_preview_premium')) {
          wpipp_uploaded_watermark_preview_premium($value);
        }
    } 


      /*
      * Renderer for the watermark live image preview
      */
      function wpipp_watermark_live_preview() {  
          global $wpipp_settings;

          $wpipp_debug_option = get_option('wpippDisplay_debug_option');
          $wpipp_debug_option_string = isset($wpipp_debug_option) ? $wpipp_debug_option['text_string']: "false";


          //set the preview url to that of the rendering proxy
          $preview_url = plugins_url( '/php/wpipp-image-manager.php' , dirname(__FILE__) );
             ?>  
          <div id="live_matwatermark_preview" style="min-height: 100px;">  
              <?php 
                if($wpipp_debug_option_string == "false"):
              ?>
                  <img style="max-width:100%;" src="<?php echo esc_url( $preview_url ); ?>" /> 

              <?php
                else:
                  echo "<p>" . __("Debug Option is ENABLED, images will NOT be displayed, please disable it in advanced options below to show images on your site", 'wpipp') . "<p>";
                endif;
              ?>
          </div>
          <?php  
      } 

      /**
      * Renderer for a text area
      */
      function plugin_setting_textarea($value = NULL) {
      $options = get_option($value['name']);

      //flush rewrite_rules if settings-updated == true
      $settings_updated = $_GET['settings-updated'];
      if($settings_updated=="true"){
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
      }

      //special case for 0 string use asci &#48;
      $default_value = (!empty ($value['default_value'])) ? $value['default_value'] : "&#48;";
      printf('<textarea id="%s"  name="%1$s[text_string]" class="%2$s" value="%3$s" rows="6" cols="120"> %3$s </textarea><br/> %4$s %5$s',
        $value['name'],
        (!empty ($value['field_class'])) ? $value['field_class'] : NULL,
        (!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
        (!empty ($value['suffix'])) ? $value['suffix'] : NULL,
        (!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
    }




    /*
    * validation for image url
    */
    function validate_watermark_image_url($input){
      return $input;
    }

    /*
    * validation for image preview - dummy method
    */
    function validate_watermark_image_preview($input){
      if($_POST['delete_watermark_image_button']){
        add_settings_error( 'Alert', 'delete_watermark_pressed', 'Delete button pressed' );
        $this->wpipp_reset_option('wpipp_watermark_image_url');
      }
      return $input;
    }


    /*
    * validation for image transparency
    */
    function validate_transparency_value($input){
      global $wpipp_settings;
      //get current value to reset to
      $current_value = $this->get_wpipp_option_from_wp('watermark_transparency');
      $input_string = (!empty ($input['text_string'])) ? $input['text_string'] : NULL;
      if(is_null($input_string)){
        //input is 0 - as expected
        return $input;
      }elseif(!is_numeric($input_string)){
        add_settings_error( 'watermark_transparency', 'int_not_valid', 'Transparency must be a value between 0 and 100' );
        return $current_value;
      }  elseif(intval($input_string)<0){
        add_settings_error( 'watermark_transparency', 'int_too_small', 'Transparency cannot be less than 0' );
        return $current_value;
      } elseif(intval($input_string)>100){
        add_settings_error( 'watermark_transparency', 'int_too_large', 'Transparency cannot be greater than 100' );
        return $current_value;
      } else {
        return $input;
      }
      
    }

    /*
    * validation for cache option 
    */
    function validate_cache_option($input){
      if(function_exists('validate_cache_option_premium')){
        return validate_cache_option_premium($input);
      } else {
        return $input;
      }
    }

    /**
    * validate text size
    */
    function validate_text_size_entry($input){
      global $wpipp_settings;
      //get current value to reset to
      $current_value = $this->get_wpipp_option_from_wp('watermark_text_size');
      $input_string = (!empty ($input['text_string'])) ? $input['text_string'] : NULL;
      if(is_null($input_string)){
        //input is 0 - as expected
        return $input;
      }elseif(!is_numeric($input_string)){
        add_settings_error( 'watermark_text_size', 'int_not_valid', 'Text Size must be between 5 and 50 px' );
        return $current_value;
      }  elseif(intval($input_string)<5){
        add_settings_error( 'watermark_text_size', 'int_too_small', 'Text Size cannot be less than 5px' );
        return $current_value;
      } elseif(intval($input_string)>50){
        add_settings_error( 'watermark_text_size', 'int_too_large', 'Text Size cannot be greater 50px' );
        return $current_value;
      } else {
        return $input;
      }

    }


    /**
    * validate watermark text border width
    */
    function validate_text_border_width_entry($input){
      global $wpipp_settings;
      //get current value to reset to
      $current_value = $this->get_wpipp_option_from_wp('watermark_text_border_width');
      $input_string = (!empty ($input['text_string'])) ? $input['text_string'] : NULL;
      if(is_null($input_string)){
        //input is 0 - as expected
        return $input;
      }elseif(!is_numeric($input_string)){
        add_settings_error( 'watermark_text_border_width', 'int_not_valid', 'Text Border Width must be between 5 and 50 px' );
        return $current_value;
      }  elseif(intval($input_string)<0){
        add_settings_error( 'watermark_text_border_width', 'int_too_small', 'Text Border Width cannot be less than 0px' );
        return $current_value;
      } elseif(intval($input_string)>50){
        add_settings_error( 'watermark_text_border_width', 'int_too_large', 'Text Border Width cannot be greater 50px' );
        return $current_value;
      } else {
        return $input;
      }

    }


    /*
    * return the current value that option is specified in the wp options table
    */

    function get_wpipp_option_value_from_wp($option_name){
      global $wpipp_settings;
      
      $real_option_value_array = $this->get_wpipp_option_from_wp($option_name);
      $real_option_value_text_string  = $real_option_value_array['text_value'];
      return $real_option_value_text_string;
    }

    function get_wpipp_option_from_wp($option_name){
      global $wpipp_settings;
      //the real option name is prefixed with the group name
      $real_option_name = $wpipp_settings['group'] . "_" . $option_name;
      $real_option_value_array = get_option($real_option_name);
      return $real_option_value_array;
    }

    /**
     * reset an option to the original value
     */
     function wpipp_reset_option($option_name){
      
      global $wpipp_settings;
      foreach ($wpipp_settings["sections"] AS $section_key=>$section_value) :
        foreach ($section_value['fields'] AS $field_key=>$field_value) :
          if($field_key==$option_name){
            update_option($wpipp_settings['group'].'_'.$field_key, array("text_string" => $field_value['default_value']));
          }
          
          endforeach;
        endforeach; 
        
    }


    /**
    * displays the side boxes 
    */
    function wpipp_side_boxes(){

        $this->wpipp_support_box();
        if( !class_exists('wp_image_protect_premium'))
          $this->wpipp_premium_info_box();
        $this->wpipp_php_info_box();
    }

    /**
    * display support side box
    */

    function wpipp_support_box(){
      echo "<div class = 'postbox'>";

      echo "<h3 class ='section-title'>" . "<i class='icon-question-sign icon-2x'></i> " . "<span>" . __("Support", 'wpipp') . "</span></h3>\n";
        
      echo "<div class = 'setting-content'>";
      echo "". __("Need help with the plugin?", 'wpipp') . "<br/><br/>";
      echo "". __("Try the following:", 'wpipp') . "<br/>";
      echo "<ul>";
      echo "<li><a href = '" . WPIPP_DOCUMENTATION_URL . "' target = '_blank'>". __("Read the documentation", 'wpipp') . "</a></li>";
      echo "<li><a href = '" . WPIPP_DIRECTORY_SUPPORT . "' target = '_blank'>". __("Check the support forums", 'wpipp') . "</a></li>";
      echo "<li><a href = '" . WPIPP_HOMEPAGE_URL . "' target = '_blank'>". __("Visit the WP Image Protect website", 'wpipp') . "</a></li>";
      if(function_exists('display_premium_contact_details'))
        display_premium_contact_details();
      echo "</ul>";

      echo "</div>"; //end setting-content
      echo "</div>"; //end postbox

    }

    /**
    * display support side box
    */

    function wpipp_premium_info_box(){
      echo "<div class = 'postbox'>";

      echo "<h3 class ='section-title'>". "<i class='icon-bolt icon-2x'></i> " . "<span>" . __("Power Up", 'wpipp') . "</span></h3>\n";
        
      echo "<div class = 'setting-content'>";
      echo __("Want even more from WP Image Protect?", 'wpipp') . "<br/><br/>";
      echo __("Add the Premium Pack for:", 'wpipp') . "<br/>";
      echo "<ul>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Images as Watermarks", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Watermark Transparency", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Hotlink Prevention", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Supercharged Performance", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Variable Text Watermarks", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Additional Fonts", 'wpipp') . "</li>";
      echo "<li><span class = 'green-text'>&#10004; </span> ". __("Premium Support", 'wpipp') . "</li>";
      echo "</ul>";

      echo "<div class = 'find-out-center'><a href = '" . WPIPP_HOMEPAGE_URL . "' class ='find-out-more' target = '_blank'><i class='icon-hand-right icon-2x'></i>  <span>Find Out More</span></a></div>";

      echo "</div>"; //end setting-content
      echo "</div>"; //end postbox

    }

    /**
    * display php info box
    */
    function wpipp_php_info_box(){
      $wpipp_debug_option = get_option('wpippDisplay_debug_option');
      $wpipp_debug_option_string = isset($wpipp_debug_option) ? $wpipp_debug_option['text_string']: "false";
     

      if($wpipp_debug_option_string=="true"){
        //attempt to load wpipp-server-info
        @include_once( 'wpipp-server-info.php');
        echo "<div class = 'postbox'>";
          echo "<h3 class ='section-title'>". __("PHP Debug Info", 'wpipp') . "</h3>\n";
          echo "<div class = 'setting-content'>";
          if(class_exists('wpipp_server_info')){

              $wpipp_server_info_init = new wpipp_server_info();
              $wpipp_server_info_init->display_all_php_info();
          } else {
            echo "<b>" .  __("Could not load server info", 'wpipp') . "</b>";
          }
          echo "</div>"; //end setting-content

      
        echo "</div>"; //end postbox
      }
    }

    


 
//end class
}
 
$wpipp_settings_init = new wpipp_settings();
?>