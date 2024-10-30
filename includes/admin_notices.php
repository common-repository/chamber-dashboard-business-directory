<?php
//Setting the update transient when plugin is updated
function cdash_set_update_transient(){
    set_transient('cdash_bus_update', 'true');
}
add_action( 'upgrader_process_complete', 'cdash_set_update_transient');

//Check if the update transient is set
function cdash_bus_updated(){
    if(get_transient('cdash_bus_update')){
        return true; //Plugin was updated
    }
    return false; // New install
}

//Setting the activation date if the plugin was activated for the first time
function cdash_set_activation_date() {
    if(!cdash_bus_updated()){
        $now = strtotime( "now" );
        add_option( 'cdash_bus_activation_date', $now );
    }
}

function cdash_display_review_buttons(){
    if(get_transient('cdash_bus_update')){
        //Show the review right away
        //add_action('admin_notices', 'cdash_provide_review_existing');
        cdash_show_review_after_update();
    }else{
        cdash_show_review_after_thirty_days();
    }
}

//add_action('admin_init', 'cdash_display_review_buttons');

function cdash_show_review_after_update(){
    add_action('admin_notices', 'cdash_provide_review_existing');
}

function cdash_show_review_after_thirty_days(){
    global $pagenow;
    $activation_date = get_option( 'cdash_bus_activation_date' );
    $past_date = strtotime( '-30 days' );

    if ( isset($activation_date) && $past_date >= $activation_date ) {
        add_action('admin_notices', 'cdash_provide_review_existing');
        cdash_set_update_transient();
     }
}

//TODO: add this function only when the users update the plugin to version 3.1.7
function cdash_provide_review_existing(){
    global $current_user ;
    global $pagenow;
    $user_id = $current_user->ID;
    $reviewurl = 'https://wordpress.org/support/plugin/chamber-dashboard-business-directory/reviews/#new-post';
    $hide_notice_url = get_admin_url() . 'plugins.php?cdash_update_review_message_ignore=0';
    if ( ! get_user_meta($user_id, 'cdash_update_review_message_ignore') ) {
        //if($pagenow == 'plugins.php' || $pagenow == 'chamber-dashboard-business-directory/options.php'){
            echo '<div class="notice notice is-dismissible cdashrc_update cdash_update_notice"><p>';
            printf(__('Thanks for using the Business Directory plugin by Chamber Dashboard. We would really appreciate it if you could give us a great rating. It only takes a moment and will help new users find us and encourage us to keep creating more awesome themes & plugins! <a href="'. $reviewurl .'">Rate Now</a> | <a href="' . $hide_notice_url .'">Dismiss Notice</a>'));
            echo "</p></div>";
        //}
    }
}
//add_action('admin_notices', 'cdash_provide_review_existing');

function cdash_update_review_message_ignore() {
	global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['cdash_update_review_message_ignore']) && '0' == $_GET['cdash_update_review_message_ignore'] ) {
         add_user_meta($user_id, 'cdash_update_review_message_ignore', 'true', true);
    }
}
add_action('admin_init', 'cdash_update_review_message_ignore');
?>
