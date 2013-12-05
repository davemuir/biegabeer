<?php
/*
Plugin Name: Smart Watermark
Plugin URI: 
Description: Add image watermark to images uploaded to media library 
Author: Alex Muravyov
Version: 1.0.3
*/

require_once plugin_dir_path(__FILE__).'image-editor.php';

class Smart_Watermark {
    
    const OPTIONS_KEY = 'smart_watermark_options';
    
    const SETTINGS_KEY_GENERAL = 'smart_watermark_settings_general';
    
    const SETTINGS_KEY_BULK = 'smart_watermark_settings_bulk';
    
    protected $_settingsPages = array();
    
    protected $_settings = array();
    
    private $_version = '1.0.3';
    
    public function __construct() {
        add_action('init', array($this, 'load_settings'));
        if (is_admin()) {
            add_action('admin_init', array($this, 'media_upload_setup'));
            add_action('admin_init',  array($this, 'register_settings'));
            add_action('admin_enqueue_scripts', array($this, 'options_enqueue_scripts')); 
            add_action('admin_menu', array($this, 'build_menu'));
            add_action('wp_ajax_smart_watermark_proceed', array($this, 'ajax_proceed'));
            add_action('wp_ajax_smart_watermark_stat', array($this, 'ajax_stat'));
        }   
        add_filter('wp_update_attachment_metadata', array($this, 'add_watermark'), 10, 2);
    } 
    
    public function ajax_proceed() {
        $offset = $_POST['offset'];
        $limit = $_POST['limit'];
        $args = array(
                        'post_type' => 'attachment', 
                        'posts_per_page' => $limit, 
                        'offset'        => $offset,
                        'post_status' => null, 
                        'post_parent' => null ); 
        $attachments = get_posts($args);   
        foreach ($attachments as $attachment) {
            $this->add_watermark(wp_get_attachment_metadata($attachment->ID), $attachment->ID);
        }
        exit;
    }
    
    public function ajax_stat() {
        $stat = 0;
        foreach (wp_count_attachments() as $info) $stat += $info;
        echo $stat;
        exit;
    }    
    
    public function add_watermark($metadata, $attachment_id) {
        if (strpos(wp_get_referer(), 'smart_watermark_referer')!==false) return $metadata;
        $upload_dir = dirname(get_attached_file($attachment_id));
        foreach ($metadata['sizes'] as $size => $image) {
            if (in_array($size, $this->_settings['images'])) {
                $path = $upload_dir.'/'.$image['file'];
                $this->_proceed($path);
            }
        }
        if (in_array('original', $this->_settings['images'])) {
            $this->_proceed(get_attached_file($attachment_id));
        }
        return $metadata;
    }
    
    protected function _proceed($image_path) {
        if ($this->_settings['watermark']=='') return false;
        $image = new WP_Image_Editor_GD_Watermark($image_path);
        $image->load();
        $image_size = $image->get_size();
        $watermark = new WP_Image_Editor_GD_Watermark($this->_settings['watermark']);
        $watermark->load();
        $watermark_size = $watermark->get_size();
        //get watermark position
        if ($image_size['width']<=$watermark_size['width'] || 
            $image_size['height']<=$watermark_size['height']) return false;
        if ($image_size['width'] < $this->_settings['image_min_width'] || 
            $image_size['height'] < $this->_settings['image_min_height']) return false;
        $watermark_position = $this->_get_watermark_position($image_size['width'], $image_size['height'], $watermark_size['width'], $watermark_size['height']);
        $result = $image->merge($watermark, $watermark_position);
        if ($result) return $image->save($image_path);
        return false;
    }
    
    protected function _get_watermark_position($image_width, $image_height, $watermark_width, $watermark_height) {
        $x = 0;
        $y = 0;
        switch ($this->_settings['position']) {
            case 'top-left':
                $x = 0;
                $y = 0;
                break;
            case 'top-middle':
                $x = ceil($image_width/2-$watermark_width/2);
                $y = 0;
                break;
            case 'top-right':
                $x = $image_width-$watermark_width;
                $y = 0;
                break; 
            
            case 'middle-left':
                $x = 0;
                $y = ceil($image_height/2-$watermark_height/2);
                break;
            case 'middle-middle':
                $x = ceil($image_width/2-$watermark_width/2);
                $y = ceil($image_height/2-$watermark_height/2);
                break;
            case 'middle-right':
                $x = $image_width-$watermark_width;
                $y = ceil($image_height/2-$watermark_height/2);
                break; 
            
            case 'bottom-left':
                $x = 0;
                $y = $image_height-$watermark_height;
                break;
            case 'bottom-middle':
                $x = ceil($image_width/2-$watermark_width/2);
                $y = $image_height-$watermark_height;
                break;
            case 'bottom-right':
                $x = $image_width-$watermark_width;
                $y = $image_height-$watermark_height;
                break;            
        }
        $x += $this->_settings['offset_left'];
        $y += $this->_settings['offset_top'];
        return array('x' => $x, 'y' => $y);
    }
    
    public function media_upload_setup() {  
        global $pagenow;  
        if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {  
            // Now we'll replace the 'Insert into Post Button' inside Thickbox  
            add_filter('gettext', array($this, 'replace_thickbox_text'), 1, 3 ); 
        } 
    }
 
    public function replace_thickbox_text($translated_text, $text, $domain) { 
        if ('Insert into Post' == $text) { 
            $referer = strpos(wp_get_referer(), 'smart_watermark_referer'); 
            if ($referer != '') { 
                return 'Add Watermark';  
            }  
        }  
        return $translated_text;  
    }     
    
    public function options_enqueue_scripts() {
        wp_register_script(
                            'smart-watermark-settings-general', 
                            plugins_url('js/smart-watermark-settings-general.js', __FILE__), 
                            array('jquery', 'media-upload', 'thickbox')
                          ); 
        wp_register_script(
                            'smart-watermark-settings-bulk', 
                            plugins_url('js/smart-watermark-settings-bulk.js', __FILE__), 
                            array('jquery', 'media-upload', 'thickbox')
                          );       
        switch ($this->_get_current_settings_tab()) {
            case self::SETTINGS_KEY_GENERAL:
                wp_enqueue_script('jquery');
                wp_enqueue_script('thickbox');  
                wp_enqueue_style('thickbox');  
                wp_enqueue_script('media-upload');             
                wp_enqueue_script('smart-watermark-settings-general'); 
                break;
            case self::SETTINGS_KEY_BULK:
                wp_enqueue_script('jquery');
                wp_enqueue_script('smart-watermark-settings-bulk'); 
                wp_localize_script('jquery', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
                break;
        }
    }
    
    public function load_settings() {
        $this->_settings['position']    = get_option('position', 'bottom-right');
        $this->_settings['offset_top']  = get_option('offset_top', 0);
        $this->_settings['offset_left'] = get_option('offset_left', 0);
        $this->_settings['images']      = get_option('images', array());
        $this->_settings['watermark']   = get_option('watermark', '');
        $this->_settings['image_min_width']   = get_option('image_min_width', 300);
        $this->_settings['image_min_height']   = get_option('image_min_height', 300);
    }
    
    public function build_menu() {
        add_options_page(
                            'Smart Watermark Settings', 
                            'Smart Watermark', 
                            'manage_options', 
                            self::OPTIONS_KEY, 
                            array($this, 'display_options_page')
                        );
        $this->_settingsPages[self::SETTINGS_KEY_GENERAL]   = 'General Settings';
        $this->_settingsPages[self::SETTINGS_KEY_BULK]      = 'Bulk Update';
    }
    
    protected function _get_current_settings_tab() {
        return isset($_GET['tab'])?$_GET['tab']:self::SETTINGS_KEY_GENERAL;
    }
    
    public function display_options_page() {
        $tab = $this->_get_current_settings_tab();
    ?>
        <div class="wrap">
            <h2>Smart Watermark</h2>	
            <?php $this->display_options_page_tabs(); ?>
            <?php if ($tab==self::SETTINGS_KEY_BULK): ?>
            <br />
            <div style="width:300px;border:1px #000 solid;height:20px;position:relative;"><div id="watermark_bulk_progressbar" style="background-color: blue;height:100%;width:1%;"></div><div id="watermark_bulk_progressbar_stat" style="position:absolute;left:150px;top:0px;">0%</div></div>
            <br />
            <input type="button" id="watermark_run_bulk" class="button" value="Proceed Old Images" />
            <?php else: ?>
            <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <?php settings_fields($tab); ?>
            <?php do_settings_sections($tab); ?>
            <?php submit_button(); ?>
            </form>
            <?php endif; ?>
        </div>
    <?php           
    }
    
    public function register_settings() {

        register_setting(self::SETTINGS_KEY_GENERAL, 'position'); 
        register_setting(self::SETTINGS_KEY_GENERAL, 'offset_top', 'intval'); 
        register_setting(self::SETTINGS_KEY_GENERAL, 'offset_left', 'intval'); 
        register_setting(self::SETTINGS_KEY_GENERAL, 'images');
        register_setting(self::SETTINGS_KEY_GENERAL, 'watermark');
        register_setting(self::SETTINGS_KEY_GENERAL, 'image_min_width', 'intval');
        register_setting(self::SETTINGS_KEY_GENERAL, 'image_min_height', 'intval');
        add_settings_section('section_general', '', array($this, 'display_general_settings'), self::SETTINGS_KEY_GENERAL);
        add_settings_field('position', 'Watermark Position', array($this, 'field_option_position'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('offset_top', 'Watermark Offset Top', array($this, 'field_option_offset_top'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('offset_left', 'Watermark Offset Left', array($this, 'field_option_offset_left'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('image_min_width', 'Min Image Width', array($this, 'field_option_image_min_width'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('image_min_height', 'Min Image Height', array($this, 'field_option_image_min_height'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('position', 'Watermark Position', array($this, 'field_option_position'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('images', 'Add Watermark To', array($this, 'field_option_images'), self::SETTINGS_KEY_GENERAL, 'section_general');
        add_settings_field('watermark', 'Watermark Image', array($this, 'field_option_watermark'), self::SETTINGS_KEY_GENERAL, 'section_general');
    }

    public function display_general_settings() {
        echo '';
    }
    
    public function field_option_images() {
        $sizes = array_merge(array('original'), get_intermediate_image_sizes());
        foreach ($sizes as $size) {
    ?>   
            <input type="checkbox" name="images[]" value="<?php echo $size; ?>" <?php echo in_array($size, $this->_settings['images'])=='bottom-left'?'checked':''; ?> /> <?php echo $size; ?><br />
    <?php
        }    
    }
    
    public function field_option_watermark() {
    ?>   
        <input type="text" id="watermark" name="watermark" value="<?php echo esc_url($this->_settings['watermark']); ?>" />  
        <input id="upload_watermark" type="button" class="button" value="Upload" />
        <br /><br />
        <div id="watermark_preview">  
            <img src="<?php echo esc_url($this->_settings['watermark']); ?>" />  
        </div>            
    <?php
    }    

    public function field_option_position() {
    ?>
        <table border="1">
            <tr>
                <td><input type="radio" name="position" value="top-left" <?php echo $this->_settings['position']=='top-left'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="top-middle" <?php echo $this->_settings['position']=='top-middle'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="top-right" <?php echo $this->_settings['position']=='top-right'?'checked':''; ?>/></td>
            </tr>   
            <tr>
                <td><input type="radio" name="position" value="middle-left" <?php echo $this->_settings['position']=='middle-left'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="middle-middle" <?php echo $this->_settings['position']=='middle-middle'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="middle-right" <?php echo $this->_settings['position']=='middle-right'?'checked':''; ?>/></td>
            </tr> 
            <tr>
                <td><input type="radio" name="position" value="bottom-left" <?php echo $this->_settings['position']=='bottom-left'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="bottom-middle" <?php echo $this->_settings['position']=='bottom-middle'?'checked':''; ?>/></td>
                <td><input type="radio" name="position" value="bottom-right" <?php echo $this->_settings['position']=='bottom-right'?'checked':''; ?>/></td>
            </tr>             
        </table>    
    <?php
    }  
    
    public function field_option_offset_top() {
    ?>
        <input type="text" name="offset_top" value="<?php echo esc_attr($this->_settings['offset_top']); ?>" /> px 
    <?php
    } 
    
    public function field_option_offset_left() {
    ?>
        <input type="text" name="offset_left" value="<?php echo esc_attr($this->_settings['offset_left']); ?>" /> px 
    <?php
    }  
    
    public function field_option_image_min_width() {
    ?>
        <input type="text" name="image_min_width" value="<?php echo esc_attr($this->_settings['image_min_width']); ?>" /> px 
    <?php
    } 
    
    public function field_option_image_min_height() {
    ?>
        <input type="text" name="image_min_height" value="<?php echo esc_attr($this->_settings['image_min_height']); ?>" /> px 
    <?php
    }      
    
    public function display_options_page_tabs() {
        $current_tab = $this->_get_current_settings_tab();
        echo '<h2 class="nav-tab-wrapper">';
        foreach ($this->_settingsPages as $tab_key => $tab_caption) {
            $active = $current_tab==$tab_key?'nav-tab-active':'';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . self::OPTIONS_KEY . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
        echo '</h2>';
    }
    
}

$smart_watermark = new Smart_Watermark();
 