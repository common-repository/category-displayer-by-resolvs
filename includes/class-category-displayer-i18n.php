<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'category-displayer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
