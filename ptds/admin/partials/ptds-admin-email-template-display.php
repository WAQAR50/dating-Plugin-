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

if ( !is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
            return;
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

?>

<div class="wrap">    
    <h2><?php _e( 'Email Templates', 'ptds'); ?></h2>
        <form  action="" method="post">
            <?php
                settings_fields( $this->plugin_name.'_activate_email_section');
                do_settings_sections( $this->plugin_name.'_activate_email_section' );
                // Add the submit button to serialize the options
                wp_nonce_field( 'email_activation_template' );
                //submit_button(); 
                
            ?>          
       </form>

       <form  action="" method="post">
            <?php
                settings_fields( $this->plugin_name.'_extend_email_section');
                do_settings_sections( $this->plugin_name.'_extend_email_section' );
                // Add the submit button to serialize the options
                wp_nonce_field( 'extend_activation_template' );
                //submit_button(); 
                
            ?>          
       </form>

       
        <?php 
            
        ?>					
		
</div>



<!-- This file should primarily consist of HTML with a little bit of PHP. -->
