<?php

if ( ! defined( 'ABSPATH' ) ) exit; 

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Category_Displayer
 * @subpackage Category_Displayer/includes
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Category_Displayer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	protected $plugin_basename_file;
	protected $plugin_dir_path;
	protected $plugin_dir_url;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    /**
     * The plugin instance
     *
     * @since   1.0.0
     * @access  private
     * @var     self
     */
    private static $instance;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	    self::$instance = $this;

		if ( defined( 'CATEGORY_DISPLAYER_NAME' ) ) {
			$this->plugin_name = CATEGORY_DISPLAYER_NAME;
		} else {
			$this->plugin_name = 'category-displayer';
		}

		if ( defined( 'CATEGORY_DISPLAYER_VERSION' ) ) {
			$this->version = CATEGORY_DISPLAYER_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'category-displayer';

		if ( defined( 'CATEGORY_DISPLAYER_BASENAME_FILE' ) ) {
			$this->plugin_basename_file = CATEGORY_DISPLAYER_BASENAME_FILE;
		} else {
			$this->plugin_basename_file = 'category-displayer/category-displayer.php';
		}

		if ( defined( 'CATEGORY_DISPLAYER_DIR_PATH' ) ) {
			$this->plugin_dir_path = CATEGORY_DISPLAYER_DIR_PATH;
		}

		if ( defined( 'CATEGORY_DISPLAYER_DIR_URL' ) ) {
			$this->plugin_dir_url = CATEGORY_DISPLAYER_DIR_URL;
		}

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

    /**
     * Category_Displayer instance
     *
     * @since 1.0.0
     *
     * @return Category_Displayer
     */
    public static function instance() {
        return self::$instance;
    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Category_Displayer_Loader. Orchestrates the hooks of the plugin.
	 * - Category_Displayer_i18n. Defines internationalization functionality.
	 * - Category_Displayer_Admin. Defines all hooks for the admin area.
	 * - Category_Displayer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-category-displayer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-category-displayer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-category-displayer-list-tables.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-category-displayer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-category-displayer-public.php';

		$this->loader = new Category_Displayer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Category_Displayer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Category_Displayer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		global $plugin_admin;
		$plugin_admin = new Category_Displayer_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_dir_path() , $this->get_plugin_dir_url());

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/* Add Custom buttons on plugins list page -> "Settings", "Go Pro" , etc */
		$this->loader->add_filter( 'plugin_action_links_'.$this->plugin_basename_file, $plugin_admin, 'plugin_action_links', 10, 1 );
		/* Add custom menu pages */
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'plugin_admin_page' );

		/* Add admin notive */
		$this->loader->add_action('admin_notices', $plugin_admin, 'general_admin_notice');
		/* Dismiss admin notive */
		$this->loader->add_action('wp_ajax_dismiss_pro_notice', $plugin_admin, 'dismiss_pro_notice');

		/* Add class to "Upgrade to Premium menu item */
		$this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu_edit_item' );

		/* Skip non-valid css attributes */
		$this->loader->add_filter('catdisp_non_valid_attributes', $plugin_admin, 'catdisp_non_valid_attributes_callback', 10, 1);
		/* Process attributes */
		$this->loader->add_filter('catdisp_construct_hierarchical_settings',$plugin_admin, 'catdisp_construct_hierarchical_settings_callback', 10, 2);

		$this->loader->add_filter('style_loader_tag', $plugin_admin, 'style_loader_tag_function');


		/* Register AJAX request in wp-admin -> Save general settings */
		$this->loader->add_action('wp_ajax_catdisp_save_general_settings', $plugin_admin, 'catdisp_save_general_settings');
		/* Register AJAX request in wp-admin -> SaveRemove files on delete */
		$this->loader->add_action('wp_ajax_catdisp_removefiles_ondelete', $plugin_admin, 'catdisp_removefiles_ondelete');

		$this->loader->add_action('catdisp_unavailable_template', $plugin_admin, 'catdisp_unavailable_template_callback');


		/* List Tables validate template */
		add_filter('catdisp_listtable_allow_template', array($plugin_admin, 'catdisp_listtable_allow_template_callback') );
		add_filter('catdisp_listtable_template_not_allowed', array($plugin_admin, 'catdisp_listtable_template_not_allowed_callback') );

		/* List Tables validate taxonomy */
		add_filter('catdisp_listtable_allow_taxonomy', array($plugin_admin, 'catdisp_listtable_allow_taxonomy_callback') );
		add_filter('catdisp_listtable_taxonomy_not_allowed', array($plugin_admin, 'catdisp_listtable_taxonomy_not_allowed_callback') );

		/* Edit taxonomy validate taxonomy */
		add_filter('catdisp_edit_allow_taxonomy', array($plugin_admin, 'catdisp_listtable_allow_taxonomy_callback') );
		add_filter('catdisp_edit_taxonomy_not_allowed', array($plugin_admin, 'catdisp_edit_taxonomy_not_allowed_callback') );
		
		/* Edit template validate taxonomy */
		add_filter('catdisp_edit_allow_template', array($plugin_admin, 'catdisp_listtable_allow_template_callback') );
		add_filter('catdisp_edit_template_not_allowed', array($plugin_admin, 'catdisp_edit_template_not_allowed_callback') );

		/* Add image field to taxonomy fields */
		if(is_admin() && isset($_GET['taxonomy']) && $_GET['taxonomy']!=''){
			$this->loader->add_action('admin_init', $plugin_admin, 'catdisp_admin_footer_allowed_taxonomies', 10);
		}

		/* Register AJAX request in wp-admin -> Add shortcode */
		$this->loader->add_action('wp_ajax_taxonomy_selection', $plugin_admin,   'taxonomy_selection');
		$this->loader->add_action('wp_ajax_categories_selection', $plugin_admin, 'categories_selection');

		/* Initialize Upload image JSON settings box / Initialize icon selection in settings box / Display single image field*/
		$this->loader->add_action('wp_ajax_categdisp_image_selection', $plugin_admin, 'categdisp_image_selection');
		$this->loader->add_action('wp_ajax_categdisp_icon_selection', $plugin_admin, 'categdisp_icon_selection');
		$this->loader->add_action('wp_ajax_categdisp_display_single_image', $plugin_admin, 'categdisp_display_single_image');
		$this->loader->add_action('wp_ajax_categdisp_populate_list_category', $plugin_admin, 'categdisp_populate_list_category');

		/* Submit feedback */
		$this->loader->add_action('wp_ajax_catdisp_submit_feedback', $plugin_admin, 'catdisp_submit_feedback');



		/* CRUD shortcodes */
		/* Register AJAX request in wp-admin -> Add shortcode */
		$this->loader->add_action('wp_ajax_add_shortcode', $plugin_admin, 'add_shortcode');
		/* Register AJAX request in wp-admin -> EDIT shortcode */
		$this->loader->add_action('wp_ajax_edit_shortcode', $plugin_admin, 'edit_shortcode');
		/* Register AJAX request in wp-admin -> DELETE shortcode */
		$this->loader->add_action('wp_ajax_delete_shortcode', $plugin_admin, 'delete_shortcode');
		/* Register AJAX request in wp-admin -> DUPLICATE shortcode */
		$this->loader->add_action('wp_ajax_duplicate_shortcode', $plugin_admin, 'duplicate_shortcode');

        /* Register AJAX request in wp-admin -> PREVIEW shortcode */
		$this->loader->add_action('wp_ajax_preview_shortcode', $plugin_admin, 'preview_shortcode');

		/* Register AJAX request in wp-admin */
		$this->loader->add_action('wp_ajax_categdisp_load_element', $plugin_admin, 'categdisp_load_element');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		global $plugin_public;
		$plugin_public = new Category_Displayer_Public( $this->get_plugin_name(), $this->get_version(),  $this->get_plugin_dir_path() , $this->get_plugin_dir_url());

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		/* Validate template */
		add_filter('catdisp_shortcode_allow_template', array($plugin_public, 'catdisp_shortcode_allow_template_callback'), 10, 1);
		add_action('catdisp_shortcode_template_not_allowed', array($plugin_public, 'catdisp_shortcode_template_not_allowed_callback') );
		
		/* Validate Taxonomy */
		add_filter('catdisp_shortcode_allow_taxonomy', array($plugin_public, 'catdisp_shortcode_allow_taxonomy_callback'), 10, 1);
		add_action('catdisp_shortcode_taxonomy_not_allowed',  array($plugin_public, 'catdisp_shortcode_taxonomy_not_allowed_callback'), 10, 1 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}




	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Category_Displayer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the dir path of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The dir path of the plugin.
	 */
	public function get_plugin_dir_path() {
		return $this->plugin_dir_path;
	}

	/**
	 * Retrieve the dir url of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The dir url of the plugin.
	 */

	public function get_plugin_dir_url() {
		return $this->plugin_dir_url;
	}

}



