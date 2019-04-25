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



if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class ptds_Upcoming_Events extends WP_List_Table {

	/** Class constructor */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Upcoming Event', 'ptds' ), //singular name of the listed records
			'plural'   => __( 'Upcoming Events', 'ptds' ), //plural name of the listed records
			'ajax'     => true //should this table support ajax?

		] );
       $this->prepare_items();
       $this->column_default();
      
	}

    /**
    * init all methods
    *
    * @return mixed
    */
    public function ptds_Allmethods(){
       
        
       
       
        
    }


    /**
    * Retrieve event's data from the database
    *
    * @param int $per_page
    * @param int $page_number
    *
    * @return mixed
    */
    public  function get_upcomingEvents() {

    global $wpdb;
        /**
        * Detect plugin. For use on Front End only.
        */
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // check for event plugin is activated
        if ( !is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
            return;
        } 

        $events = tribe_get_events(
            array(
                'eventDisplay' => 'upcoming',
                'start_date' => date( 'Y-m-d H:i:s' ),
                'posts_per_page' => 20
                )
        );
        //echo '<pre>';
        //print_r($events);


    /*
    $sql = "SELECT * FROM {$wpdb->prefix}posts";

    
        $sql .= ' ORDER BY ' . esc_sql( $_REQUEST['date'] );
        $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['DSC'] ) : 'ASC';
    $sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['DSC'] ) : 'ASC';

    $sql .= " LIMIT $per_page";
    $sql .= "post_type tribe_events";
    $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


    $result = $wpdb->get_results( $sql, 'ARRAY_A' );
    */

    return $events;
    }


    /**
    * Returns the count of records in the database.
    *
    * @return null|string
    */
    public function record_count() {
        global $wpdb;

        $events = tribe_get_events(
            array(
                'eventDisplay' => 'upcoming',
                'start_date' => date( 'Y-m-d H:i:s' ),
                )
        );
        $sql = count($events);

        return $wpdb->get_var( $sql );
    }

    /** Text displayed when no customer data is available */
    public function no_items() {
        _e( 'No upcoming event avaliable.', 'ptds' );
    }

    /**
    * Render a column when no column specific method exists.
    *
    * @param array $item
    * @param string $column_name
    *
    * @return mixed
    */
    public function column_default( $item, $column_name ) {
            echo 'asdsadasdasd sd asdasd asd asd adas das d ';
        print_r($column_name);
    switch ( $column_name ) {
        case 'post_title':
        case 'post_date':
        //return $item[ $column_name ];
        //default:
        return print_r( $item, true ); //Show the whole array for troubleshooting purposes
    }
    }


    /**
    *  Associative array of columns
    *
    * @return array
    */
    public function get_columns() {
    $columns = [
        'post_date' => __( 'Post Date', 'ptds' ),
        'post_title' => __( 'Name', 'ptds' ),
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
        'post_date' => array( 'Post Date', true ),
        'post_title' => array( 'Name', false )
    );

    return $sortable_columns;
    }
 

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

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
       

        $data = $this->get_upcomingEvents();
         
        function usort_reorder($a, $b) {
            $orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'id';
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


}
new ptds_Upcoming_Events;

global $wpdb;
        /**
        * Detect plugin. For use on Front End only.
        */
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // check for event plugin is activated
        if ( !is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
            return;
        } 

        $events = tribe_get_events(
            array(
                'eventDisplay' => 'upcoming',
                'start_date' => date( 'Y-m-d H:i:s' ),
                'posts_per_page' => 20
                )
        );


?>
    <!--<div class="wrap">
    <h1>Upcoming Events</h1>

    <table class="wp-list-table  ptds-upcoming-events widefat fixed striped posts ">
        <thead>
            <tr>
                <th scope="col" id="title" class="manage-column column-date  sortable desc ">Date </th>
                <th scope="col" id="author" class="manage-column column-title  column-primary">Name</th>
                <th scope="col" id="categories" class="manage-column column-active">Activate/Deactivate</th>
                <th scope="col" id="tags" class="manage-column column-extend">Extend system</th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php foreach($events as $event){ ?>
            <tr id="post-1" class="iedit author-other level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                <td class="date column-date has-row-actions event-date" data-colname="Date"><abbr title="2018/07/03 6:03:13 am"><?php echo $event ?></abbr></td>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><?php echo $event ?></td>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="active"><a href="" id="">active</a></td>	
                <td class="title column-title has-row-actions column-primary page-title" data-colname="extend"><a href="" id="">Extend</a></td>		
            </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <th scope="col" id="title" class="manage-column column-date  sortable desc">Date </th>
                <th scope="col" id="author" class="manage-column column-title  column-primary">Name</th>
                <th scope="col" id="categories" class="manage-column column-active">Activate/Deactivate</th>
                <th scope="col" id="tags" class="manage-column column-extend">Extend system</th>
            </tr>
        </tfoot>

    </table>






	    <?php 
            //settings_fields( $this->plugin_name );
	        //do_settings_sections( $this->plugin_name );
        ?>
        
	</div>-->

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
