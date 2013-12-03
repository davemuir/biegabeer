<?php
/*
* Install check module
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
*  
*/




class wpipp_install_check{

	private $gd_version_info = NULL; 
	private $wp_version_info = NULL;
	private $wpipp_compatible = true;

	//the gd version required
	private $gd_version_required = "2.0";
	//the  wordpress version required
	private $wp_version_required = "3.4";
	//define the latest version
	private $check_wpipp_version = NULL;

	//constructor
	function wpipp_install_check($check_version = "1.0"){
		if (extension_loaded('gd') && function_exists('gd_info')) {
			//populate gd info
    		$this->gd_version_info = gd_info();
		}
		//populate wordpress info
		$this->wp_version_info = $this->wordpress_version();
		//populate_check_version
		$this->check_wpipp_version = $check_version;

	}

	//this function listens for override 
    function continue_wpipp_install_check() {
        $continue_wpipp_install = $_GET['continue-wpipp-install'];
        if ( isset( $continue_wpipp_install ) && $continue_wpipp_install == 'true') {
                //update the wordpress option
        		if(function_exists('update_option')){
        			update_option('wpipp_continue_install', 'true');
        		}               
        }             
    }

	//return gd version as string
	function gd_version(){
		if(!is_null($this->gd_version_info)){
			return preg_replace('/[[:alpha:][:space:]()]+/', '', $this->gd_version_info["GD Version"]);
		} else{
			return "";
		}
	}


	//return FreeType support as Boolean
	function freetype_support(){
		if(!is_null($this->gd_version_info)){
			return $this->gd_version_info["FreeType Support"];
		} else{
			return false;
		}
	}

	//return PNG support as boolean
	function png_support(){
		if(!is_null($this->gd_version_info)){
			return $this->gd_version_info["PNG Support"];
		} else{
			return false;
		}
	}

	//return JPG support as boolean
	function jpg_support(){

		if(!is_null($this->gd_version_info)){
			if(array_key_exists("JPG Support", $this->gd_version_info)){
				return $this->gd_version_info["JPG Support"];
			} elseif (array_key_exists("JPEG Support", $this->gd_version_info)){
				return $this->gd_version_info["JPEG Support"];
			}
		}

		//default - return false
		return false;		
	}

	//return GIF Read support as boolean
	function gif_read_support(){
		if(!is_null($this->gd_version_info)){
			return $this->gd_version_info["GIF Read Support"];
		} else{
			return false;
		}
	}

	//return wordpress version as string
	function wordpress_version(){
		return get_bloginfo('version');		
	}

	//add and enqueue the stylesheets
	function wpipp_install_check_add_styles(){
		wp_register_style( 'wpipp-plugin-styles', plugins_url('css/wpipp-plugin-styles.css', dirname(__FILE__)) );
		wp_enqueue_style( 'wpipp-plugin-styles' );
	}

	//green tick
	function echo_green_tick(){
		echo '<div class = "green-text">&#10004;</div> ';
	}

	//red cross
	function echo_red_cross(){
		echo '<div class = "red-text">&#10008;</div> ';
	}

	//blue i
	function echo_blue_i(){
		echo '<div class = "blue-text"><b>i &nbsp;</b></div> '; 
	}

	//orange question mark
	function echo_orange_question(){
		echo '<div class = "blue-text"><b>&#63; &nbsp;</b></div> '; 
	}



	//test the wp compatibility
	function is_wp_compatible(){
		if($this->wordpress_version()>=$this->wp_version_required){
			return true;
		} else {
			$this->wpipp_compatible = false;
			return false;
		}
	}

	//output the results of the wp version check
	function echo_check_wp_version(){		
		echo '<span class = "wpstatus">';
		if($this->is_wp_compatible()){
			$this->echo_green_tick();
			echo 'Your WordPress version is compatible ' . '(' . $this->wordpress_version() . ')';
		} else {
			$this->echo_red_cross();
			echo 'Your WordPress version is NOT compatible ' . '(' . $this->wordpress_version() . ') ' . ' please contact your web administrator to upgrade to a compatible version of WordPress';			
		}
		echo '</span>';		
	}

	//test the gd compatibility
	function is_gd_compatible(){
		if($this->gd_version()>=$this->gd_version_required and $this->png_support() == true and $this->jpg_support() == true){
			return true;
		} else {
			$this->wpipp_compatible = false;
			return false;
		}
	}

	//output the results of the gd version and feature check
	function echo_check_gd_version(){		
		echo '<div class = "gdstatus">';
		if($this->is_gd_compatible()){
			$this->echo_green_tick();
			echo 'Your GD (image processing library) is compatible ' . '(' . $this->gd_version() . ')<br/>';
		} else {
			$this->echo_red_cross();
			echo 'Your GD (image processing library) is NOT compatible ' . '(' . $this->gd_version() . ')<br/>';			
		}
		if($this->freetype_support()){
			echo '<span class = "gdinfo">' . $this->echo_green_tick(). ' FreeType support enabled  </span>';
		} else {
			echo '<span class = "gdinfo">' . $this->echo_red_cross(). ' FreeType support NOT enabled  </span>';
		}
		if($this->png_support()){
			echo '<span class = "gdinfo">' . $this->echo_green_tick(). ' PNG support enabled  </span>';
		} else {
			echo '<span class = "gdinfo">' . $this->echo_red_cross(). ' PNG support NOT enabled  </span>';
		}
		if($this->jpg_support()){
			echo '<span class = "gdinfo">' . $this->echo_green_tick(). ' JPG support enabled  </span>';
		} else {
			echo '<span class = "gdinfo">' . $this->echo_red_cross(). ' JPG support NOT enabled  </span>';
		}
		if($this->gif_read_support()){
			echo '<span class = "gdinfo">' . $this->echo_green_tick(). ' GIF read support enabled  </span>';
		} else {
			echo '<span class = "gdinfo">' . $this->echo_red_cross(). ' GIF read support NOT enabled  </span>';
		}
		echo '</div>';		
	}

	//check that wpipp is not already installed
	function check_no_previous_versions_of_wpipp(){
		//check if current installation is newer, against a particular version
		$installed_wpipp_version = get_option('wpipp_version');

		if($installed_wpipp_version==""){
			//wpipp not installed
			return true;
		} elseif ($installed_wpipp_version <= $this->check_wpipp_version){
			//older or current version of wpipp installed
			return true;
		} else {
			//newer version of wpipp installed
			return false;
		}
	}

	//output the results of the wpipp version details
	function echo_check_no_previous_versions_of_wpipp(){
		$installed_wpipp_version = get_option('wpipp_version');		
		echo '<span class = "wpippstatus">';
		if($this->check_no_previous_versions_of_wpipp()){
			$this->echo_blue_i();
			if($installed_wpipp_version == ""){
				echo 'WP Image Protect is not installed';
			} else {
				echo 'An older version of WP Image Protect is installed  ' . '(' . $installed_wpipp_version . ')';
			}			
		} else {
			$this->echo_orange_question();
			echo 'WP Image Protect is already installed ' . '(' . get_option('wpipp_version') . ') ' . ' and may require disabling and uninstalling before continuing';			
		}
		echo '</span>';		
	}

	//output the end result
	function echo_check_result(){		
		echo '<span class = "wpippresult">';
		if($this->wpipp_compatible==true){
			echo 'Great! You can install the WP Image Protect Premium plugin, <b>download your copy on the <a href="http://8mediacentral.com/developments/wp-image-protect/" title = "WP Image Protect Site">WP Image Protect site</a> now.</b>';	
		} else {
			echo 'Unfortunately, your installation is not compatible with WP Image Protect Premium, please contact your support team to upgrade your WordPress or GD Library. More information on requirements for the plugin can be found on the <a href="http://8mediacentral.com/developments/wp-image-protect/" title = "WP Image Protect Site">WP Image Protect site</a>';
			echo  '<br/>';
			echo $this->echo_option_install_anyway();
		}		
		echo '</span>';		
	}

	function echo_option_install_anyway(){
		echo "Though your installation may not be compatible, you can <a href='?continue-wpipp-install=true' title = 'continue wp image protect installation'>install anyway.</a>";
	}
 

	//set the wordpress admin message
	function wpipp_install_check_admin_message(){
		$this->wpipp_install_check_add_styles();
		
	    ?>
	    	<div class = "wpipp-install-check-info-wrapper">
				<div class = "wpipp-styling-close-button-container"> <a class="wpipp-styling-close-button" href="?dismiss-wpipp-styling=dismiss" title="Dismiss this notice and deactivate WPIPP install check.">&#10006;</a></div>
				<div class = "wpipp-styling-info-text">
					<span class = "wpipptitle">WP Image Protect Premium Install Check</span>
					<?php  $this->echo_check_wp_version();  ?>
					<?php  $this->echo_check_gd_version();  ?>
					<?php  $this->echo_check_no_previous_versions_of_wpipp();  ?>
					<?php  $this->echo_check_result();  ?>
				</div>
			</div>
	    <?php 
	}


	


} //end class





?>