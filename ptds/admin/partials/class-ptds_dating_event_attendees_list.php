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
        $event_id =    $_REQUEST['event_id'];
        //echo $event_id;
        $product_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_tribe_wooticket_for_event' and meta_value = $event_id");
        //echo $product_id;
        $event_related_product_id  = $this->get_orders_ids_by_product_ids($product_id );
        //echo 'dfdsfsadfs';
        //echo $event_related_product_id ;

         $array_test = [];
        foreach($event_related_product_id as $index => $order_id){
            //echo $order_id;
            $order = wc_get_order($order_id);
            //$ptdsuserdetail =  $order->get_user();
            $user_id = $order->get_user()->data->ID;

            //print_r($ptdsuserdetail);
             //get_user_meta($user_id, 'first_name', false);
			 //get_user_meta($user_id, 'last_name',false);
			//get_user_meta($user_id, 'ptdsgender', false);


            $array_test[$index]['ID'] = $user_id;
            $array_test[$index]['first_name'] = get_user_meta($user_id, 'first_name', true);
            $array_test[$index]['last_name'] = get_user_meta($user_id, 'last_name',true);
            $array_test[$index]['email_address'] = $order->get_user()->data->user_email;
            $array_test[$index]['gender'] = get_user_meta($user_id, 'ptdsgender', true);
            $array_test[$index]['event_name'] = get_the_title($event_id);
        }

        //foreach($product_orders_ids as $index => $order_id){
        
           
            //$array_test[$index]['Password'] = $order->get_edit_order_url();
        //}
       //print_r($array_test);
         return  $array_test;
    }



    public function get_orders_ids_by_product_ids( $product_id, $order_status = array( 'wc-completed' ) ){
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
            case 'first_name':
            case 'last_name':
            case 'email_address':
            case 'gender':
            case 'ID':
            case 'event_name':
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
           // 'edit'  => sprintf('<a href="?page=ptdsattendees&user_id='.$item['ID'].'">Edit</a>',$_REQUEST['page'],'edit',$item['first_name']), 
        );
        return sprintf(' <span >%2$s</span>%3$s', '', $item['first_name'], $this->row_actions($actions)
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
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $item['id']
        );
    }

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
            'cb' => '<input type="checkbox" />',
            //'productname' => esc_attr__('Product Name', 'ptds'),
            'ID' => esc_attr__('First Name', 'ptds'),
            //'first_name' => esc_attr__('Attendee Name', 'ptds'),
            'last_name' => esc_attr__('Last Name', 'ptds'),
            'email_address' => esc_attr__('Email Address', 'ptds'),
            'gender' => esc_attr__('Gender', 'ptds'),
            'event_name' => esc_attr__('Event Name', 'ptds'),
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
            'ID' => array('ID', true), //true means it's already sorted
            'last_name' => array('last_name', true),
            'email_address' => array('email_address', true),
            'gender' => array('gender', true),
            //'event_name' => array('event_name', true),
        );
        return $sortable_columns;
    }

        /**
     *  Optional. If you need to include bulk actions in your list table, this is
     *  the place to define them. Bulk actions are an associative array in the format
     *  'slug'=>'Visible Title'
     * 
     *  If this method returns an empty value, no bulk action will be rendered. If
     *  you specify any bulk actions, the bulk actions box will be rendered with
     *  the table automatically on display().
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  $actions Bulk Action
     * 
     */
    function get_bulk_actions() {
        $new = array();
        $new['bulk-delete'] = esc_attr__('Add to event', 'ptds');
        //$new['bulk-delete'] = esc_attr__('Edit', 'ptds');
        $actions = $new;
        return $actions;
    }

    /**
     * Delete a entry record.
     * 
     * @since   1.0
     * 
     * @param   $id ID
     * @return  void
     * 
     */
    /*public static function delete_entry($id) {
        global $wpdb;

        $deleteRequest = $wpdb->get_row("DELETE FROM {$wpdb->prefix}posts WHERE ID = $id", ARRAY_A);
        
    }
 */

    /**
     * Get an entry Data.
     * 
     * @since   1.0
     * 
     * @param   $id ID
     * @return  $results Entry Data
     * 
     */
    /*public static function get_entry($id) {
        global $wpdb;
        $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}posts WHERE id = $id", ARRAY_A);
        return $result;
    }
 
*/
    /**
     *  Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     *  For this example package, we will handle it in the class to keep things
     *  clean and organized.
     * 
     * @since   1.0
     * 
     * @param   void
     * @return  void
     * 
     */
  /*  function process_bulk_action() {
        if ('delete' === $this->current_action() && isset($_GET['entry'])) {
            self::delete_entry(absint($_GET['entry']));
        } 
        if (isset($_POST['action2'])) {
            if (isset($_POST['entry'])) {
                $delete_ids = esc_sql($_POST['entry']);
                foreach ($delete_ids as $id) {
                    self::delete_entry(absint($id));
                }
            }
        }
    }

*/


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


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
