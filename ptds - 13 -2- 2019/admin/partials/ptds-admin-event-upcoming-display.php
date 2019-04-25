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
  
 

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines class for displaying data from the database
 *
 * @package    ptds
 * @subpackage ptds/admin
 * @author     Presstigers
 */
echo '<div class="wrap"><h2>Upcoming Events</h2></div>';
class Ptds_Upcoming_ENTRIES_Table extends WP_List_Table {

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
        //$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts", ARRAY_A);

    //$results = $wpdb->get_results("SELECT wo_posts.* FROM wo_posts LEFT JOIN 
   // wo_postmeta ON wo_postmeta.post_id = wo_posts.ID WHERE 1=1 AND wo_posts.post_type = 'tribe_events' 
    //ORDER BY wo_posts.post_date DESC", ARRAY_A);

/*echo "SELECT 
  {$wpdb->prefix}posts.* 
FROM {$wpdb->prefix}posts 
LEFT JOIN {$wpdb->prefix}postmeta
  ON {$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID
WHERE 1=1  
AND {$wpdb->prefix}posts.post_type = 'tribe_events' 
AND post_date >= '2013-08-26' 
AND post_date < '2013-10-28' 
AND post_date_gmt NOT LIKE '0000%'  
AND {$wpdb->prefix}postmeta.meta_key = 'whatever'
AND {$wpdb->prefix}postmeta.meta_value = 'somevalue'
ORDER BY {$wpdb->prefix}posts.post_date DESC";*/
       //print_r($results);
   //$results = $wpdb->get_results("SELECT wo_posts.* FROM wo_posts LEFT JOIN wo_postmeta ON wo_postmeta.post_id = wo_posts.ID 
  // WHERE 1=1 AND wo_posts.post_type = 'tribe_events' ORDER BY wo_posts.post_date DESC" , ARRAY_A);
  // echo "SELECT wo_posts.* FROM wo_posts LEFT JOIN wo_postmeta ON wo_postmeta.post_id = wo_posts.ID 
  // WHERE 1=1 AND wo_posts.post_type = 'tribe_events' ORDER BY wo_posts.post_date DESC";
       //print_r($wpdb->last_query);
       //exit;
       //echo '<pre>'; print_r( $results);
         $events = tribe_get_events(
            array(
                'eventDisplay' => 'list',
                'start_date' => date( 'Y-m-d H:i:s' ),
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'desc'

                )
        );

     
        //else $$results = $events;

      //echo '<pre>'; print_r( $events);

        //$results = get_object_vars($events);

        
        $array_test = [];

        foreach($events as $index => $event){
               $ptds_dating_system_closed = get_post_meta( $event->ID, 'dating_meta', true ); 
            $ptds_dating_system_ready = get_post_meta( $event->ID, 'ptds_dating_system_ready', true ); 
            $extende_dating_system_activated  = get_post_meta( $event->ID, 'extende_dating_system_activated ', true ); 
            //$ptdstodaydate =  date("Y-m-d");
            if(($ptds_dating_system_closed != 'ptdsdatingclose') && ($ptds_dating_system_ready == 'ptds_dating_system_ready') && ($extende_dating_system_activated != 'extendeddatingsystemactivate')){
              
            $array_test[$index]['ID'] = $event->ID;
            $array_test[$index]['post_title'] = $event->post_title;
            $array_test[$index]['EventStartDate'] = $event->EventStartDate;
            //$array_test[$index]['activate'] = 'Make Active <span>(10 Days left)</span>';
            //$array_test[$index]['extend'] = 'Extend Dating';
            //$array_test[$index]['direct'] = 'Direct Close';
            }
        }



        //print_r($results);
         return  $array_test;
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
            case 'ID':
            case 'post_title':
            case 'EventStartDate':
            //case 'activate':
            //case 'extend':
            //case 'direct':
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
            //'delete' => sprintf('<a class="deleteEntry" href="edit.php?post_type=tribe_events&page=%s&action=%s&entry=%s">' . esc_attr__('Delete', 'power-forms') . '</a>', $_REQUEST['page'], 'delete', intval($item['ID'])),
            'edit'      => sprintf('<a href="post.php?post='.$item['ID'].'&action=edit">Edit</a>',$_REQUEST['post'],'edit',$item['EventStartDate']),
        );
        return sprintf(' <span >%2$s</span>%3$s', '', $item['EventStartDate'], $this->row_actions($actions)
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
            'ID' => esc_attr__('Event Start Date', 'ptds'),
            //'EventStartDate' => esc_attr__('Event Start Date', 'ptds'),
            'post_title' => esc_attr__('Name', 'ptds'),
            //'activate' => esc_attr__('Make Activate', 'ptds'),
           // 'extend' => esc_attr__('Extend Dating', 'ptds'),
            //'direct' => esc_attr__('Direct Close', 'ptds'),
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
            'ID' => array('id', true), //true means it's already sorted
            //'created_at' => array('created_at', false),
            //'updated_at' => array('update_at', false)
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
    /*function get_bulk_actions() {
        $new = array();
        $new['bulk-delete'] = esc_attr__('Delete', 'ptds');
        $new['bulk-delete'] = esc_attr__('Edit', 'ptds');
        $actions = $new;
        return $actions;
    }
*/
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
   /* function process_bulk_action() {
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
        //$this->process_bulk_action();
        //$this->months_dropdown( 'tribe_events');
        $data = $this->getEntries();
         
        function usort_reorder($a, $b) {
            $orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'EventStartDate';
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
    
    $wp_list_table = new Ptds_Upcoming_ENTRIES_Table();  
    
   
    $wp_list_table->prepare_items(); 
    $wp_list_table->display(); 
  

global $wpdb;
        /**
        * Detect plugin. For use on Front End only.
        */
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        // check for event plugin is activated
      /*  if ( !is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
            return;
        } 

        $events = tribe_get_events(
            array(
                'eventDisplay' => 'upcoming',
                'start_date' => date( 'Y-m-d H:i:s' ),
                'posts_per_page' => 20,
                'orderby' => 'date',
                'order' => 'desc'

                )
        );
*/

?>
    <!--<div class="wrap">
    <h1>Upcoming Events</h1>

    <table class="wp-list-table  ptds-upcoming-events widefat fixed striped posts ">
        <thead>
            <tr>
                <th scope="col" id="title" class="manage-column column-date  sortable desc ">End Date</th>
                <th scope="col" id="author" class="manage-column column-title  column-primary">Name</th>
                <th scope="col" id="categories" class="manage-column column-active">Make Active</th>
                <th scope="col" id="tags" class="manage-column column-extend">Extend Dating</th>
                <th scope="col" id="tags" class="manage-column column-close">Direct Close</th>
            </tr>
        </thead>

        <tbody id="the-list">
            <?php foreach($events as $event){ 
        //echo '<pre>';
        //print_r($event);
?>
            <tr id="post-1" class="iedit author-other level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
                <td class="date column-date has-row-actions event-date" data-colname="Date"><abbr title="2018/07/03 6:03:13 am"><?php echo $event->EventEndDate; ?></abbr></td>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><?php echo $event->post_title ?></td>
                <td class="title column-title has-row-actions column-primary page-title" data-colname="active"><a href="" id="">Make ACtive <span>(10 days left)</span></a></td>	
                <td class="title column-title has-row-actions column-primary page-title" data-colname="extend"><a href="" id="">Extend</a></td>	
                <td class="title column-title has-row-actions column-primary page-title" data-colname="close"><a href="" id="">Direct Close </a></td>	
            </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <th scope="col" id="title" class="manage-column column-date  sortable desc ">End Date</th>
                <th scope="col" id="author" class="manage-column column-title  column-primary">Name</th>
                <th scope="col" id="categories" class="manage-column column-active">Make Active</th>
                <th scope="col" id="tags" class="manage-column column-extend">Extend Dating</th>
                <th scope="col" id="tags" class="manage-column column-close">Direct Close</th>
            </tr>
        </tfoot>

    </table>






	    <?php 
            //settings_fields( $this->plugin_name );
	        //do_settings_sections( $this->plugin_name );
        ?>
        
	</div>-->

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
