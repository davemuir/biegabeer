<?php
/*
* WP Image Protect - Server Info Class
* Displays an array of server info
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*  
*/



class wpipp_server_info {


      //constructor
      function wpipp_server_info(){

      }

      /**
      * display all debug info
      */
      function display_all_php_info(){
        $this->wp_info();
        echo "<br/><br/>";
        $this->gd_information();
        echo "<br/><br/>";
        //$this->php_config_options();
      }


      /**
      * print key wordpress infomation
      */
      function wp_info(){
        echo "<h4>". __("WordPress Details", 'wpipp') . "</h4>";
        $this->wp_print_info('version');
        $this->wp_print_info('url');
        $this->wp_print_option('permalink_structure');
        ?>
          <span class = "key"><b>WP_DEBUG</b></span>
          <span class = "value"><?php echo (defined('WP_DEBUG') && WP_DEBUG==1 ) ? "Enabled" : "Production" ; ?></span><br/>
          <?php echo "(". __("Images will not be displayed if not production", 'WPIPP') . ")"; ?>
          <br/>
        <?
      }     


      /**
      * prints a wordpress option using get_option
      */
      function wp_print_option($name){
        if(function_exists('get_option')){
          ?>
            <span class = "key"><b><?php echo $name ?></b></span>
            <span class = "value"><?php echo get_option($name); ?></span>
            <br/>
          <?

        } else {
          echo __("Unable to get WordPress option for ", 'wpipp').$name;
        }

      }
      
      /**
      * prints a wordpress variable info using get_bloginfo
      */
      function wp_print_info($name){
        if(function_exists('get_bloginfo')){
          ?>
            <span class = "key"><b><?php echo $name ?></b></span>
            <span class = "value"><?php echo get_bloginfo($name); ?></span>
            <br/>
          <?

        } else {
          echo __("Unable to get WordPress info for ", 'wpipp').$name;
        }

      }
      

      /**
      * prints relevant gd information
      */
      function gd_information(){
        if(function_exists('gd_info')){
          $gd_options = gd_info();
          echo "<h4>". __("GD Info", 'wpipp') . "</h4>";


          foreach ($gd_options as $key => $value) {
            ?>
            <span class = "key"><b><?php echo $key; ?></b></span>
            <span class = "value"><?php echo $value==1? "true": "false"; ?></span>
            <br/>

            <?
          }
        } else {
          ?> <b>GD is not installed</b> <?php
        }


      }



      function php_config_options(){
        $config_options = ini_get_all();
        echo "<h4>". __("PHP Configuration Options", 'wpipp') . "</h4>";


        foreach ($config_options as $key => $value) {
          ?>
          <span class = "key"><b><?php echo $key; ?></b></span>
          <span class = "value"><?php echo print_r($value, true); ?></span>
          <br/>

          <?
          
        }
      }

    
}
 

?>