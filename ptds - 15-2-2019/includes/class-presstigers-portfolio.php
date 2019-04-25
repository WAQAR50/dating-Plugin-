<?php 
/* start post type */
if ( ! class_exists( 'Ptds_Messages' ) ) :

class Ptds_Messages {
    /**
     * 
     */
    public function __construct() {


            // Add the portfolio post type and taxonomies
            add_action( 'init', array( $this, 'Ptds_Messages_item_init' ) );  
           
          

    }

    /**
     * Initiate registrations of post type and taxonomies.
     *
     * @uses portfolio Item_Post_Type::Ptds_Messages_post_type()
     *
     */
    public function Ptds_Messages_item_init() {
            $this->Ptds_Messages_post_type();

    }



    /**
     * Enable the portfolio Item custom post type.
     *
     * @link http://codex.wordpress.org/Function_Reference/register_post_type
     */
    protected function Ptds_Messages_post_type() {
            $labels = array(
                    'name'                  => _x( 'Portfolio', 'ptds' ),
                    'singular_name'         => _x( 'Portfolio', 'ptds' ),
                    'menu_name'             => __( 'Portfolio', 'ptds' ),
                    'name_admin_bar'        => __( 'Portfolio', 'ptds' ),
                    'archives'              => __( 'Portfolio', 'ptds' ),
                    'parent_item_colon'     => __( 'Portfolio:', 'ptds' ),
                    'all_items'             => __( 'All Items', 'ptds' ),
                    'add_new_item'          => __( 'Add New Item', 'ptds' ),
                    'add_new'               => __( 'Add New', 'ptds' ),
                    'new_item'              => __( 'New Item', 'ptds' ),
                    'edit_item'             => __( 'Edit Item', 'ptds' ),
                    'update_item'           => __( 'Update Item', 'ptds' ),
                    'view_item'             => __( 'View Item', 'ptds' ),
                    'search_items'          => __( 'Search Item', 'ptds' ),
                    'not_found'             => __( 'Not found', 'ptds' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ptds' ),
                    'featured_image'        => __( 'Featured Image', 'ptds' ),
                    'set_featured_image'    => __( 'Set featured image', 'ptds' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ptds' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ptds' ),
                    'insert_into_item'      => __( 'Insert into item', 'ptds' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this item', 'ptds' ),
                    'items_list'            => __( 'Items list', 'ptds' ),
                    'items_list_navigation' => __( 'Items list navigation', 'ptds' ),
                    'filter_items_list'     => __( 'Filter items list', 'ptds' ),
            );

         $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => false, //<--- HERE
            'query_var'          => false,
            'rewrite'            => array( 'slug' => 'ptds_messages' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => true,
            'menu_position'      => null,
            'exclude_from_search' => true,
            'delete_with_user' => true,

            'supports'           => array( 'title','editor','author' )
         );
           /* $args = array(
                                            'label'                 => __( 'Portfolio', 'ptds' ),
                    'description'           => __( 'Portfolio', 'ptds' ),
                    'labels'                => $labels,
                    'supports'              => array('title', 'editor','thumbnail', 'excerpt'),
                    'hierarchical'          => false,
                    'public'                => true,
                    'show_ui'               => true,
                    'show_in_menu'          => true,
                    'menu_position'         => 5,
                    'show_in_admin_bar'     => true,
                    'show_in_nav_menus'     => true,
                    'can_export'            => true,
                    'has_archive'           => true,		
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'capability_type'       => 'post',
            );
*/
            register_post_type( 'ptds_messages', $args );
    }

}

new Ptds_Messages;

endif;




