<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://presstigers.com/
 * @since      1.0.0
 *
 * @package    Ptds
 * @subpackage Ptds/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ptds
 * @subpackage Ptds/admin
 * @author     PressTigers <support@presstigers.com>
 */
class Ptds_Admin {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'ptds';

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ptds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ptds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		


   		 $current_screen = get_current_screen();

		//if ( (strpos($current_screen->base, 'ptds') === false) || (strpos($current_screen->base, 'expired_events') === false) || (strpos($current_screen->base, 'upcoming_events') === false) || (strpos($current_screen->base, 'dating_close') === false)) {
			//return;
		//} else {
      	wp_enqueue_style( $this->plugin_name.'_Font_Awesome', plugin_dir_url( __FILE__ ) . 'css/ptds-fonts-awesome.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'_bootstrap.min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name.'_mdb.min', plugin_dir_url( __FILE__ ) . 'css/mdb.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name.'_confirm', plugin_dir_url( __FILE__ ) . 'css/ptds-confirmation.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ptds-admin.css', array(), $this->version, 'all' );

		//}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ptds_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ptds_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 $current_screen = get_current_screen();

		//if ( (strpos($current_screen->base, 'ptds') === false) || (strpos($current_screen->base, 'expired_events') === false) || (strpos($current_screen->base, 'upcoming_events') === false) || (strpos($current_screen->base, 'dating_close') === false)) {
			//return;
		//} else {
		//wp_enqueue_script('jquery');
		//wp_enqueue_script( $this->plugin_name.'_jquery', plugin_dir_url( __FILE__ ) . '/js/confirmation.js', array(), '3.3.1', true );
        wp_enqueue_script( $this->plugin_name.'_popper.min', plugin_dir_url( __FILE__ ) . '/js/popper.min.js', array(), '1.0.0', true );
        wp_enqueue_script( $this->plugin_name.'_bootstrap.min', plugin_dir_url( __FILE__ ) . '/js/bootstrap.min.js', array(), '1.0.0', true );
		wp_enqueue_script( $this->plugin_name.'_confirm', plugin_dir_url( __FILE__ ) . '/js/confirmation.js', array(), '', true );
        wp_enqueue_script( $this->plugin_name.'_mdb.min', plugin_dir_url( __FILE__ ) . '/js/mdb.min.js', array(), '1.0.0', true );

		/**
		*
		* Custom js
		*/
		
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ptds-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'admin_ajax_object', array('ajaxurl' => admin_url( 'admin-ajax.php' ) )  );
		wp_enqueue_script( $this->plugin_name);


		//}

	}

	/**
	 * Add an options page on admin dashboard
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
	
		$this->plugin_screen_hook_suffix = add_menu_page(
			__( 'Upcoming Events', 'ptds' ),
			__( 'PNC Dating System ', 'ptds' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page'),   plugin_dir_url( __FILE__ ) . 'img/dating.png', 12
		);
		add_submenu_page(
				$this->plugin_name,
				 __( 'Expired Events', 'ptds' ),
				__( 'Expired Events', 'ptds' ),
				  'manage_options', 
				'expired_events' , 
			array( $this, 'display_expire_event_page')
		);

		add_submenu_page(
				$this->plugin_name,
				 __( 'Upcoming Events', 'ptds' ),
				__( 'Upcoming Events', 'ptds' ),
				  'manage_options', 
				'upcoming_events' , 
			array( $this, 'display_upcoming_event_page')
		);
		add_submenu_page(
				$this->plugin_name,
				 __( 'Dating System Closed', 'ptds' ),
				__( 'Dating System Closed', 'ptds' ),
				  'manage_options', 
				'dating_close' , 
			array( $this, 'display_dating_close_page')
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/ptds-admin-display.php';
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_expire_event_page() {
		include_once 'partials/ptds-admin-event-expired-display.php';
		
	}
	
	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_dating_close_page() {
		include_once 'partials/ptds-admin-dating-close-display.php';
		
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_upcoming_event_page() {
		include_once 'partials/ptds-admin-event-upcoming-display.php';
		
	}
	
	
	public function register_setting(){

		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'ptds' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
	/*
		add_settings_field(
			$this->option_name . '_position',
			__( 'Text position', 'ptds' ),
			array( $this, $this->option_name . '_position_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
	*/
		
	}
	
	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function ptds_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'ptds' ) . '</p>';
	}

	/**
	 * Close dating system
	 *
	 * @since  1.0.0
	 */

	public function dating_syste_close(){

		//$dating_meta_close = 	$_POST['dating_meta'];
		 $event_id_dating = 	$_POST['event_id'];
		
		/*if ( metadata_exists( 'post', $dating_meta_close, 'dating_meta' ) ) {
			 update_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close, false );
		}else{
				add_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close, false );
		}*/
		if ( ! add_post_meta( $event_id_dating, 'dating_meta_event_status','ptdsdatingclose', true ) ) { 
			update_post_meta( $event_id_dating, 'dating_meta_event_status', 'ptdsdatingclose' );
			}
		echo 'Dating system Successfully Closed';

	die();

	}



	/**
	 * Extend dating system
	 *
	 * @since  1.0.0
	 */
	 

	public function ptds_dating_extend(){

		$ptdsextenddatingdays = 	$_POST['ptdsdating_days'];
		$ptdsevent_id = 	$_POST['ptdsevent_id'];
		$ptdsextenddate =  date("Y-m-d");

		$ptdsextenddatechange =  date('Y-m-d', strtotime($ptdsextenddate. ' + '.$ptdsextenddatingdays. 'days'));
		if ( ! add_post_meta( $ptdsevent_id, 'dating_meta_days', $ptdsextenddatingdays, true ) ) { 
			update_post_meta( $ptdsevent_id, 'dating_meta_days', $ptdsextenddatingdays );
		}

		if ( ! add_post_meta( $ptdsevent_id, 'dating_meta_status_date', $ptdsextenddatechange, true ) ) { 
			update_post_meta( $ptdsevent_id, 'dating_meta_status_date', $ptdsextenddatechange );
		}

		if ( ! add_post_meta( $ptdsevent_id, 'dating_meta_event_status', 'extendeddatingsystem', true ) ) { 
			update_post_meta( $ptdsevent_id, 'dating_meta_event_status', 'extendeddatingsystem' );
		}

		echo 'Dating system Successfully Extended';

	die();

	}


	 /**
     * Register metabox for event dating system .
     *
     */
    public function ptds_event_dating_meta_box() {

        add_meta_box(
                'ptds_event_dating_meta',
                 __( 'PNC Dating System', 'ptds' ), 
                array( $this, 'ptds_event_dating_meta_render' ),
                'tribe_events', 
                'side', 
                'high');
    }

    /**
     * Render HTML of event dating system custom fields
     */

    public function ptds_event_dating_meta_render($post) {

        // Get previous saved data
        $ptds_dating_system_ready = get_post_meta($post->ID, 'ptds_dating_system_ready', true);

        // Create Nounce Field for security purpose
        wp_nonce_field( 'nounce_ptds_dating_system_action', 'nounce_ptds_dating_system_field' );

		if($ptds_dating_system_ready == 'ptds_dating_system_ready'){

		  $output_html = '<fieldset><div class="plugin_field" style="float:left; margin-right:10px">
            <input type="checkbox" name="ptds_dating_system_ready" id="ptds_dating_system_ready" class="input" value="ptds_dating_system_ready" checked=checked>
        </div>';
		$output_html .= '<div class="plugin_label">
            <label for="ptds_dating_system_ready">'.__('Add Event in Dating system','ptds').'</label>
        </div></fieldset>';
      
		}else{
		 $output_html = '<fieldset><div class="plugin_field" style="float:left; margin-right:10px">
            <input type="checkbox" name="ptds_dating_system_ready" id="ptds_dating_system_ready" class="input" value="ptds_dating_system_ready">
        </div>';
			$output_html .= '<div class="plugin_label">
            <label for="ptds_dating_system_ready">'.__('Add Event in Dating system','ptds').'</label>
        </div></fieldset>';
       
		}


        


        echo $output_html;
    }

    /**
     * Save custom fields value in postmeta 
     */

    public function ptds_event_dating_meta_save($post_id) {

        $instance = array();
        // Bail if we're doing an auto save
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (isset($_POST['nounce_ptds_dating_system_action']) && ! wp_verify_nonce( $_POST['nounce_ptds_dating_system_field'], 'nounce_ptds_dating_system_action' ) ) {
            return $post_id;
        }

        if ( !current_user_can( 'edit_post', $post_id )){
            return $post_id;
        }

        //$p_type = get_post_type($post_id);
		//echo $post_id;
		//echo $_POST['ptds_dating_system_ready'];
		//exit;
         //if($p_type == 'ptds_dating_system_ready'){

            $instance['ptds_dating_system_ready'] = isset($_POST['ptds_dating_system_ready']) ? $_POST['ptds_dating_system_ready']:"";

        //}

        foreach ($instance as $key => $value) { 

            if(get_post_meta($post_id, $key, false)) { 
                update_post_meta($post_id, $key, $value);
            } 
            else { 
                add_post_meta($post_id, $key, $value);	
            }
            if(!$value) 
                delete_post_meta($post_id, $key); 
        }
    }

	/**
	 * Update the dating event status on date chage
	 *
	 * @since  1.0.0
	 */

	
	public function ptds_dating_event_status_update(){

		$eventsstatusupdates = tribe_get_events(
            array(
                'eventDisplay' => 'past',
                'end_date' => date( 'Y-m-d H:i:s' ),
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'desc'

                )
        );

		 foreach($eventsstatusupdates as $index => $eventsstatusupdate){

			$ptdsdating_meta_event_status = get_post_meta( $eventsstatusupdate->ID, 'dating_meta_event_status', true );
			$ptdsdating_meta_event_date = get_post_meta( $eventsstatusupdate->ID, 'dating_meta_status_date', true );

			$ptdsdating_meta_event_date;
			$ptdscurrentdate =  date("Y-m-d");
			//$ptdsextenddatechange =  date('Y-m-d', strtotime($ptdsextenddate. ' + '.$ptdsextenddatingdays. 'days'));
					//$newdate = strtotime($ptdscurrentdate);
					//$eventdate = strtotime($ptdsdating_meta_event_date);
			if(($ptdsdating_meta_event_status == 'extendeddatingsystemactivate') && ($ptdsdating_meta_event_date < $ptdscurrentdate) && ($ptdsdating_meta_event_date > $ptdscurrentdate ) ){
			//if($ptdsdating_meta_event_date < $ptdscurrentdate){
				//echo 'wqa';
			
				if ( ! add_post_meta( $eventsstatusupdate->ID, 'dating_meta_event_status','ptdsdatingclose', true ) ) { 
					update_post_meta( $eventsstatusupdate->ID, 'dating_meta_event_status', 'ptdsdatingclose' );
				}


			}
		}

	}

	/**
	 * Activate dating system
	 *
	 * @since  1.0.0
	 */
	 

	public function ptds_dating_activate(){

		$ptdsdating_activatedays = 	$_POST['ptdsdating_activatedays'];
	 	$ptdseventactivate_id = 	$_POST['ptdseventactivate_id'];
	 	$activatedatinggender = 	$_POST['activatedatinggender'];
		$ptdsactivatecurrentdate =  date("Y-m-d");

		$ptdsactivatedatechange =  date('Y-m-d', strtotime($ptdsactivatecurrentdate. ' + '.$ptdsdating_activatedays. 'days'));





		if ( ! add_post_meta( $ptdseventactivate_id, 'dating_meta_days', $ptdsdating_activatedays, true ) ) { 
			update_post_meta( $ptdseventactivate_id, 'dating_meta_days', $ptdsdating_activatedays );
		}

		if ( ! add_post_meta( $ptdseventactivate_id, 'dating_meta_status_date', $ptdsactivatedatechange, true ) ) { 
			update_post_meta($ptdseventactivate_id, 'dating_meta_status_date', $ptdsactivatedatechange );
		}
		if ( ! add_post_meta( $ptdseventactivate_id, 'dating_meta_gender', $activatedatinggender, true ) ) { 
			update_post_meta( $ptdseventactivate_id, 'dating_meta_gender', $activatedatinggender );
		}

		if ( ! add_post_meta( $ptdseventactivate_id, 'dating_meta_event_status', 'activatedatingsystem', true ) ) { 
			update_post_meta( $ptdseventactivate_id, 'dating_meta_event_status', 'activatedatingsystem' );
		}

		echo 'Dating system Successfully Activated';

	die();

	}









	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */
	/*public function ptds_position_cb() {
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before">
					<?php _e( 'Before the content', 'ptds' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after">
					<?php _e( 'After the content', 'ptds' ); ?>
				</label>
			</fieldset>
		<?php
	}*/

	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	/*public function ptds_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
	        return $position;
	    }
	}*/

}
