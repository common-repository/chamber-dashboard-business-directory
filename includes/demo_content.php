<?php
//If plugin is activated for the first time, set the transient
function cdash_show_demo_buttons(){
  //$demo_content_install = get_transient('cdash_demo_content_install');
  if(false === get_transient('cdash_demo_content_install')){
    //show the Install Demo Content button
    cdash_install_demo_content_button();
  }
  set_transient('cdash_demo_content_install', 'true');
}

function cdash_set_demo_transient(){
  set_transient('cdash_demo_content_install', 'true');
}

add_action( 'upgrader_process_complete', 'cdash_set_demo_transient');

function cdash_install_demo_content_button(){
  ?>
  <div id="demo_content_buttons">
    <p><?php esc_html_e("Welcome to the Business Directory plugin! Install demo content now, then check out the Business Directory page to see a sample Directory, or dismiss this notice to get started with uploading your own listings.", "cdash"); ?></p>
    <p class="demo_content button cdash_admin button-primary"><?php esc_html_e("Install Demo Content", "cdash"); ?></p>
    <p class="demo_content_decline button cdash_admin button-primary"><?php esc_html_e("No Thanks!", "cdash"); ?></p>
    <p id="loader"><?php esc_html_e("Loading...", "cdash"); ?></p>
    <p class="cdash_demo_success_message"></p>
  </div>
  <?php
}

function cdash_add_demo_data(){
  $response = '';

  //Create demo business categories
  cdash_demo_bus_categories();

  $demo_post_id = cdash_insert_demo_business();
  $demo_page_id = cdash_add_demo_pages();

  if ( ($demo_post_id != 0) || $demo_page_id !=0 )
    {
        $response = __('Demo data successfully added.', 'cdash');
        flush_rewrite_rules();
    }
    else {
        $response = __('The data already exists.', 'cdash');
    }
    // Return the String
    die($response);
}

// creating Ajax call for WordPress
add_action( 'wp_ajax_cdash_add_demo_data', 'cdash_add_demo_data' );

function cdash_demo_bus_categories(){
  $taxonomy = 'business_category';
  //Create Taxonomy Terms
  $term_one = term_exists( 'Restaurants', $taxonomy );
  if ( 0 == $term_one || null == $term_one ) {
    wp_insert_term( 'Restaurants', $taxonomy );
  }

  $term_two = term_exists( 'Restaurants', $taxonomy );
  if ( 0 == $term_two || null == $term_two ) {
    wp_insert_term( 'Retail Shops', $taxonomy );
  }
}

function cdash_insert_demo_business(){
  //Code to create a post with demo data
  global $wpdb;
  $user_id = get_current_user_id();
  // Create post object
  $demo_content = __("Create a description for your business here, or install the Member Updater plugin so your members can update their own listings!", "cdash");

  $demo_bus_data = array(
    array (
      'title' => __('Karleton’s Bakery', 'cdash'),
      'content' => $demo_content,
      'post_category' => 'Restaurants',
      'featured_image' => 'images/demo_content/bakery_photogy-karlis-dambrans.jpg',
      'address' => '1000 4th Avenue',
      'city'  => 'Seattle',
      'state' =>  'WA',
      'zip' => '98104',
      'country' => 'USA'
    ),
    array (
      'title' => __('Wong’s Coffee & Tea','cdash'),
      'content' => $demo_content,
      'post_category' => 'Restaurants',
      'featured_image' =>'images/demo_content/coffee_shopphotoby-jason-wong.jpg',
      'address' => '1912 Pike Place',
      'city'  => 'Seattle',
      'state' =>  'WA',
      'zip' => '98101',
      'country' => 'USA'
    ),
    array (
      'title' => __('Brendon’s Camera', 'cdash'),
      'content' => $demo_content,
      'post_category' => 'Retail Shops',
      'featured_image' =>'images/demo_content/camera_shop_photoby-brendan-church.jpg',
      'address' => '704 Terry Ave',
      'city'  => 'Seattle',
      'state' =>  'WA',
      'zip' => '98104',
      'country' => 'USA'
    ),
  );

  foreach ($demo_bus_data as $bus_demo) {
    if ( post_exists( $bus_demo['title'] ) ) {
      $demo_post_id = 0;
    }else{
      //post exists
      $add_pages = array(
          'post_title' => $bus_demo['title'],
          'post_content' => $bus_demo['content'],
          'post_status' => 'publish',
          'post_type' => 'business'
      );

      // Insert the post into the database
      $demo_post_id = wp_insert_post( $add_pages );

      wp_set_object_terms( $demo_post_id, $bus_demo['post_category'], 'business_category', $append );

      // add a serialised array for wpalchemy to work - see http://www.2scopedesign.co.uk/wpalchemy-and-front-end-posts/
      $fields = array('_cdash_location');
      $str = $fields;
      update_post_meta( $demo_post_id, 'buscontact_meta_fields', $str );

      $address = $bus_demo['address'];
      $city = $bus_demo['city'];
      $state = $bus_demo['state'];
      $zip = $bus_demo['zip'];
      $country = $bus_demo['country'];

      // Get the geolocation data
      if( isset( $address ) ) {
        // ask Google for the latitude and longitude
        $rawaddress = $address;
      }
      if( isset( $city ) ) {
        $rawaddress .= ' ' . $city;
      }
      if( isset( $state ) ) {
        $rawaddress .= ' ' . $state;
      }
      if( isset( $zip ) ) {
        $rawaddress .= ' ' . $zip;
      }
      $bus_address = urlencode( $rawaddress );
      $json = wp_remote_get(cdash_get_google_map_url($bus_address));
      $json = json_decode($json['body'], true);
      if( is_array( $json ) && $json['status'] == 'OK') {
        $latitude = $json['results'][0]['geometry']['location']['lat'];
        $longitude = $json['results'][0]['geometry']['location']['lng'];
      }

      // Create the array of location information for wpalchemy
      $locationfields = array(
          array(
          'altname' 	=> '',
          'address'	=> $address,
          'city'		=> $city,
          'state'		=> $state,
          'zip'		  => $zip,
          'country'   => $country,
          'hours'     => '',
          'latitude'	=> $latitude,
          'longitude'	=> $longitude,
          'url'		=> '',
          'phone'		=> '',
          'email'		=> '',
          )
        );

      // Add all of the post meta data in one fell swoop
      add_post_meta( $demo_post_id, '_cdash_location', $locationfields );

      //attach the image files as featured image for each post
      $getImageFile = plugins_url( $bus_demo['featured_image'], dirname(__FILE__) );
      $url = $getImageFile;
      $attach_id = cdash_insert_attachment_from_url($url, $demo_post_id);
      set_post_thumbnail( $demo_post_id, $attach_id );

    }
  }
  return $demo_post_id;
}

//Code taken from https://gist.github.com/m1r0/f22d5237ee93bcccb0d9
function cdash_insert_attachment_from_url($url, $parent_post_id) {
	if( !class_exists( 'WP_Http' ) )
		include_once( ABSPATH . WPINC . '/class-http.php' );
	$http = new WP_Http();
	$response = $http->request( $url );
	if( $response['response']['code'] != 200 ) {
		return false;
	}
	$upload = wp_upload_bits( basename($url), null, $response['body'] );
	if( !empty( $upload['error'] ) ) {
		return false;
	}
	$file_path = $upload['file'];
	$file_name = basename( $file_path );
	$file_type = wp_check_filetype( $file_name, null );
	$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
	$wp_upload_dir = wp_upload_dir();
	$post_info = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $file_name,
		'post_mime_type' => $file_type['type'],
		'post_title'     => $attachment_title,
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	// Create the attachment
	$attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );
	// Include image.php
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	// Define attachment metadata
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
	// Assign metadata to attachment
	wp_update_attachment_metadata( $attach_id,  $attach_data );
	return $attach_id;
}

function cdash_add_demo_pages(){
  //Code to create a post with demo data
  global $wpdb;
  $user_id = get_current_user_id();
  $member_page_content = '<a href="https://chamberdashboard.com/add-ons/" target="_blank">Member Manager</a>';
  // Create post object
    $demo_bus_pages = array(
    array (
      'title' => __('Business Directory','cdash'),
      'content' => '[business_directory format="grid3" display="url, email, category" image="featured" description="none"]',
    ),
    array (
      'title' => __('Become a Member', 'cdash'),
      'content' => __('Install the free ' . $member_page_content .  ' plugin now. Accept online payments 24/7. Automatically create new listings in your Business Directory.', 'cdash')
    ),
  );

  foreach ($demo_bus_pages as $demo_page) {
    if ( post_exists( $demo_page['title'] ) ) {
      $demo_page_id = 0;
    }else{
      //post exists
      $add_pages = array(
          'post_title' => $demo_page['title'],
          'post_content' => $demo_page['content'],
          'post_status' => 'publish',
          'post_type' => 'page'
      );

      // Insert the post into the database
      $demo_page_id = wp_insert_post( $add_pages );
    }
  }
  return $demo_page_id;
}
?>
