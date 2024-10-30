<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/public
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $plugin_dir_path;
	private $plugin_dir_url;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_dir_path, $plugin_dir_url ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_dir_path = $plugin_dir_path;
		$this->plugin_dir_url = $plugin_dir_url;

		$this->register_shortcode();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$include_bootstrap = false;
		$get_settings = get_option('catdisp_general_settings');
		if($get_settings){
			$get_settings = maybe_unserialize($get_settings);
			if(isset($get_settings['enable-bootstrap']) && $get_settings['enable-bootstrap']=='1'){
				$include_bootstrap = true;
			}
		}
		if($include_bootstrap){
			wp_register_style( 'bootstrap',  plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(),  $this->version, 'all' );
		}
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/category-displayer-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/category-displayer-public.js', array( 'jquery' ), $this->version, false );
	}

	public function register_shortcode(){
		add_shortcode('category_displayer', array($this, 'category_displayer_handler') );
	}	

	public function category_displayer_handler($atts){
		global $wpdb;
		ob_start();
		$atts['id'] = sanitize_text_field($atts['id']);
		if($atts['id']){
			wp_enqueue_style( 'bootstrap');

			$shortcode_id  = $atts['id'];
			$result = $wpdb->get_row($wpdb->prepare( "SELECT * FROM {$wpdb->prefix}categs_shortcodes WHERE ID = %d LIMIT 1" , $shortcode_id ), 'ARRAY_A' );
			if ( $result !== null) {
				$template_id   = $result['tpl_id'];
				$settings = unserialize($result['settings']);

				$Category_Displayer_Admin = new Category_Displayer_Admin($this->plugin_name, $this->version, $this->plugin_dir_path, $this->plugin_dir_url);

				
				
				
				if($settings){
					$dir_path = '';
					if($settings['type']=='pro'){
						if(defined('CATEGORY_DISPLAYER_PRO_DIR_PATH')){
							$dir_path = CATEGORY_DISPLAYER_PRO_DIR_PATH;
						}
					}
					else{
						$dir_path = $this->plugin_dir_path;
					}
					if(file_exists($dir_path.'templates/'.$template_id.'/category-displayer.php')){
						require_once($dir_path.'templates/'.$template_id.'/category-displayer.php');
					}
					
					$settings = $Category_Displayer_Admin->prepare_css($settings);
					$settings['id'] = $result['ID'];
					$tax = $settings['categdisp_taxonomy'];

					$template_allowed = true;
					$template_allowed = apply_filters('catdisp_shortcode_allow_template', $result['tpl_id']);
					if($template_allowed != '1'){
						do_action('catdisp_shortcode_template_not_allowed');
						return ob_get_clean();
					}

					$taxonomy_allowed = true;
					$taxonomy_allowed = apply_filters('catdisp_shortcode_allow_taxonomy', $tax);
					if($taxonomy_allowed !='1'){
						do_action('catdisp_shortcode_taxonomy_not_allowed', $tax);
						return ob_get_clean();
					}

					
					if($settings['elements'] || $settings['hover']){
						require($this->plugin_dir_path.'public/css/shortcode-css.php');
					}
					if(file_exists($dir_path.'templates/'.$template_id.'/output.php')){
						require($dir_path.'templates/'.$template_id.'/output.php');
					}
					if(!file_exists($dir_path.'templates/'.$template_id.'/category-displayer.php') || !file_exists($dir_path.'templates/'.$template_id.'/output.php')){
						echo '<p><small>'.__('This template does not exists!',$this->plugin_name).'</small></p>';
					}
				}
			}
			else{
				echo '<p><small>'.__('Wrong shortcode ID',$this->plugin_name).'</small></p>';
			}

		}

		return ob_get_clean();
	}

	public function catdisp_shortcode_allow_template_callback($tpl_id){
		global $plugin_admin;
		$default_installed = $plugin_admin->catdisp_default_installed_templates();
		if(!in_array($tpl_id, $default_installed)){
			return false;
		}
		return true;
	}


	
	public function catdisp_shortcode_template_not_allowed_callback(){
		if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
			echo '<p><small>'.__('This template requires Category Displayer PRO version!',$this->plugin_name).'</small></p>';
		}
		elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
			echo '<p><small>'.__('This template requires an active license!', $this->plugin_name).'</small></p>';
		}
	}


	public function catdisp_shortcode_allow_taxonomy_callback($tax){
		global $plugin_admin;
		$catdisp_allow_taxonomies = $plugin_admin->catdisp_allow_taxonomies();
		if(!in_array($tax, $catdisp_allow_taxonomies)){
			return false;
		}
		return true;
	}

	public function catdisp_shortcode_taxonomy_not_allowed_callback($tax){
		if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
			echo '<p><small>'. $tax.' '.__(' taxonomy requires Category Displayer PRO version!',$this->plugin_name).'</small></p>';
		}
		elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
			echo '<p><small>'. $tax.' '.__(' taxonomy requires an active license!', $this->plugin_name).'</small></p>';
		}
	}

}
