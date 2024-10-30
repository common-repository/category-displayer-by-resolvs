<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #author-uri/to-be-set
 * @since      1.0.0
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Category_Displayer
 * @subpackage Category_Displayer/admin
 * @author     Resolvs, LLC <#>
 */
class Category_Displayer_Admin {

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

	public $shortcodes_obj;



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_dir_path, $plugin_dir_url ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_dir_path = $plugin_dir_path;
		$this->plugin_dir_url = $plugin_dir_url;

		$this->shortcodes_view = 'categs-shortcodes-view';
		$this->shortcodes_create = 'categs-shortcodes-create';
		$this->shortcodes_edit = 'categs-shortcodes-edit';
		$this->shortcodes_settings = 'categs-shortcodes-settings';
		$this->admin_location = plugin_dir_url( __FILE__ );

		$this->pro_version = 'https://wpcategorydisplayer.com/pricing/';

		if(isset($_POST['taxonomy']) && $_POST['taxonomy']){
			$tax = sanitize_text_field($_POST['taxonomy']);
			add_action('edited_'.$tax, array($this, 'updated_category_custom_fields'), 10, 2);
			add_action( 'created_'.$tax, array($this, 'save_category_custom_fields'), 10, 2);
		}
	}
	 
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'lightbox', plugin_dir_url( __FILE__ ) . 'css/lightbox.min.css', array(),  'all' );

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/category-displayer-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/category-displayer-admin.css', array(),  $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'font-awesome-icon-picker-css', plugin_dir_url( __FILE__ ) . 'css/fontawesome-iconpicker.css', false, $this->version, false );
		wp_enqueue_style( 'font-awesome-css', plugin_dir_url( __FILE__ ) . 'css/fontawesome.min.css', false, $this->version, false );

		wp_enqueue_script( 'font-awesome-icon-picker-js', plugin_dir_url( __FILE__ ) . 'js/fontawesome-iconpicker.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script('categs-shortcodes-general', plugin_dir_url( __FILE__ ) . 'js/categs-shortcodes-general.js', array( 'jquery' ), $this->version, false );
		wp_localize_script('categs-shortcodes-general', 'categ_disp_obj',
				array(
					'catdisp_nonce' =>  wp_create_nonce( 'catdisp_nonce' ),
				)
			);

		wp_enqueue_media();


		/* Create Shortcode Page */
		if(isset($_GET['page']) && ($_GET['page']== $this->shortcodes_create || $_GET['page']== $this->shortcodes_view) ){
			wp_enqueue_style( 'wp-color-picker' );
			did_action( 'init' ) && wp_localize_script(
				'wp-color-picker',
				'wpColorPickerL10n',
				array(
						'clear'            => __( 'Clear' ),
						'clearAriaLabel'   => __( 'Clear color' ),
						'defaultString'    => __( 'Default' ),
						'defaultAriaLabel' => __( 'Select default color' ),
						'pick'             => __( 'Select Color' ),
						'defaultLabel'     => __( 'Color value' ),
				)
		);

			wp_register_style( 'select2css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', false, $this->version, false );
			 wp_enqueue_style( 'select2css' );

			wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, true );
			 wp_enqueue_script( 'select2' );


			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script('jquery-ui-tabs');
			
			wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $this->version, true );

			wp_enqueue_script( 'lightbox', plugin_dir_url( __FILE__ ) . 'js/lightbox.min.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_style( 'font-awesome-css', plugin_dir_url( __FILE__ ) . 'css/fontawesome.min.css', false, $this->version, false );
			wp_enqueue_style( 'bootstrap-popup-preview', plugin_dir_url( __FILE__ ) . 'css/bootstrap-popup-preview.css',  $this->version, false );

			wp_enqueue_script( $this->shortcodes_create, plugin_dir_url( __FILE__ ) . 'js/categs-shortcodes-CRUD.js', array( 'jquery', 'wp-color-picker', 'jquery-ui-accordion', 'lightbox' ), $this->version, true );

			$preview_modal = '';
			$preview_modal .= '<div class="modal-show-template-library">';
			$preview_modal .= '<div class="clear"></div>';
			$preview_modal .= '<div id="shortcode-preview"></div>';
			$preview_modal .= '<a href="#" id="TB_closeWindowButton" title="Close" class="close-shortcode-preview">Close</a>';

			$preview_modal .= '</div>';

			$resources_dir_url = '';
			if(defined('CATEGORY_DISPLAYER_PRO_DIR_PATH')){
				$resources_dir_url = CATEGORY_DISPLAYER_PRO_DIR_URL;
			}
			
			// check enable-googlefonts enable
			$general_settings = get_option('catdisp_general_settings');
			$enable_googlefonts = '';
			if(isset($general_settings['enable-googlefonts']) && $general_settings['enable-googlefonts']){
				$enable_googlefonts = $general_settings['enable-googlefonts'];
			}
			
			wp_localize_script( $this->shortcodes_create, 'categ_disp_obj',
				array(
					'tpl_conf_location' => $this->admin_location,
					'catdisp_listtable_nonce' =>  wp_create_nonce( 'catdisp_listtable_nonce' ),
					'preview_modal' => $preview_modal,
					'catdisp_pro_dir_path' => $resources_dir_url,
					'catdisp_dir_path' => CATEGORY_DISPLAYER_DIR_URL,
					'categdisp_load_element' =>  wp_create_nonce( 'categdisp_load_element' ),
					'enable_googlefonts' => $enable_googlefonts
				)
			);

		}
	}

	public function style_loader_tag_function($tag){
			// echo $tag;die($tag);
			// return $tag;
			return preg_replace("/='stylesheet' id='bootstrap-less-css'/", "='stylesheet/less' id='bootstrap-less-css'", $tag);
	}

	/**
	 * Register the Plugin's custom links for the admin plugins area.
	 *
	 * @since    1.0.0
	 */
	public function plugin_action_links( $links ){
		$links['settings'] =  '<a href="admin.php?page='.$this->shortcodes_settings.'">'. __('Settings', $this->plugin_name) .'</a>';
		return $links;
	}

	/**
	 * Register the Plugin's admin notice
	 *
	 * @since    1.0.0
	 */
	public function general_admin_notice(){
	    if (!$this->should_show_pro_banners()) {
	        return;
        }

		global $pagenow;

		if ( $pagenow == 'admin.php' && isset($_GET['page']) && strpos($_GET['page'], 'categs-shortcodes') !== false ) {
			 echo '<div class="notice notice-large go-pro-notice grey-box-shadow" id="categs_notice_go_pro">
				 <p>Enjoying using the <b>category displayer</b>? <b>PRO</b> ONLY $29</p>
			 </div>';
		}
	}

	public function catdisp_default_installed_templates(){
		return array('simple-card-view','icon-card-view','image-card-view');
	}
	public function catdisp_allow_taxonomies(){
		$args = array(
			'public'   => true,
			'show_ui' => '1',
			'object_type' => ['post'],
		);
		/* Filter will decide if all taxonomies are allowed */
		$args = apply_filters('catdisp_filter_taxonomies_arguments', $args);
		$get_taxonomies = get_taxonomies($args, 'objects');
		$allowed_taxonomies = array_keys($get_taxonomies);
		return $allowed_taxonomies;
	}

	public function catdisp_unavailable_template_callback(){
		_e( 'This template requires an active license!', $this->plugin_name );
	}

	public function catdisp_save_general_settings(){
		$security = filter_input(INPUT_POST, 'security', FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_nonce")) {
			exit("No script kiddies please!");
		}

		do_action('catdisp_save_settings');

		$settings = array();
		if(isset($_POST['enable-googlefonts']) && !empty($_POST['enable-googlefonts']) ){
			$settings['enable-googlefonts'] = filter_input(INPUT_POST, 'enable-googlefonts', FILTER_SANITIZE_SPECIAL_CHARS);
		}
		if(isset($_POST['enable-bootstrap']) && !empty($_POST['enable-bootstrap']) ){
			$settings['enable-bootstrap'] = filter_input(INPUT_POST, 'enable-bootstrap', FILTER_SANITIZE_SPECIAL_CHARS);
		}

		$general_settings = get_option('catdisp_general_settings');
		if(!empty($settings)){
			if(isset($general_settings) && !empty($general_settings)){
				update_option('catdisp_general_settings',$settings);
			}
			else{
				add_option('catdisp_general_settings', $settings);
			}
		}
		else{
			delete_option('catdisp_general_settings');
		}
		

		wp_die();
	}

	public function catdisp_removefiles_ondelete(){
		$security = filter_input(INPUT_POST, 'security', FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_nonce")) {
			exit("No script kiddies please!");
		}
		$delete = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_SPECIAL_CHARS);
		$delete = sanitize_text_field($delete);
		if($delete=='true'){
			update_option('catdisp_removefiles_ondelete', $delete);
		}
		else{
			delete_option('catdisp_removefiles_ondelete');
		}
		wp_die();
	}


	/**
	 * Register the Plugin's custom settings page from admin area.
	 *
	 * @since    1.0.0
	 */
	public function plugin_admin_page(){
		/* ADD Main menu page */
		$hook = add_menu_page( __( 'Category Displayer', $this->plugin_name ), __( 'Category Disp.', $this->plugin_name ), 'manage_options', $this->shortcodes_view, array( $this, 'shortcodes_view' ), 'dashicons-screenoptions', 80  );

		add_action( "load-$hook", [ $this, 'screen_option' ] );

		/* ADD Sub-menu pages */
		add_submenu_page( $this->shortcodes_view, __( 'View shortcodes', $this->plugin_name ), __( 'View shortcodes', $this->plugin_name ), 'manage_options', $this->shortcodes_view);
		add_submenu_page( $this->shortcodes_view, __( 'Create shortcode', $this->plugin_name ), __( 'Create shortcode', $this->plugin_name ), 'manage_options', $this->shortcodes_create, array( $this, 'shortcodes_create' ));
		
		do_action('catdisp_add_menu_items', $this->shortcodes_view);
		
		add_submenu_page( $this->shortcodes_view, __( 'Settings', $this->plugin_name ), __( 'Settings', $this->plugin_name ), 'manage_options', $this->shortcodes_settings, array( $this, 'shortcodes_settings' ));
		// add_submenu_page( $this->shortcodes_view, __( 'Extensions', $this->plugin_name ), __( 'Extensions', $this->plugin_name ), 'manage_options', 'categs-shortcodes-extensions', array( $this, 'shortcodes_extensions' ));
		add_submenu_page( $this->shortcodes_view, __( 'Feedback', $this->plugin_name ), __( 'Feedback', $this->plugin_name ), 'manage_options', 'categs-shortcodes-feedback', array( $this, 'shortcodes_feedback' ));
		add_submenu_page( $this->shortcodes_view, __( 'Upgrade to Premium', $this->plugin_name ), __( 'Upgrade to Premium', $this->plugin_name ), 'manage_options', $this->pro_version);
	}

	/**
	 * Screen options
	 */
	public function screen_option() {
		$option = 'per_page';
		$args   = [
			'label'   => 'Shortcodes',
			'default' => 5,
			'option'  => 'shortcodes_per_page'
		];
		add_screen_option( $option, $args );
		$this->shortcodes_obj = new Category_Displayer_List();
	}

	public function shortcodes_view() {
		static $plugin_name, $version, $shortcodes_view, $shortcodes_create, $plugin_dir_url, $plugin_dir_path;
		$plugin_name = $this->plugin_name;
		$version = $this->version;
		$shortcodes_view = $this->shortcodes_view;
		$shortcodes_create = $this->shortcodes_create;
		$plugin_dir_url = $this->plugin_dir_url;
		$plugin_dir_path = $this->plugin_dir_path;

		include_once 'partials/shortcodes-view.php';
	}

	public function shortcodes_create() {
		static $plugin_name, $plugin_dir_url, $shortcodes_view;
		$plugin_name = $this->plugin_name;
		$plugin_dir_url = $this->plugin_dir_url;
		$shortcodes_view = $this->shortcodes_view;
		include_once 'partials/shortcodes-add-edit.php';
	}


	public function shortcodes_create_static() {
		static $plugin_name;
		$plugin_name = $this->plugin_name;
		include_once 'partials/shortcodes-create_static.php';
	}

	public function shortcodes_settings() {
		static $plugin_name, $pro_version;
		$plugin_name = $this->plugin_name;
		$pro_version = $this->pro_version;
		$should_show_pro_banner = $this->should_show_pro_banners();
		include_once 'partials/shortcodes-settings.php';
	}

	public function shortcodes_extensions() {
		static $plugin_name, $version, $admin_location;
		$plugin_name = $this->plugin_name;
		$version = $this->version;
		$admin_location = $this->admin_location;
		include_once 'partials/shortcodes-extensions.php';
	}

	public function shortcodes_feedback() {
		static $plugin_name;
		$plugin_name = $this->plugin_name;
		include_once 'partials/shortcodes-feedback.php';
	}

	public function catdisp_submit_feedback(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_nonce")) {
		 	exit("No script kiddies please!...");
		}
		$response = array();
		
		$to = 'woman.inthebox89@gmail.com';
		$subject = sanitize_text_field($_POST['fdb_title']);
		$body = sanitize_text_field($_POST['fdb_desc']);
		$headers = array('Content-Type: text/html; charset=UTF-8');
		
		$sent = wp_mail( $to, $subject, $body, $headers );
		if($sent){
// 			echo 'sent';
			$response['msg'] = __('Feedback email sent!', $this->plugin_name);
		}
		else{
			$response['error'] = __('Could not sent email! Please send a ticket directly to ', $this->plugin_name).$to;
		}
		wp_send_json($response);
		wp_die();
	}

	public function admin_menu_edit_item()
    {
        global $submenu;
        if ($this->should_show_pro_banners()) {
            $submenu['categs-shortcodes-view'][count($submenu['categs-shortcodes-view']) - 1][0] = '<span class="categs_disp_upgrade">' . $submenu['categs-shortcodes-view'][count($submenu['categs-shortcodes-view']) - 1][0] . '</span>';
        } else {
            array_pop($submenu['categs-shortcodes-view']);
        }
	}


	/* Template allowed */
		public function catdisp_listtable_allow_template_callback($tpl_id){
			$default_installed = $this->catdisp_default_installed_templates();
			if(!in_array($tpl_id, $default_installed)){
				return false;
			}
			return true;
		}

		public function catdisp_listtable_template_not_allowed_callback(){
			if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
				$response = '<small class="text-red">'.__('Requires PRO version!',$this->plugin_name).'</small>';
			}
			elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
				$response = '<small class="text-red">'.__('Requires an active license!', $this->plugin_name).'</small>';
			}
			return $response;
		}

	/* END Template NOT allowed */

	/* Taxonomy NOT allowed */
		public function catdisp_listtable_allow_taxonomy_callback($tax){
			$catdisp_allow_taxonomies = $this->catdisp_allow_taxonomies();
			if(!in_array($tax, $catdisp_allow_taxonomies)){
				return false;
			}
			return true;
		}

		public function catdisp_listtable_taxonomy_not_allowed_callback(){
			if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
				$response = '<small class="text-red">' .__('Requires PRO version!',$this->plugin_name).'</small>';
			}
			elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
				$response = '<small class="text-red">'.__('Requires an active license!', $this->plugin_name).'</small>';
			}
			return $response;
		}
	/*END Taxonomy NOT allowed */


	/* Edit shortcode Taxonomy not allowed callback */
	public function catdisp_edit_taxonomy_not_allowed_callback(){
		if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
			$response = __('taxonomy requires PRO version!', $this->plugin_name);
		}
		elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
			$response = __('taxonomy requires an active license!', $this->plugin_name);
		}
		return $response;
	}
	
	public function catdisp_edit_template_not_allowed_callback(){
		if(!defined('CATEGORY_DISPLAYER_PRO_VERSION')){
			$response = __('template requires PRO version!', $this->plugin_name);
		}
		elseif(!defined('CATEGORY_DISPLAYER_ACTIVE_LICENSE')){
			$response = __('template requires an active license!', $this->plugin_name);
		}
		return $response;
	}

	public function catdisp_filter_check_allow_taxonomy_callback($tax){
		$args = array(
			'public'   => true,
			'show_ui' => '1',
			'object_type' => ['post'],
		);
		/* Filter will decide if all taxonomies are allowed */
		$args = apply_filters('catdisp_filter_taxonomies_arguments', $args);
		$get_taxonomies = get_taxonomies($args, 'objects');
		$allowed_taxonomies = array_keys($get_taxonomies);
		if(!in_array($tax, $allowed_taxonomies)){
			if(defined('CATEGORY_DISPLAYER_PRO_VERSION')){
				return $tax.' <small class="text-red">'.__('Activate license!', $this->plugin_name).'</small>';
			}
			else{
				return $tax.' <small class="text-red">'.__('Taxonomy unavailable', $this->plugin_name).'</small>';
			}
		}
		return $tax;
	}

	public function catdisp_admin_footer_allowed_taxonomies(){
		$args = array(
			'public'   => true,
			'show_ui' => '1',
			'object_type' => ['post'],
		);
		/* Filter will decide if all taxonomies are allowed */
		$args = apply_filters('catdisp_filter_taxonomies_arguments', $args);
		
		$get_taxonomies = get_taxonomies($args, 'objects');
		$allowed_taxonomies = array_keys($get_taxonomies);
		// echo '<pre style="padding-left: 100px;">'.print_r($allowed_taxonomies,1).'</pre>';

		$tax = filter_input(INPUT_GET, 'taxonomy', FILTER_DEFAULT);
		$tax = sanitize_text_field($tax);
		if(in_array($tax, $allowed_taxonomies)){
			add_action( $tax.'_add_form_fields', array($this, 'add_category_custom_fields'), 10, 2);
			add_action( $tax.'_edit_form_fields',  array($this, 'update_category_custom_fields'), 10, 2);
		}
	}

	/* Create new term action - Add image/icon inputs*/
	public function add_category_custom_fields ( $taxonomy ) { ?>
		<div class="form-field term-catdisp_image">
			<label for="categdisp_img_id"><?php _e('Category Displayer Image', $this->plugin_name); ?></label>
			<input type="hidden" id="categdisp_img_id" name="categdisp_img_id" class="custom_media_url" value="">
			<div id="categdisp_image_wrapper">
			</div>

			<p>
				<input type="button" class="button button-secondary categdisp_tax_media_button" id="categdisp_tax_media_button" name="categdisp_tax_media_button" value="<?php _e( 'Add Image', $this->plugin_name ); ?>" />
				<input type="button"  style="display: none;" class="button button-secondary categdisp_tax_media_remove" id="categdisp_tax_media_remove" name="categdisp_tax_media_remove" value="<?php _e( 'Remove Image', $this->plugin_name ); ?>" />
			</p>
			<p><?php _e('Category Displayer default image', $this->plugin_name); ?></p>
		</div>

		<div class="form-field term-catdisp_icon">
			<label for="categdisp_icon"><?php _e('Category Displayer Icon', $this->plugin_name); ?></label>
			<div class="iconpicker-container">
				<input data-placement="bottomRight" autocomplete="off" class="form-control icp icp-auto w-100 icp-single_categs" placeholder="Choose an icon"  type="text"  name="categdisp_icon"/>
				<span class="input-group-addon"></span>
			</div>
			<p><?php _e('Category Displayer default icon', $this->plugin_name); ?></p>
		</div>

	  <?php
	}

	/* Save new term */
	public function save_category_custom_fields ( $term_id, $tt_id ) {
		$image = isset($_POST['categdisp_img_id']) ? sanitize_text_field($_POST['categdisp_img_id']) : '';
		$icon = isset($_POST['categdisp_icon']) ? sanitize_text_field($_POST['categdisp_icon']) : '';
		if($image){
			add_term_meta( $term_id, 'categdisp_img_id', $image, true );
		}
		if($icon){
			add_term_meta( $term_id, 'categdisp_icon', $icon, true );
		}
	}

	public function update_category_custom_fields ( $term, $taxonomy ) { ?>
		<tr class="form-field term-catdisp_image">
		  <th scope="row">
			<label for="categdisp_img_id"><?php _e( 'Category Displayer Image', $this->plugin_name); ?></label>
		  </th>
		  <td>
			<?php $image_id = get_term_meta ( $term->term_id, 'categdisp_img_id', true ); ?>
			<input type="hidden" id="categdisp_img_id" name="categdisp_img_id" value="<?php echo $image_id; ?>">
			<div id="categdisp_image_wrapper">
			  <?php if ( $image_id ) { ?>
				<?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
			  <?php } ?>
			</div>
			<p>
			  <input type="button" <?php if ( $image_id ) {echo 'style="display:none;"';}?> class="button button-secondary categdisp_tax_media_button" id="categdisp_tax_media_button" name="categdisp_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
			  <input type="button" <?php if ( !$image_id ) {echo 'style="display:none;"';}?> class="button button-secondary categdisp_tax_media_remove" id="categdisp_tax_media_remove" name="categdisp_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
			</p>
			<p class="description"><?php _e('Category Displayer default image', $this->plugin_name); ?></p>
		  </td>
		</tr>

		<tr class="form-field term-catdisp_icon">
		  <th scope="row">
			<label for="categdisp_icon"><?php _e( 'Category Displayer Icon', $this->plugin_name); ?></label>
		  </th>
		  <td>
		  	<?php $icon = get_term_meta ( $term->term_id, 'categdisp_icon', true ); ?>
				<div class="iconpicker-container">
					<input data-placement="bottomRight" value="<?php echo $icon;?>" autocomplete="off" class="form-control icp icp-auto w-100 icp-single_categs" placeholder="Choose an icon"  type="text"  name="categdisp_icon"/>
					<span class="input-group-addon"></span>
				</div>

			<p class="description"<?php _e('>Category Displayer default icon', $this->plugin_name); ?></p>
		  </td>
		</tr>


	  <?php
	  }


	public function updated_category_custom_fields ( $term_id, $tt_id ) {
		$image = isset($_POST['categdisp_img_id']) ? sanitize_text_field($_POST['categdisp_img_id']) : '';
		$categdisp_icon = isset($_POST['categdisp_icon']) ? sanitize_text_field($_POST['categdisp_icon']) : '';
		$is_image  = metadata_exists('term', $term_id, 'categdisp_img_id');
		$is_icon  = metadata_exists('term', $term_id, 'categdisp_icon');
		if($is_image || $image ){
			update_term_meta ( $term_id, 'categdisp_img_id', $image );
		}
		if($is_icon || $categdisp_icon){
			update_term_meta ( $term_id, 'categdisp_icon', $categdisp_icon);
		}
	}



	/* Add/Edit shortcode - Split taxonomy / choose category */
	public function categories_selection(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!2");
		}
		/* Type = Categories vs. Sub-categories */
		$type = filter_input(INPUT_POST, 'type');

		$taxonomy = filter_input(INPUT_POST, 'taxonomy');
		
		$type = sanitize_text_field($type);
		$taxonomy = sanitize_text_field($taxonomy);

		$settings = array(
			'type' => $type,
			'taxonomy' => $taxonomy
		);

		$dp_taxonomy = $this->hierarchical_dropdown_taxonomy($settings);

		echo $dp_taxonomy;
		wp_die();
	}

	public function hierarchical_dropdown_taxonomy($settings){
		if($settings['type']=='cat'){
			$args = array(
				'hierarchical' => 1,
				'parent' => 0,
				'hide_empty'=>0,
				'name'=>'select_categs[]',
				'id' => 'select_categs',
				'taxonomy' => $settings['taxonomy'],
				'echo' => 0
			);
			$select_categs = wp_dropdown_categories($args);
			$select_categs = preg_replace( '/<select(.*?)>/i', '<select$1 multiple="multiple">', $select_categs );
		}
		else{
			$args = array(
				'hierarchical' => 1,
				'hide_empty'=>0,
				'name'=>'select_categs[]',
				'id' => 'select_sub_categs',
				'taxonomy' => $settings['taxonomy'],
				'echo' => 0
			);
			$select_categs = wp_dropdown_categories($args);
			$select_categs = preg_replace( '/<select(.*?)>/i', '<select$1 multiple="multiple">', $select_categs );
			$select_categs = str_replace( 'class="level-0"', 'disabled="disabled"', $select_categs );
		}
		return $select_categs;

	}



	/* On term select -> show image/icon default/upload buttons  */
	public function categdisp_populate_list_category(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		}
		$term_id = filter_input(INPUT_POST, 'term_id',FILTER_SANITIZE_SPECIAL_CHARS);
		$taxonomy = filter_input(INPUT_POST, 'taxonomy',FILTER_SANITIZE_SPECIAL_CHARS);
		$response = '';
		$term = get_term( $term_id, $taxonomy );
		if($_POST['type']=='categ_imgs'){
			$response .=  '<li class="hidden" data-cat="'.$term_id.'">';
			$default_image = get_term_meta ( $term_id, 'categdisp_img_id', true );
			if($default_image){
				$default_image = wp_get_attachment_image_src($default_image, 'thumbnail');
				$response .= '<div class="catdisp-defaults_settings">';
				$response .= '<img src="'.$default_image[0].'" class="catdisp_default_img">';
				$response .= '<a href="#" class="categdisp-upl d-block" data-type="per-term"  data-term_id="'.$term_id.'" data-input_id="categ_imgs">Overwrite default image</a>';
				$response .= '<a href="#" class="categdisp-rmv" style="display:none;" data-term_id="'.$term_id.'" data-input_id="categ_imgs" data-upl_txt="'. __('Overwrite default image',$this->plugin_name).'">Remove image</a>';
				$response .= '</div>';
			}
			else{
				$response .= '<a href="#" class="categdisp-upl" data-term_id="'. $term_id .'" data-input_id="categ_imgs">'.__('Upload image',$this->plugin_name).'</a>';
				$response .= '<a href="#" class="categdisp-rmv" data-term_id="'. $term_id .'" data-input_id="categ_imgs" style="display: none;">'.__('Remove image',$this->plugin_name).'</a>';
			}
			$response .='<li>';
		}
		elseif($_POST['type']=='categ_icons'){
			$response .=  '<li class="hidden" data-cat="'.$term_id.'">';
			$default_icon = get_term_meta( $term_id, 'categdisp_icon', true );
			if(isset($default_icon) && $default_icon!=''){
				$response .= '<p class="mt-0">'.__('Default Icon', $this->plugin_name).': <i class="'.$default_icon.'"></i></p>';
			}

			$response .= '<div class="iconpicker-container">';
				$response .= '<input data-placement="bottomRight" autocomplete="off" class="form-control icp icp-auto w-100 icp-categs" ';
					$response .= 'placeholder="'.__('Choose an icon',$this->plugin_name).'" type="text" ';
					$response .= 'name="categdisp-icon-'.$term_id.'"/>';
				$response .= '<span class="input-group-addon"></span>';
			$response .= '</div>';
			$response .= '</li>';
		}
		echo $response;
		wp_die();
	}
	
	/* Ajax request for add images per category */
	public function categdisp_image_selection(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		}
		$cat_img = sanitize_text_field($_POST['categ_imgs']);
		$select_categs  = $this->sanitize_array($_POST['select_categs']);
		$taxonomy = sanitize_text_field($_POST['taxonomy']);
		$categ_imgs = json_decode(stripslashes($cat_img), true);
		?>
			<div class="flex-row">
				<div class="flex-column flex-basis-0 flex-grow-1">

					<ul class="list_category_names my-0" data-show="list_category_images">
						<?php
						$images_html = '';
						$empty_cat_list = false;
						if(isset($select_categs) && !empty($select_categs)){
							foreach($select_categs as $selected_cat){
								$term = get_term( $selected_cat, $taxonomy );
								echo '<li><a class="cursor-pointer" data-cat="'.$selected_cat.'">'.$term->name.'</a></li>';
								$images_html .= '<li class="hidden" data-cat="'.$selected_cat.'">';


								if(!empty($categ_imgs) && array_key_exists($selected_cat, $categ_imgs)){
									$attachment_info = wp_get_attachment_image_src($categ_imgs[$selected_cat], 'thumbnail');
									$images_html .= '<div class="catdisp-overwrite_settings">';
									$images_html .= '<a href="#" class="categdisp-upl" data-type="per-shortcode" data-term_id="'.$selected_cat.'" data-input_id="categ_imgs">';
									$images_html .= '<img src="'.$attachment_info[0].'">';
									$images_html .= '</a>';
									$images_html .= '<a href="#" class="categdisp-rmv" 
																data-term_id="'.$selected_cat.'" 
																data-input_id="categ_imgs" 
																data-upl_txt="'. __('Upload image',$this->plugin_name).'"
																data-type="per-shortcode"
																">Remove image</a>';
									$images_html .=' </div>';
								} else {
									/* Check if category already has an image */
									$default_image = get_term_meta ( $selected_cat, 'categdisp_img_id', true );
									if($default_image){
										$default_image = wp_get_attachment_image_src($default_image, 'thumbnail');
										$images_html .= '<div class="catdisp-defaults_settings">';
										$images_html .= '<img src="'.$default_image[0].'" class="catdisp_default_img">';
										$images_html .= '<a href="#" class="categdisp-upl d-block" data-type="per-term"  data-term_id="'.$selected_cat.'" data-input_id="categ_imgs">Overwrite default image</a>';
										$images_html .= '<a href="#" class="categdisp-rmv" style="display:none;" 
																	data-term_id="'.$selected_cat.'" 
																	data-input_id="categ_imgs"
																	data-upl_txt="'. __('Overwrite default image',$this->plugin_name).'"
																	>Remove image</a>';
										$images_html .= '</div>';
									}
									else{
										$images_html .= '<a href="#" class="categdisp-upl" data-term_id="'. $selected_cat .'" data-input_id="categ_imgs">'.__('Upload image',$this->plugin_name).'</a>';
										$images_html .= '<a href="#" class="categdisp-rmv" data-term_id="'. $selected_cat .'" data-input_id="categ_imgs" style="display: none;">'.__('Remove image',$this->plugin_name).'</a>';

									}	
								}
								

								$images_html .= '</li>';

							}
						}
						else{
							$empty_cat_list = true;
						}
						?>
					</ul>
					<?php
					if($empty_cat_list){
						echo '<p class="mt-0 text-grey empty_cat_list">Select categories first</p>';
					} ?>
				</div>

				<div class="flex-column flex-basis-0 flex-grow-1">
					<ul class="list_category_images my-0">
						<?php echo $images_html; ?>
					</ul>
				</div>
			</div>
		<?php

    	wp_die();
	}

	/* Ajax request for add icons per category */
	public function categdisp_icon_selection(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		} 
		
		$categ_icons = json_decode(stripslashes(sanitize_text_field($_POST['categ_icons'])), true);
		
		$taxonomy = sanitize_text_field($_POST['taxonomy']);

		$select_categs  = $this->sanitize_array($_POST['select_categs']);

		 ?>
			<div class="flex-row">
				<div class="flex-column flex-basis-0 flex-grow-1">
					<ul class="list_category_names my-0" data-show="list_category_icons">
						<?php
						$icons_html = '';
						$empty_cat_list = false;
						if(isset($select_categs) && !empty($select_categs)){
							
							foreach($select_categs as $selected_cat){
								$term = get_term( $selected_cat, $taxonomy );
								$term_icon = get_term_meta($selected_cat,'categdisp_icon',true);
								if($term_icon != ''){
									$placeholder =  __('Overwrite icon',$this->plugin_name);
								}
								else{
									$placeholder = __('Choose an icon',$this->plugin_name);
								}
								echo '<li><a class="cursor-pointer" data-cat="'.$selected_cat.'" test="'.$term_icon.'">'.$term->name.'</a></li>';

								$icons_html .= '<li class="hidden" data-cat="'.$selected_cat.'">';
								if(!isset($categ_icons[$selected_cat]) && $term_icon != ''){
									$icons_html .= '<p>'.__('Default Icon', $this->plugin_name).': <i class="'.$term_icon.'"></i></p>';
								}
								$icons_html .= '<div class="iconpicker-container">';
									$icons_html .= '<input data-placement="bottomRight" autocomplete="off" class="form-control icp icp-auto w-100 icp-categs" ';
										$icons_html .= 'placeholder="'.$placeholder.'" value="'.$categ_icons[$selected_cat].'" type="text" ';
										$icons_html .= 'name="categdisp-icon-'.$selected_cat.'"/>';
									$icons_html .= '<span class="input-group-addon"></span>';
								$icons_html .= '</div>';
								$icons_html .= '</li>';
							}
						}
						else{
							$empty_cat_list = true;
						}

						?>
					</ul>
					<?php
					if($empty_cat_list){
						echo '<p class="mt-0 text-grey empty_cat_list">Select categories first</p>';
					}
					?>
				</div>

				<div class="flex-column flex-basis-0 flex-grow-1">
					<ul class="list_category_icons my-0">
						<?php echo $icons_html; ?>
					</ul>
				</div>
			</div>
		<?php

		wp_die();
	}


	/* Ajax request for single image display */
	public function categdisp_display_single_image(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		}
		$response = array();
		$attachment_info = wp_get_attachment_image_src(sanitize_text_field($_POST['media_id']), 'thumbnail');
		$reponse['url'] = $attachment_info[0];

		wp_send_json($reponse);
		wp_die();
	}

	public function remove_empty_values($val){
		return ($val!=='');
	}

	/* Ajax Call -> On "Save Settings" shortcode wp-admin/admin.php?page=categs-shortcodes-create */
	public function add_shortcode(){
		$security = filter_input(INPUT_POST, 'catdisp_security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		 }
		$response = array();
		global $wpdb;
		$settings = $_POST['rscdForm'];

		//unset($settings['title']);
		unset($settings['action']);
		//unset($settings['security']);
		//unset($settings['tpl_id']);
		//unset($settings['shortcode_id']);
		unset($settings['catdisp_security']);
		unset($settings['layout_boxes']);
		unset($settings['saved_settings']);

		$select_categs = $this->sanitize_array($_POST["select_categs"]);
		$settings = $this->sanitize_array($settings);
		$settings['select_categs'] = $select_categs;
		
		$settings = array_filter($settings,function($val){
			return ($val!=='');
		});

		$insert = $wpdb->insert(
			$wpdb->prefix.'categs_shortcodes',
			array(
				'date' => date("Y-m-d H:i:s"),
				'title' => sanitize_text_field( $settings['title'] ),
				'settings' => serialize($settings),
				'tpl_id' => sanitize_text_field( $settings['tpl_id'] ),
			)
		);

		if($wpdb->last_error !== ''){
			$response['error'] = '<p class="error text-red">'. $wpdb->last_error. '</p>';
		}
		else{
			$response['last_ins_id'] = $wpdb->insert_id;
		}
		wp_send_json($response);
		wp_die();
	}

	/* Ajax Call -> On "Save Settings" shortcode wp-admin/admin.php?page=categs-shortcodes-view&action=edit&ID=X */
	public function edit_shortcode(){
		$security = filter_input(INPUT_POST, 'catdisp_security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
		 	exit("No script kiddies please!");
		 }
		$response = array();
		global $wpdb;
		$settings = $_POST['rscdForm'];
		
		//unset($settings['title']);
		unset($settings['action']);
		//unset($settings['security']);
		unset($settings['layout_boxes']);
		unset($settings['saved_settings']);
		//unset($settings['tpl_id']);
		//unset($settings['shortcode_id']);
		unset($settings['catdisp_security']);

		$select_categs = $this->sanitize_array($_POST["select_categs"]);
		$settings = $this->sanitize_array($settings);
		$settings['select_categs'] = $select_categs;
		
		$settings = array_filter($settings,function($val){
			return ($val!=='');
		});

		$update = $wpdb->update(
			$wpdb->prefix.'categs_shortcodes',
			array(
				'title' => sanitize_text_field( $settings['title']),
				'settings' => serialize($settings) ,
				'tpl_id' => sanitize_text_field( $settings['tpl_id'] ),
			),
			array( 'ID' => sanitize_text_field($settings['shortcode_id'])),
			array(
				'%s',
				'%s',
				'%s'
			),
			array( '%d' )
		);
		if($wpdb->last_error !== ''){
			$response['error'] = '<p class="error text-red">'. $wpdb->last_error. '</p>';
		}
		else{
			$response['msg'] = $update;
		}
		wp_send_json($response);
		wp_die();
	}

	/* Ajax Call -> On "Delete" shortcode from WP List table*/
	public function delete_shortcode(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_listtable_nonce")) {
		 	exit("No script kiddies please!");
		}
		global $wpdb;
		$response = array();
		// $settings = $_POST['rscdForm'];

		$delete = $wpdb->delete(
			$wpdb->prefix.'categs_shortcodes',
			/* array(
				'ID' =>  filter_input(INPUT_POST, 'shortcode_id', FILTER_SANITIZE_SPECIAL_CHARS)
			), */
			array( 'ID' => sanitize_text_field($_POST['shortcode_id'])),
			array( '%d' )
		);
		if($wpdb->last_error !== ''){
			$response['error'] = '<p class="error text-red">'. $wpdb->last_error. '</p>';
		}
		else{
			$response['msg'] = $delete;
		}
		wp_send_json($response);
		wp_die();
	}

	/* Ajax Call -> On "Duplicate" shortcode from WP List table*/
	public function duplicate_shortcode(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
		if ( !wp_verify_nonce( $security, "catdisp_listtable_nonce")) {
		 	exit("No script kiddies please!");
		}
		global $wpdb;
		$response = array();
		$shortcodeId = filter_input(INPUT_POST, 'shortcode_id', FILTER_SANITIZE_SPECIAL_CHARS);
		$shortcodeId = sanitize_text_field($shortcodeId);

		$get_shortcode = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}categs_shortcodes WHERE ID = %d", $shortcodeId ), OBJECT );		 

		if(!empty($get_shortcode)){
			$insert = $wpdb->insert(
				$wpdb->prefix.'categs_shortcodes',
				array(
					'date' => date("Y-m-d H:i:s"),
					'title' => sanitize_text_field( $get_shortcode->title .' Copy' ),
					'settings' => $get_shortcode->settings,
					'tpl_id' => $get_shortcode->tpl_id,
				)
			);
			if($wpdb->last_error !== ''){
				$response['error'] = '<p class="error text-red">'. $wpdb->last_error. '</p>';
			}
			else{
				$response['last_ins_id'] = $wpdb->insert_id;
				$response['title'] = $get_shortcode->title .' Copy';
				$response['edit_url'] = '?page='.$this->shortcodes_view.'&action=edit&ID='.$wpdb->insert_id;
			}
		}
		else{
			$reponse['error'] = __('Shortcode not found', $this->plugin_name);
		}

		wp_send_json($response);
		wp_die();
	}

	/* Ajax Call -> On "Preview" shortcode add/edit shortcode page */
    public function preview_shortcode(){
        $security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
        if ( !wp_verify_nonce( $security, "catdisp_save_nonce")) {
            exit("No script kiddies please!");
		}
		
        $settings           = array();
        //$setting            = $_POST;
        $formated_settings  = array();
        $categs             = array();

		parse_str($_POST['settings'], $formated_settings);

		$formated_settings = $formated_settings['rscdForm'];

        if(!$formated_settings['tpl_id']){
            return;
        }

        $template_id = $formated_settings['tpl_id'];
        

        ob_start();

		/* Define resourses url */
		$tpl_type = filter_input(INPUT_POST, 'tpl_type', FILTER_SANITIZE_SPECIAL_CHARS);
		if($tpl_type == 'free'){
			$resources_dir_path = $this->plugin_dir_path;
		}
		elseif(defined('CATEGORY_DISPLAYER_PRO_DIR_PATH')){
			$resources_dir_path = CATEGORY_DISPLAYER_PRO_DIR_PATH;
		}
		require_once($resources_dir_path.'templates/'.$template_id.'/category-displayer.php');

		$settings = $this->prepare_css($formated_settings);

		$settings['popup_id'] = '#shortcode-preview';

        if($settings){
			if($settings['elements'] || $settings['hover']){
				require_once($this->plugin_dir_path.'public/css/shortcode-css.php');
			}
            require_once($resources_dir_path.'templates/'.$template_id.'/output.php');
        }
        ob_end_flush();

        wp_die();
	}

	/*
	* IF any other attribute needs fo be skipped use -> add_filter('catdisp_non_valid_attributes', 'custom_hook_callback',11, 1);
	*/
	public function catdisp_non_valid_attributes_callback($skip_attributes){
		return $skip_attributes;
	}



	public function prepare_css($settings){
		$elements = array();
		$media_query = array();
		$google_font = '';

		/* Some of the input names are not actual css attributes but helpers in order to compose other css attributes, valid */

		$skip_attributes = array(
			'border-type','border-link','border-width',
			'background-gradient-start','background-gradient-end','gradient','gradient-direction','gradient-start-pos','gradient-end-pos','gradient-above-img',
			'shadow-style','shadow-position','horizontal-position','vertical-position','blur-strength','spread-strength','shadow-color',
			'responsive',
			'eq-col-height',
			'img-alignment',
			'custom-gutter-width','gutter-width'
		);

		$non_valid_atts = apply_filters('catdisp_non_valid_attributes', $skip_attributes);

		$settings = apply_filters('catdisp_construct_hierarchical_settings', $settings, $non_valid_atts);

		$settings['plugin_dir_url'] = $this->plugin_dir_url;
		return $settings ;

	}

	public function should_show_pro_banners() {
	    return apply_filters('catdisp_should_show_pro_banners', true);
    }

	public function catdisp_construct_hierarchical_settings_callback($settings, $non_valid_atts){
		foreach($settings as $key => $value){
			// echo '<br>'.$key;
			if($value==''){continue;}
			$processed_values = array();
            if(strpos ($key,'_' )!==false && strpos ($key,'_' )=='0'){
				$el_array       = explode('_', $key);

				$element = isset($el_array[1]) ? $el_array[1] : '';
				if($element=='categdisp-custom-css'){continue;}
				$hover = '';
				$normal_vs_hover = 'normal';
				if(strpos($key,'_hover')!==false){
					$hover = '_hover';
					$normal_vs_hover = 'hover';
				}

				$attribute  =  isset($el_array[2]) ? $el_array[2] : '';

				/* Special cases -> some attributes are not default css attributes and needed to be processed */

				do_action('catisp_process_css_atts');
				switch($attribute){
					case 'font-family':
						if (strpos($value,'##') !==false){
							$google_font = $value;

							$font_family_array= explode("##",$value);
							$value = $font_family_array[0];
						}
						break;
					case 'responsive':
						if($hover==''){
							$media_query[$el_array[3]][$element]['normal'][$el_array[4]] = $value;
						}
						else{
							$media_query[$el_array[3]][$element]['hover'][$el_array[4]] = $value;
						}
						break;

					case 'background-image':
						$img_url = wp_get_attachment_image_src($value, 'full');
						$value = "url(".$img_url[0].")";
						break;

					case 'border-type':
						$border_type = $value;
						if($border_type!='none' && $settings[ '_'.$el_array[1] .'_border-width'.$hover]!=''){
							$processed_values['border-style'] ='solid';
							switch($border_type){
								case 'all':
									$processed_values['border-width'] =  $settings[ '_'.$el_array[1] .'_border-width'.$hover];
									break;

								case 'top':
									$processed_values['border-width'] = $settings[ '_'.$el_array[1] .'_border-width'.$hover]. ' 0 0 0';
									break;

								case 'bottom':
									$processed_values['border-width'] =  '0 0 '.$settings[ '_'.$el_array[1] .'_border-width'.$hover];
									break;

								case 'left':
									$processed_values['border-width'] =  '0 0 0 '.$settings[ '_'.$el_array[1] .'_border-width'.$hover];
									break;

								case 'right':
									$processed_values['border-width'] = '0 '.$settings[ '_'.$el_array[1] .'_border-width'.$hover].' 0 0';
									break;

								default:
							}
						}
						else{
							$processed_values['border']='none';
						}
						break;

					case 'gradient':
						$gradient = $value;
						if($gradient!='0'){
							$background_gradient = '';
							if(isset($settings[ '_'.$el_array[1] .'_gradient'.$hover]) && $settings[ '_'.$el_array[1] .'_gradient'.$hover])
								$background_gradient .= $settings[ '_'.$el_array[1] .'_gradient'.$hover];
							$background_gradient .= '(';
								if(isset($settings[ '_'.$el_array[1] .'_gradient-direction'.$hover]) && $settings[ '_'.$el_array[1] .'_gradient-direction'.$hover]!=''){
									$background_gradient .= $settings[ '_'.$el_array[1] .'_gradient-direction'.$hover].', ';
								}
								if(isset($settings[ '_'.$el_array[1] .'_background-gradient-start'.$hover]) && $settings[ '_'.$el_array[1] .'_background-gradient-start'.$hover])
									$background_gradient .= ' '.$settings[ '_'.$el_array[1] .'_background-gradient-start'.$hover];
								
								if(isset($settings[ '_'.$el_array[1] .'_gradient-start-pos'.$hover]) && $settings[ '_'.$el_array[1] .'_gradient-start-pos'.$hover])
									$background_gradient .= ' '.$settings[ '_'.$el_array[1] .'_gradient-start-pos'.$hover];
								
								if(isset($settings[ '_'.$el_array[1] .'_background-gradient-end'.$hover]) && $settings[ '_'.$el_array[1] .'_background-gradient-end'.$hover])
									$background_gradient .= ', '.$settings[ '_'.$el_array[1] .'_background-gradient-end'.$hover];
								
								if(isset($settings[ '_'.$el_array[1] .'_gradient-end-pos'.$hover]) && $settings[ '_'.$el_array[1] .'_gradient-end-pos'.$hover])
									$background_gradient .= ' '.$settings[ '_'.$el_array[1] .'_gradient-end-pos'.$hover];
							$background_gradient .= ')';
							if(isset($settings[ '_'.$el_array[1] .'_gradient-above-img'.$hover]) && $settings[ '_'.$el_array[1] .'_gradient-above-img'.$hover] == '1'){
								$elements[$element][$normal_vs_hover]['position'] = 'relative';
								$elements[$element.":before"][$normal_vs_hover]['content'] = '" "';
								$elements[$element.":before"][$normal_vs_hover]['background-image'] =  $background_gradient;
								$elements[$element.":before"][$normal_vs_hover]['position'] = 'absolute';
								$elements[$element.":before"][$normal_vs_hover]['top'] = '0';
								$elements[$element.":before"][$normal_vs_hover]['left'] = '0';
								$elements[$element.":before"][$normal_vs_hover]['width'] = '100%';
								$elements[$element.":before"][$normal_vs_hover]['height'] = '100%';
								$elements[$element.":before"][$normal_vs_hover]['display'] = 'block';
								continue;
							}
							else{
								$processed_values['background-image'] = $background_gradient;
							}
						}
						break;
					case 'shadow-position':
						$box_shadow = $value;
						switch($box_shadow){
							case 'none':
								$processed_values['box-shadow'] = 'none';
								break;
							default:
								$processed_values['box-shadow'] = '';
								if( $box_shadow == 'inset' ) {$processed_values['box-shadow'] .= 'inset ';}
								$processed_values['box-shadow'] .= ' '. $settings[ '_'.$el_array[1] .'_horizontal-position'];
								$processed_values['box-shadow'] .= ' '. $settings[ '_'.$el_array[1] .'_vertical-position'];
								$processed_values['box-shadow'] .= ' '. $settings[ '_'.$el_array[1] .'_blur-strength'];
								$processed_values['box-shadow'] .= ' '. $settings[ '_'.$el_array[1] .'_spread-strength'];
								$processed_values['box-shadow'] .= ' '. $settings[ '_'.$el_array[1] .'_shadow-color'];
						}
						break;

					default:
				}

				if(!empty($processed_values)){
					foreach($processed_values as $processed_attr => $processed_value){

						$processed_attr = str_replace('_hover' , '' , $processed_attr);

						if(strpos ($key,'hover')){
							$elements[$element]['hover'][$processed_attr] =  $processed_value;
						}else{
							$elements[$element]['normal'][$processed_attr] =  $processed_value;
						}
					}
				}

				if(in_array($attribute, $non_valid_atts)){
					continue;
				}


				/* Splic attributes normal vs. hover */
                if(strpos ($key,'hover')){
                    $elements[$element]['hover'][$attribute] =  $value;
                }else{
                    $elements[$element]['normal'][$attribute] =  $value;
				}
            }
		}
		
		if(isset($elements) && !empty($elements))
		$settings['elements'] = $elements;
		if(isset($media_query) && !empty($media_query))
		$settings['media_query'] = $media_query;
		if(isset($google_font) && $google_font!='')
		$settings['google_font'] = $google_font;
		return $settings;
	}

	/* Sanitize array */
	protected function sanitize_array($array){
		$return = array();
		if($array && is_array($array)){
			foreach($array as $key => $value){
				$return[$key] =  sanitize_text_field($value);
			}
		}
		return $return; 
	}
	
	public function categdisp_load_element(){
		$security = filter_input(INPUT_POST, 'security',FILTER_SANITIZE_SPECIAL_CHARS);
        if ( !wp_verify_nonce( $security, "categdisp_load_element")) {
            exit("No script kiddies please!");
		}
		ob_start();
		require_once($this->plugin_dir_path.'admin/partials/customisation/elements/'.$_POST['data']['file_name']).".php";
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;
		wp_die();
	}
}

