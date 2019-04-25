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
   global $wpdb;
    $event_id =    $_REQUEST['event_id'];
?>
        <h4 class="modal-title w-100 font-weight-bold">Attendee Registration</h4>
       <form  id="attendees_resgistration_form" action="" method="post" validate>
        <div id="attendees-container-form" class="container-fluid">
            <div class="attandees_form_fields_group row">
                <div class="md-form mb-5 col-md-4  col-sm-12">
                    <input type="email" id="attendees_reg_email" class="ptdsemail form-control validate" name="attendees_reg_email"  required>
                    <label data-error="wrong" data-success="right" for="attendees_reg_email[]">Your email</label>
                </div>
                <div class="md-form mb-5 col-md-3  col-sm-12">
                    <input type="text" id="attendees_reg_first_name" class="ptdsfirstname form-control validate" name="attendees_reg_first_name"  required>
                    <label data-error="wrong" data-success="right" for="attendees_reg_first_name[]">First Name</label>
                </div>          
                <div class="md-form mb-2 col-md-3  col-sm-12">
                    <input type="text" id="attendees_reg_last_name" class="ptdslastname form-control validate" name="attendees_reg_last_name"  required>
                    <label data-error="wrong" data-success="right" for="attendees_reg_last_name[]">Last Name</label>
                </div>       
                <div class=" mb-2 col-md-2 col-sm-12">
                    <label class="font-weight-bold mb-4" for="">Select Gender:</label>
                    <div class="d-flex text-left">
                        <div class="custom-control custom-radio mr-3">
                            <input type="radio" class="ptdsgendermale custom-control-input" id="attendees_reg_male" name="attendees_reg_gender" value="male"  required>
                            <label class="custom-control-label" for="attendees_reg_male">Male</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="ptdsgenderfemale custom-control-input" id="attendees_reg_female" name="attendees_reg_gender" value="female"  required>
                            <label class="custom-control-label" for="attendees_reg_female">Female</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a id="attandees_add_more_button" class="btn btn-primary">Add More (<span class="figure">1</span>)</a>
        <input type="hidden" id="attendees_reg_event" name="attendees_reg_event" class="form-control" value="<?php echo $event_id; ?>" required>           
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Registration</button>
        </div> 
        </form>              
                    
                    
               
