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
		add_submenu_page(
				$this->plugin_name,
				 __( 'Email Template', 'ptds' ),
				__( 'Email Template', 'ptds' ),
				  'manage_options', 
				'ptdsemailtemplate' , 
			array( $this, 'display_email_template_page')
		);

		add_submenu_page(
				$this->plugin_name,
				 __( 'Messages', 'ptds' ),
				__( 'Messages', 'ptds' ),
				  'manage_options', 
				'edit.php?post_type=ptds_messages',
				NULL
			//array( $this, 'display_messages_page')
		);
		add_submenu_page(
				null,
				 __( 'Orders', 'ptds' ),
				__( 'Orders', 'ptds' ),
				  'manage_options', 
				'ptdsorders',
			array( $this, 'display_orders_page')
		);
		add_submenu_page(
				$this->plugin_name,
				 __( 'Attendees', 'ptds' ),
				__( 'Attendees', 'ptds' ),
				  'manage_options', 
				'ptdsattendees',
			array( $this, 'display_attendees_page')
		);

	}

	/**
	 * Render the activated events
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/class-ptds_dating_activated_table-display.php';
	}

	/**
	 * Render the expired events
	 *
	 * @since  1.0.0
	 */
	public function display_expire_event_page() {
		include_once 'partials/class-ptds_expired_events_table-display.php';
		
	}
	
	/**
	 * Render the deactivate events
	 *
	 * @since  1.0.0
	 */
	public function display_dating_close_page() {
		include_once 'partials/class-ptds_dating_end_table-display.php';
		
	}

	/**
	 * Render the upcoming events
	 *
	 * @since  1.0.0
	 */
	public function display_upcoming_event_page() {
		include_once 'partials/class-ptds_upcoming_entries_table-display.php';
		
	}

	/**
	 * Render the orders
	 *
	 * @since  1.0.0
	 */
	public function display_orders_page() {
		include_once 'partials/class-ptds_dating_event_order_list.php';
		
	}


	/**
	 * Render the options page for email template
	 *
	 * @since  1.0.0
	 */
	public function display_email_template_page() {

    if (isset($_POST['ptds_activate_emial_title'])) {
         //check_admin_referrer( 'email_activation_template' );
		 if(! add_option( 'ptds_activate_emial_title',  $_POST['ptds_activate_emial_title'], '', 'yes' )){
       		 update_option('ptds_activate_emial_title', $_POST['ptds_activate_emial_title']);
		}
    } 

	if (isset($_POST['ptds_activate_emial_message'])) {
         //check_admin_referrer( 'email_activation_template' );
		 if(! add_option( 'ptds_activate_emial_message',  $_POST['ptds_activate_emial_message'], '', 'yes' )){
       		 update_option('ptds_activate_emial_message', $_POST['ptds_activate_emial_message']);
		}
    } 

	if (isset($_POST['ptds_extend_emial_title'])) {
         //check_admin_referrer( 'email_activation_template' );
		 if(! add_option( 'ptds_extend_emial_title',  $_POST['ptds_extend_emial_title'], '', 'yes' )){
       		 update_option('ptds_extend_emial_title', $_POST['ptds_extend_emial_title']);
		}
    } 

	if (isset($_POST['ptds_extend_emial_message'])) {
         //check_admin_referrer( 'email_activation_template' );
		 if(! add_option( 'ptds_extend_emial_message',  $_POST['ptds_extend_emial_message'], '', 'yes' )){
       		 update_option('ptds_extend_emial_message', $_POST['ptds_extend_emial_message']);
		}
    } 


		include_once ('partials/ptds-admin-email-template-display.php');
		
	}
	

	/**
	 * Close dating system
	 *
	 * @since  1.0.0
	 */

	public function dating_syste_close(){

		//$dating_meta_close = 	$_POST['dating_meta'];
		 $event_id_dating = 	$_POST['event_id'];
		
		
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


    	$ptds_extend_emial_title = get_option('ptds_extend_emial_title');
		$ptds_extend_emial_message = get_option('ptds_extend_emial_message');

		$to = 'bob@example.com';
		$subject = 'Website Change Request';
		$headers = "From: " . strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($_POST['req-email']) . "\r\n";
		$headers .= "CC: \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		
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

			$ptdscurrentdate =  date("Y-m-d");

			//$ptdsextenddatechange =  date('Y-m-d', strtotime($ptdsextenddate. ' + '.$ptdsextenddatingdays. 'days'));
					//$newdate = strtotime($ptdscurrentdate);
					//$eventdate = strtotime($ptdsdating_meta_event_date);
					//echo $ptdsdating_meta_event_status;
					//echo '<br>';
			if(($ptdsdating_meta_event_status == 'extendeddatingsystem')  && ($ptdsdating_meta_event_date < $ptdscurrentdate ) ){

				if ( ! add_post_meta( $eventsstatusupdate->ID, 'dating_meta_event_status','ptdsdatingclose', true ) ) { 
					update_post_meta( $eventsstatusupdate->ID, 'dating_meta_event_status', 'ptdsdatingclose' );
				}


			}

			if( ($ptdsdating_meta_event_status == 'activatedatingsystem') &&  ($ptdsdating_meta_event_date < $ptdscurrentdate ) ){

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
	
	public function ptds_activation_extend_email(){

		// Add a General section
		add_settings_section($this->option_name . '_activate_email', 'Email Templates', array( $this, $this->option_name . '_emailtemaplte_cb' ),$this->plugin_name.'_activate_email_section');
	
		add_settings_field( $this->option_name . '_activate_email_fields','Activate Email Template', array( $this, $this->option_name . '_activate_email_cb' ), $this->plugin_name.'_activate_email_section', $this->option_name . '_activate_email',
			array( 'label_for' => $this->option_name . '_activate_email_fields' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_activate_email_fields', $this->option_name . '_activate_emial_title' );
		register_setting( $this->plugin_name, $this->option_name . '_activate_email_fields', $this->option_name . '_activate_emial_message'  );

		
		add_settings_section($this->option_name . '_extend_email', '', '',$this->plugin_name.'_extend_email_section');
		add_settings_field( $this->option_name . '_extend_email_fields','Extend Email Template', array( $this, $this->option_name . '_extend_email_cb' ), $this->plugin_name.'_extend_email_section', $this->option_name . '_extend_email',
			array( 'label_for' => $this->option_name . '_extend_email_fields' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_extend_email_fields', $this->option_name . '_extend_emial_title' );
		register_setting( $this->plugin_name, $this->option_name . '_extend_email_fields', $this->option_name . '_extend_emial_message'  );
	
	}

		
	/**
	 * Render the text for the Activate email template setting section
	 *
	 * @since  1.0.0
	 */
	public function ptds_emailtemaplte_cb() {
		echo '<p>' . __( 'Please change the PNC event\'s activate email text accordingly.', 'ptds' ) . '</p>';
	}

	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */

	public function ptds_activate_email_cb() {

 	$ptds_activate_emial_title = get_option('ptds_activate_emial_title');

	//echo  $ptds_activate_emial_title;
	 $ptds_activate_emial_message = get_option('ptds_activate_emial_message');

	//echo  $ptds_activate_emial_message;
		?>
			<fieldset>
				<div class="form-group">
					<label for="<?php echo $this->option_name . '_activate_emial_title' ?>"><?php _e( 'Subject', 'ptds' ); ?></label>
					<input type="text" id="<?php echo $this->option_name . '_activate_emial_title' ?>" name="<?php echo $this->option_name . '_activate_emial_title' ?>"
					class="form-control" value="<?php echo $ptds_activate_emial_title; ?>" placeholder="Enter subject">
				</div>
				<div class="form-group">
					<label for="<?php echo $this->option_name . '_activate_emial_message' ?>"><?php _e( 'Message', 'ptds' ); ?></label>
					<textarea class="form-control rounded-0"  name="<?php echo $this->option_name . '_activate_emial_message' ?>"
					id="<?php echo $this->option_name . '_activate_emial_message' ?>"  rows="10" cols="10" placeholder="Message"><?php echo $ptds_activate_emial_message; ?></textarea>
				</div>
				<button type="submit" id="submit" class="btn btn-outline-primary waves-effect">Save Changes</button>
			</fieldset>
		<?php
		
	}

	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */

	public function ptds_extend_email_cb() {

    $ptds_extend_emial_title = get_option('ptds_extend_emial_title');

	//echo  $ptds_extend_emial_title;
	 $ptds_extend_emial_message = get_option('ptds_extend_emial_message');

	//echo  $ptds_extend_emial_message;
		?>
			<fieldset>
				<div class="form-group green-border-focus">
					<label for="<?php echo $this->option_name . '_extend_emial_title' ?>"><?php _e( 'Subject', 'ptds' ); ?></label>
					<input type="text" id="<?php echo $this->option_name . '_extend_emial_title' ?>" name="<?php echo $this->option_name . '_extend_emial_title' ?>"
					class="form-control" value="<?php echo $ptds_extend_emial_title; ?>" placeholder="Enter subject">
				</div>
				<div class="form-group green-border-focus">
					<label for="<?php echo $this->option_name . '_extend_emial_message' ?>"><?php _e( 'Message', 'ptds' ); ?></label>
					<textarea class="form-control rounded-0"  name="<?php echo $this->option_name . '_extend_emial_message' ?>"
					id="<?php echo $this->option_name . '_extend_emial_message' ?>"  rows="10" cols="10" placeholder="Message"><?php echo $ptds_extend_emial_message; ?></textarea>
				</div>
				<button type="submit" id="submit" class="btn btn-outline-default waves-effect">Save Changes</button>
			</fieldset>
		<?php
		
	}

 
	
	

}
