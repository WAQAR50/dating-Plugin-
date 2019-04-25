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
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ptds-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ptds-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'admin_ajax_object', array('ajaxurl' => admin_url( 'admin-ajax.php' ) )  );
		wp_enqueue_script( $this->plugin_name);
		

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
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function dating_syste_close(){

		$dating_meta_close = 	$_POST['dating_meta'];
		$event_id_dating = 	$_POST['event_id'];
		
		/*if ( metadata_exists( 'post', $dating_meta_close, 'dating_meta' ) ) {
			 update_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close, false );
		}else{
				add_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close, false );
		}*/
		if ( ! add_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close, true ) ) { 
			update_post_meta( $event_id_dating, 'dating_meta', $dating_meta_close );
			}
		echo 'Dating system Successfully Closed';

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
