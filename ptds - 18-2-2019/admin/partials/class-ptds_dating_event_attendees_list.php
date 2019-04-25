<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://presstigers.com/
 * @since      1.0.0
 *
 * @package    Ptds
 * @subpackage Ptds/admin/partials
 */


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines class for displaying data from the database
 *
 * @package    ptds
 * @subpackage ptds/admin
 * @author     Presstigers
 */
 
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
//if ( !is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
            //return;
        //} 
//if ( in_array( 'the-events-calendar/the-events-calendar.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_admin() ){

    //return;
//}
//if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && is_admin() ){

    //return;
//}
  

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines class for displaying data from the database
 *
 * @package    ptds
 * @subpackage ptds/admin
 * @author     Presstigers
 */

class Ptds_dating_event_order_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
        /**
         * Constructor.
         * 
         * @since   1.0
         * 
         * @param   void
         * @return  void
         * 
         */
        parent::__construct(array(
            'singular' => 'pose', //singular name of the listed records
            'plural' => 'posts', //plural name of the listed records
            'ajax' => true        //does this table support ajax?
        ));
       

    }

    /**
     * Funtion for Getting the power form all entries.
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  $results Entries
     * 
     */
    function getEntries() {
        global $wpdb;
        $product_id =    $_REQUEST['product_id'];

        $product_orders_ids = $this->get_orders_ids_by_product_id( $product_id );
        $array_test = [];
        foreach($product_orders_ids as $index => $order_id){
      
            $order = wc_get_order($order_id);
            $test =  $order->get_user();
            //print_r($test);
            //exit;
            $orderpaiddate =    $order->get_date_paid();
             $orderdate = date( $orderpaiddate);
             $orderdatetimestring =    strtotime ($orderdate );
            $final_order_date = date("Y-m-d", $orderdatetimestring);
            $product = wc_get_product($product_id );
            $array_test[$index]['productname'] = $product->get_title();
            $array_test[$index]['total_price'] = $order->get_formatted_order_total();
            $array_test[$index]['username'] = $order->get_user()->data->display_name;
            $array_test[$index]['useremail'] = $order->get_user()->data->user_email;
            $array_test[$index]['order_url'] = $order->get_edit_order_url();
            $array_test[$index]['order_date'] = $final_order_date;
            $array_test[$index]['status'] = $order->get_status();
        }
       //print_r($array_test);
         return  $array_test;
    }

        /**
        * Get All orders IDs for a given product ID.
        *
        * @param  integer  $product_id (required)
        * @param  array    $order_status (optional) Default is 'wc-completed'
        *
        * @return array
        */

    public function get_orders_ids_by_product_id( $product_id, $order_status = array( 'wc-completed' ) ){
            global $wpdb;

            $results = $wpdb->get_col("
                SELECT order_items.order_id
                FROM {$wpdb->prefix}woocommerce_order_items as order_items
                LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
                LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
                WHERE posts.post_type = 'shop_order'
                AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
                AND order_items.order_item_type = 'line_item'
                AND order_item_meta.meta_key = '_product_id'
                AND order_item_meta.meta_value = '$product_id'
            ");

            return $results;
        }



    /**
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @since   1.0
     * 
     * @param   $item  Item
     * @param   $column_name  Column Name
     * @return  $item
     * 
     */
    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'productname':
            case 'total_price':
            case 'username':
            case 'useremail':
            case 'order_url':
            case 'order_date':
            case 'status':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
		
    }

    /**
     *  Recommended. This is a custom column method and is responsible for what
     *  is rendered in any column with a name/slug of 'title'. Every time the class
     *  needs to render a column, it first looks for a method named 
     *  column_{$column_title} - if it exists, that method is run. If it doesn't
     *  exist, column_default() is called instead.
     * 
     *  This example also illustrates how to implement rollover actions. Actions
     *  should be an associative array formatted as 'slug'=>'link html' - and you
     *  will need to generate the URLs yourself. You could even ensure the links
     * 
     * @since   1.0
     * 
     * @param   $item  Item
     * @return  $actions Row Action
     * 
     */
    function column_id($item) {


         $actions = array(
            'edit'  => sprintf('<a href="'.$item['order_url'].'">Edit</a>',$_REQUEST['page'],'edit',$item['productname']),
            
        );
        return sprintf(' <span >%2$s</span>%3$s', '', $item['productname'], $this->row_actions($actions)
        );

    }

    /**
     *  REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     *  is given special treatment when columns are processed. It ALWAYS needs to
     *  have it's own method.
     * 
     * @since   1.0
     * 
     * @param   $item  Item
     * @return  $actions Row Action
     * 
     */
   /* function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $item['id']
        );
    }*/

    /**
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  $columns Column
     * 
     */
    function get_columns() {
        $columns = array(
            //'cb' => '<input type="checkbox" />',
            //'productname' => esc_attr__('Product Name', 'ptds'),
            'ID' => esc_attr__('Product Name', 'ptds'),
            'username' => esc_attr__('Attendee Name', 'ptds'),
            'useremail' => esc_attr__('Attendee email', 'ptds'),
            'total_price' => esc_attr__('Total Price', 'ptds'),
            'order_date' => esc_attr__('Order Date', 'ptds'),
            'status' => esc_attr__('Order Status', 'ptds'),
        );
        return $columns;
    } 

    /**
     *  Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     *  you will need to register it here. This should return an array where the 
     *  key is the column that needs to be sortable, and the value is db column to 
     *  sort by. Often, the key and value will be the same, but this is not always
     *  the case (as the value is a column name from the database, not the list table).
     * 
     *  This method merely defines which columns should be sortable and makes them
     *  clickable - it does not handle the actual sorting. You still need to detect
     *  the ORDERBY and ORDER querystring variables within prepare_items() and sort
     *  your data accordingly (usually by modifying your query).
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  $sortable_columns Sortable Column
     * 
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'order_date' => array('order_date', true), //true means it's already sorted
            //'created_at' => array('created_at', false),
            //'updated_at' => array('update_at', false)
        );
        return $sortable_columns;
    }


        public function search_box( $text, $input_id ) { ?>

            <form id="pnc-dating-search-form" method="Get">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <p class="search-box">
                <label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
                <input type="search" id="<?php echo $input_id ?>" name="s" value="<?php _admin_search_query(); ?>" />
                <?php submit_button( $text, 'button', false, false, array('id' => 'search-submit') ); ?>
            </p>
            </form>
    <?php }
    /**
     *  REQUIRED! This is where you prepare your data for display. This method will
     *  usually be used to query the database, sort and filter the data, and generally
     *  get it ready to be displayed. At a minimum, we should set $this->items and
     *  $this->set_pagination_args(), although the following properties and methods
     *  are frequently interacted with here.
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  void
     * 
     */
    function prepare_items() {
        global $wpdb;
        $per_page = 20;
        $ptdsdating_search_key = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->getEntries();

        if( $ptdsdating_search_key ) {
		    $data = $this->filter_table_data( $data, $ptdsdating_search_key );
	    }

        function usort_reorder($a, $b) {
            $orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'order_date';
            $order = (!empty($_REQUEST['order'])) ? sanitize_text_field($_REQUEST['order']) : 'desc';
            $result = strcmp($a[$orderby], $b[$orderby]);
            return ($order === 'asc') ? $result : -$result;
        }

        usort($data, 'usort_reorder');
        $current_page = $this->get_pagenum();
        $total_items = count($data);

        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
        $this->items = $data;
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }
    // filter the table data based on the search key
        public function filter_table_data( $data, $search_key ) {
            $filtered_table_data = array_values( array_filter(  $data, function( $row ) use( $search_key ) {
                foreach( $row as $row_val ) {
                    if( stripos( $row_val, $search_key ) !== false ) {
                        return true;
                    }				
                }			
            } ) );
            return $filtered_table_data;
        }

}
    
    $wp_list_table = new Ptds_dating_event_order_Table();  
   
?>


<div class="wrap">    
    <h2><?php _e( 'Dating System Activated', 'ptds'); ?></h2>
		
		
			<?php 
                $wp_list_table->prepare_items(); 
				$wp_list_table->search_box( __( 'Seach Listing','ptds'), 'pncdatingsystem');
				$wp_list_table->display(); 
			?>					
		
</div>


<?php


            //settings_fields( $this->plugin_name );
	        //do_settings_sections( $this->plugin_name );
        ?>
        

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
