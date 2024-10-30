<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$remove_on_uninstall = get_option('catdisp_removefiles_ondelete');
if($remove_on_uninstall=='true'){
	$delete_options = array('catdisp_general_settings','catdisp_general_pro_settings','catdisp_removefiles_ondelete','catdisp_templates','catdisp_templates_pro');

	// delete category image and icon from taxonomy.
	$terms = get_terms([
		'taxonomy' => get_taxonomies(),
		'hide_empty' => false,
	]);
	if($terms) {
		foreach($terms as $key => $value){
			$term_meta_img = get_term_meta($value->term_id,'categdisp_img_id', true);
			if($term_meta_img) {
				delete_metadata("term",$value->term_id,'categdisp_img_id');
			}
	
			$term_meta_icon = get_term_meta($value->term_id,'categdisp_icon', true);
			if($term_meta_icon) {
				delete_metadata("term",$value->term_id,'categdisp_icon');
			}
		}
	}

	foreach($delete_options as $option) {
		delete_option($option);
		// for site options in Multisite
		delete_site_option($option);
	}
	  
	// drop custom database tables
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}categs_shortcodes");
}
