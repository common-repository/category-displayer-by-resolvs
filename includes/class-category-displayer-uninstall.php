<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Fired during plugin uninstall
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 */

/**
 * Fired during plugin uninstall.
 *
 * This class defines all code necessary to run during the plugin's uninstall.
 *
 * @since      1.0.0
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer_Uninstall {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall() {
        add_option('testing','testing123');
	}

}
