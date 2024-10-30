<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Category_Displayer_List extends WP_List_Table {
	const TEXT_DOMAIN = 'category-displayer';

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Shortcode', self::TEXT_DOMAIN ), //singular name of the listed records
			'plural'   => __( 'Shortcodes', self::TEXT_DOMAIN ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );
    }


	/**
	 * Retrieve customers data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_shortcodes( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$order  = $_REQUEST['order'] ? esc_sql($_REQUEST['order']) : 'ASC';
		$order = sanitize_text_field($order);	
		$orderBy = $_REQUEST['orderby'] ? esc_sql( $_REQUEST['orderby']) : 'ID';
		$orderBy = sanitize_text_field($orderBy);
		$orderBy = $orderBy ? $orderBy." ".$order : '';
		
		$offset = ( $page_number - 1 ) * $per_page;
			
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}categs_shortcodes ORDER BY $orderBy LIMIT %d OFFSET %d ",$per_page, $offset), 'ARRAY_A' );
		
		return $result;
    }
    

	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_shortcode( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}categs_shortcodes",
			[ 'ID' => $id ],
			[ '%d' ]
		);
    }
    
    /**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}categs_shortcodes") );
    }
    
    /** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No shortcodes avaliable.', self::TEXT_DOMAIN );
    }
    
    	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */


	public function get_taxonomies_allowed($tax){
		
	}

	public function column_default( $item, $column_name ) {
		
		$actions = '<div class="row-actions text-black">
						<span class="edit text-black">
							<a href="?page='.$_GET['page'].'&action=edit&ID='.$item['ID'].'" class="text-black">Edit</a> <span class="separator">|</span> 
						</span>
						<span class="inline">
							<button type="button" class="button-link text-black duplicate-shortcode" data-sh_id="'.$item['ID'].'">Duplicate</button> <span class="separator">|</span> 
						</span>
						<span class="trash">
							<button type="button" class="button-link text-red delete-shortcode" data-sh_id="'.$item['ID'].'">Delete</button></span> 
						</span>
					</div>';
		switch ( $column_name ) {
			case 'date':
				return date(get_option('date_format'), strtotime($item[$column_name]));
				break;
			case 'title':
				return $item[ $column_name ];
				break;
			case 'actions':
				return $actions;
			case 'tpl_title':
				$tpl_id = $item['tpl_id'];
                $templates = get_option('catdisp_templates');
                $pro_tpl = get_option('catdisp_templates_pro');
                if($pro_tpl)
                    $templates = array_merge($templates, $pro_tpl);
                if(array_key_exists($item['tpl_id'], $templates)){
                    $tpl_id = $templates[$item['tpl_id']]['title'];
                }
				$template_allowed = true;
				$template_allowed = apply_filters('catdisp_listtable_allow_template', $item['tpl_id']);
				if($template_allowed != '1'){
					$tpl_not_allowed = apply_filters('catdisp_listtable_template_not_allowed', '');
					return $tpl_id.' '.$tpl_not_allowed;
				}
				return $tpl_id;
				break;

			case 'taxonomy':
				$settings = maybe_unserialize($item['settings']);
				if(!empty($settings)){
					$tax = $settings['categdisp_taxonomy'];
					$tax_allowed = true;
					$tax_allowed = apply_filters('catdisp_listtable_allow_taxonomy', $tax);
					if($tax_allowed != '1'){
						$tax_not_allowed = apply_filters('catdisp_listtable_taxonomy_not_allowed', '');
						return $tax.' '.$tax_not_allowed;
					}
					return $tax;
				}
				break;
			default:
				return print_r( $item, true ); //Show the whole array for troubleshooting purposes
		}
    }
    
    /**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['ID']
		);
    }
    
    	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_shortcode' );

		$title = '<strong>' . $item['title'] . '</strong>';

		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&shortcode=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce )
		];

		return $title . $this->row_actions( $actions );
	}

    /**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			'cb'      => '<input type="checkbox" />',
			'title'    => __( 'Shortcode name', self::TEXT_DOMAIN ),
			'date' => __( 'Date created', self::TEXT_DOMAIN ),
			'tpl_title' => __( 'Template name', self::TEXT_DOMAIN ),
			'taxonomy' => __( 'Taxonomy', self::TEXT_DOMAIN ),
			'actions' => __( '',  self::TEXT_DOMAIN),
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'title' => array( 'title', true ),
			'date' => array( 'date', false )
		);

		return $sortable_columns;
    }
    
    	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];

		return $actions;
    }
    
    	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'shortcodes_per_page', 20);
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_shortcodes( $per_page, $current_page );
    }
    
    public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_shortcode' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_shortcode( absint( $_GET['customer'] ) );

		                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		                // add_query_arg() return the current url
		                wp_redirect( esc_url_raw(add_query_arg()) );
				exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_shortcode( $id );

			}

			// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		        // add_query_arg() return the current url
		        wp_redirect( esc_url_raw(add_query_arg()) );
			exit;
		}
	}

}


