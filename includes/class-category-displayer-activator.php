<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Fired during plugin activation
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$tblname = 'categs_shortcodes';
		$wp_track_table = $wpdb->prefix . "$tblname";
	  
		$sql = "CREATE TABLE IF NOT EXISTS $wp_track_table ( ";
		$sql .= "  `ID` bigint(20) UNSIGNED NOT NULL auto_increment, ";
		$sql .= "  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00', ";
		$sql .= "  `title` text COLLATE utf8mb4_unicode_520_ci NOT NULL, ";
		$sql .= "  `settings` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL, ";
		$sql .= "  `tpl_id` varchar(255), ";
		$sql .= "  PRIMARY KEY (`ID`) "; 
		$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=1 ; ";
		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		/* Check if catdisp_templates are not installed and import them from external json */
		$catdisp_templates = get_option('catdisp_templates');
		if($catdisp_templates == false){
			$get_json = file_get_contents(CATEGORY_DISPLAYER_EXTERNAL_JSON, false);
			$json = json_decode($get_json, true);
			// echo '<pre>'.print_r($json, 1).'</pre>'; 
			
			$Category_Displayer_Admin = new Category_Displayer_Admin(CATEGORY_DISPLAYER_NAME, CATEGORY_DISPLAYER_VERSION, CATEGORY_DISPLAYER_DIR_PATH, CATEGORY_DISPLAYER_DIR_URL);
			$default_installed = $Category_Displayer_Admin->catdisp_default_installed_templates();
			// echo '<pre>'.print_r($default_installed, 1).'</pre>'; 

			$catdisp_templates = array();
			foreach($default_installed as $id){
				
				$catdisp_templates[$id]['order'] = $json[$id]['order'];
				$catdisp_templates[$id]['version'] = $json[$id]['version'];
				$catdisp_templates[$id]['title'] = $json[$id]['title'];
				$catdisp_templates[$id]['desc'] = $json[$id]['short_description'];
				$catdisp_templates[$id]['status'] = 'installed';
				$catdisp_templates[$id]['cust'] = (object) array(
															'left'=> $json[$id]['customisation']['left'],
															'right'=> $json[$id]['customisation']['right'],
														);
				$catdisp_templates[$id]['default'] = (object) $json[$id]['default'];
				
			}
			if(!empty($catdisp_templates)){
				update_option('catdisp_templates', $catdisp_templates) ;
			}


		}

		/* Use bootstrap by default = TRUE */
		$catdisp_general_settings = get_option('catdisp_general_settings');
		if($catdisp_general_settings == false){
			update_option('catdisp_general_settings', array('enable-bootstrap'=>'1'));
		}
		
	
	

		
	}

}