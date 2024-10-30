<?php
/*Subscribe to emails through the plugin pages*/

if ( ! defined( 'ABSPATH' ) ) exit;

function cdash_email_subscribe(){
  ?>
  <div class="cdash_email_subscribe_div">
    <div>
      <h2><?php esc_html_e( 'Be the first to know about updates and new features.', 'cdash' ); ?></h2>
      <?php
        if(isset($_POST['cdash_ac_email_subscribe'])){
          $firstname = sanitize_text_field($_POST['first_name']);
          $lastname = sanitize_text_field($_POST['last_name']);
          $email = sanitize_email($_POST['cdash_email']);
          cdash_ac_add_contact($firstname, $lastname, $email);
        }
         
      ?>
      <button type="button" name="cdash_email_subscribe" class="cdash_admin email_signup button-primary" title="Sign up for updates" aria-label="Sign up for updates"><?php esc_html_e('Stay Up-to-Date', 'cdash'); ?></button>
    </div>
    <div class="cdash_email_popup cdash_wrapper">
      <button type="button" class="close_button cdash_admin" title="close" aria-label="Close">X</button>
      <form action="" method="post" name="cdash_email_subscribe" class="email_subscribe_form">
          <div>
            <label for="First Name"><?php esc_html_e('First Name', 'cdash'); ?></label>
            <input type="text" name="first_name" />
          </div>
          <div>
            <label for="Last Name"><?php esc_html_e('Last Name', 'cdash'); ?></label>
            <input type="text" name="last_name" />
          </div>
          <div>
            <label for="Email"><?php esc_html_e('Email', 'cdash'); ?></label>
            <input type="email" name="cdash_email" />
          </div>
          <div class="actions">
            <button type="submit" name="cdash_ac_email_subscribe" class="button-primary cdash_form cdash_admin" title="Subscribe" aria-label="Subscribe"><?php esc_html_e('Subscribe', 'cdash'); ?></button>
          </div>
      </form>
      
    </div>
  </div>
<?php
}

function cdash_ac_add_contact($firstname, $lastname, $email){
  //$url = 'https://chamberdashboard.activehosted.com';
  //$url = 'https://chamberdashboard.api-us1.com/api/3/contact/sync';
  $url = 'https://chamberdashboard.api-us1.com/';

  $params = array(
    'api_key' =>  'cc01252383c15b7100801098b2165e3d2fedd80324d66a89b3d7ab45a9cc1fa6b8823233',
    // this is the action that adds a contact
    'api_action'   => 'contact_add',
    'api_output'   => 'json',
  );

  // This section takes the input fields and converts them to the proper format
  $query = "";
  foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
  $query = rtrim($query, '& ');

  // clean up the url
  $url = rtrim($url, '/ ');

  // define a final API request - GET
  $api = $url . '/admin/api.php?' . $query;

  $contact = array(
    'email' => $email,
    'first_name' => $firstname,
    'last_name' => $lastname,
    // assign to lists:
    'p[5]' => 5, // example list ID (REPLACE '123' WITH ACTUAL LIST ID, IE: p[5] = 5)
    'status[5]' => 1, // 1: active, 2: unsubscribed (REPLACE '123' WITH ACTUAL LIST ID, IE: status[5] = 1)
    'instantresponders[123]' => 1, // set to 0 to if you don't want to sent instant autoresponders
  );
  
  //$response = wp_remote_post($url, $params);
  $response = wp_remote_post($api, array(
    'method' => 'POST',
    'body' => $contact,
    'cookies' => array()
   ));

  if ( is_wp_error( $response ) ) {
    $error_message = $response->get_error_message();
    echo __("Something went wrong: ", "cdash") . $error_message;
  } else {
    $responseBody = json_decode($response['body']);
     echo $responseBody->result_message . "<br />";
  }
}
?>
