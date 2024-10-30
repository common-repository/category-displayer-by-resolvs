<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
class Category_Displayer_Icons {
    
    public function __construct() {
        if ( defined( 'CATEGORY_DISPLAYER_VERSION' ) ) {
			$this->version = CATEGORY_DISPLAYER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
        
        $this->load_dependencies();
    }

    public function load_dependencies(){
		wp_enqueue_style('wpcd-fontawesome', plugin_dir_url( __FILE__ ) . 'assets/css/fontawesome.min.css', array(), $this->version, 'all' );
    }
}

$Category_Displayer_Icons = new Category_Displayer_Icons();