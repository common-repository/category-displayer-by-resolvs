<?php
/**
 * Plugin Name:       Category Displayer by Resolvs
 * Plugin URI:        https://wpcategorydisplayer.com/
 * Description:       WP Category Displayer allows the possibility to display WordPress categories and other taxonomies on pages or posts.
 * Version:           1.0.0
 * Author:            Resolvs, LLC
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/copyleft/gpl.html
 * Text Domain:       category-displayer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'CATEGORY_DISPLAYER_NAME', 'category-displayer');
define( 'CATEGORY_DISPLAYER_VERSION', '1.0.0' );
define( 'CATEGORY_DISPLAYER_BASENAME_FILE', plugin_basename(__FILE__) );
define( 'CATEGORY_DISPLAYER_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CATEGORY_DISPLAYER_DIR_URL', plugin_dir_url( __FILE__ ) );

define('CATEGORY_DISPLAYER_EXTERNAL_JSON', 'https://wpcategorydisplayer.com/category_displayer/template-library.json?secret=13259102a4e52aa01afbecf1759fad53');

/**
 * The code that runs during plugin activation
 */

if (!function_exists('activate_category_displayer')):
	function activate_category_displayer() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-displayer-activator.php';
		Category_Displayer_Activator::activate();
		register_uninstall_hook( __FILE__, 'uninstall_category_displayer' );

	}
endif;

/**
 * The code that runs during plugin deactivation.
 */
if (!function_exists('deactivate_category_displayer')):
	function deactivate_category_displayer() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-displayer-deactivator.php';
		Category_Displayer_Deactivator::deactivate();
	}
endif;
/**
 * The code that runs during plugin uninstall.
 */
if (!function_exists('uninstall_category_displayer')):
	function uninstall_category_displayer() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-category-displayer-uninstall.php';
		Category_Displayer_Uninstall::uninstall();
	}
endif;

register_activation_hook( __FILE__, 'activate_category_displayer' );
register_deactivation_hook( __FILE__, 'deactivate_category_displayer' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-category-displayer.php';

/**
 * Begins execution of the plugin
 */
if (!function_exists('run_category_displayer')):
	function run_category_displayer() {

		$plugin = new Category_Displayer();
		$plugin->run();
	}
endif;
run_category_displayer();