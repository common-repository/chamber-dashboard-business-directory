<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ------------------------------------------------------------------------
// REQUIRE MINIMUM VERSION OF WORDPRESS:
// ------------------------------------------------------------------------
function cdash_plugins_requires_wordpress_version($plugin_name, $plugin_path) {
    global $wp_version;

  	if ( version_compare($wp_version, "4.6", "<" ) ) {
  		if( is_plugin_active($plugin_path) ) {
  			deactivate_plugins( $plugin_path );
  			wp_die( "'".$plugin_name."' requires WordPress 4.6 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."plugins.php'>WordPress admin</a>." );
  		}
  	}
}

//Plugin Update Message
function cdash_update_message(){
  $settings_url = get_admin_url() . 'admin.php?page=chamber-dashboard-business-directory/options.php#google_maps_api';
  $hide_notice_url = get_admin_url() . 'plugins.php?cdash_update_message_ignore=0';
  global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'cdash_update_message_ignore') ) {
    echo '<div class="notice notice is-dismissible cdashrc_update cdash_update_notice"><p>';
    printf(__('If you’d like to display maps in your Directory, you’ll need to generate a new Google Maps API Key and add it in the <a href="' . $settings_url . '">settings</a> page. | <a href="' . $hide_notice_url . '">Hide Notice</a>'));
    echo "</p></div>";
	}
}

add_action( 'admin_notices', 'cdash_update_message' );

function cdash_update_message_ignore() {
	global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['cdash_update_message_ignore']) && '0' == $_GET['cdash_update_message_ignore'] ) {
         add_user_meta($user_id, 'cdash_update_message_ignore', 'true', true);
    }
}
add_action('admin_init', 'cdash_update_message_ignore');

//Get the Google Maps API Key
function cdash_get_google_maps_api_key(){
  $options = get_option( 'cdash_directory_options' );
  $google_map_api_key = $options['google_maps_api'];
  return $google_map_api_key;
}

//Get the Google Maps Server API Key
function cdash_get_google_maps_server_api_key(){
  $options = get_option( 'cdash_directory_options' );
  $google_map_api_key = $options['google_maps_api'];
  $google_maps_server_api_key = $options['google_maps_server_api'];
  if(!$google_maps_server_api_key || $google_maps_server_api_key == ''){
      $google_maps_server_api_key = $google_map_api_key;
  }
  return $google_maps_server_api_key;
}

function cdash_get_google_map_url($address) {
  $google_maps_server_api_key = cdash_get_google_maps_server_api_key();
    return "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . $google_maps_server_api_key;
}

// ask Google for the latitude and longitude
function cdash_get_lat_long($address, $city, $state, $zip, $country) {
  $rawaddress = $address;
  if( isset( $city ) ) {
   $rawaddress .= ' ' . $city;
  }
  if( isset( $state ) ) {
    $rawaddress .= ' ' . $state;
  }
  if( isset( $zip ) ) {
    $rawaddress .= ' ' . $zip;
  }
  if( isset( $country ) ) {
    $rawaddress .= ' ' . $country;
  }
  $address = urlencode( $rawaddress );
  $url = cdash_get_google_map_url($address);
  $response = wp_remote_get($url);
  if( is_wp_error( $response ) ) {
	return false; // Bail early
  }
  $body = wp_remote_retrieve_body( $response );
  $data = json_decode( $body, true );
  $lat = 0;
  $lng = 0;
  if(!empty($data && $data['status'] !== 'REQUEST_DENIED')){
      if(is_array($data)){
        $lat = $data['results'][0]['geometry']['location']['lat'];
        $lng = $data['results'][0]['geometry']['location']['lng'];
      }else{
        $lat = '';
        $lng = '';
      }
  }else{
  }
  return array($lat, $lng);
}

function cd_debug($message) {
  cd_log_message(1, $message);
}

function cd_info($message) {
  cd_log_message(2, $message);
}

function cd_warn($message) {
  cd_log_message(3, $message);
}

function cd_error($message) {
  cd_log_message(4, $message);
}

function cd_log_message($level, $message) {
  if(defined('CHAMBER_DASHBOARD_DEBUG_LEVEL') && defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    if($level >= CHAMBER_DASHBOARD_DEBUG_LEVEL) {
      error_log($message);
    }
  }
}
function display_categories_grid($taxonomies, $showcount, $showCatImage, $showCatDesc, $hierarchical, $align_class, $depth, $child_of){
    $maxdepth = ($depth == 0) ? 99 : $depth;
    $output = '<div class="business_category responsive ' . $align_class . '">';
    if ( !empty($taxonomies) ) {
        foreach( $taxonomies as $category ) {
            if($showcount == 1){
                $num_posts = " (" . $category->count . ")";
            }else{
                $num_posts = '';
            }
            if( $hierarchical == 1 ) {
                if($category->parent == $child_of){ //These are parent categories
                    $output .= '<div class="cdash_parent_category"><div><a class="cdash_pc_link" href="'. get_term_link($category->slug, 'business_category') .'"><b>' . esc_attr( $category->name ) . '</b></a><span class="number_posts">' . $num_posts . '</span></div>';
                    $childcats = get_child_category_list($taxonomies, $showcount, $showCatImage, $showCatDesc, $category, 1, $maxdepth);
                    $output .= join(", ", $childcats );
                    $output.='</div>';
                }
            }else{
                $output.= '<div class="cdash_parent_category"><div><a class="cdash_pc_link" href="'. get_term_link($category->slug, 'business_category') .'"><b>' . esc_attr( $category->name ) . '</b></a><span class="number_posts">' . $num_posts . '</span></div>';
                $taxonomy_output = array();
                foreach( $taxonomies as $subcategory ) {
                    if($subcategory->parent == $category->term_id) {
                        if($showcount == 1){
                            $num_posts = " (" . $subcategory->count . ")";
                        }else{
                            $num_posts = '';
                        }
                    }
                }
                $output.='</div>';
            }        
        }
    }else{
        $output .= "No Categories found.";
    }
    $output .= '</div>';
    return $output;
}

function get_child_category_list($taxonomies, $showcount, $showCatImage, $showCatDesc, $parent, $curdepth, $maxdepth) {
    $ret = array();
    if ($curdepth < $maxdepth) {
        foreach($taxonomies as $subcat) {
            if ($subcat->parent === $parent->term_id) {
                $ret[] = '<span class="cdash_child_category_' . $curdepth . '">'
                             . '<a class="cdash_cc_link" href="' 
                             . get_term_link($subcat->slug, 'business_category') 
                             . '">'
                             . esc_html( $subcat->name ) 
                             .'</a>' 
                             . (($showcount == 1) ? " (" . $subcat->count . ")" : '') 
                             . '</span>';
                $childcats = get_child_category_list($taxonomies, $showcount, $showCatImage, $showCatDesc, $subcat, $curdepth+1, $maxdepth);
                $ret = array_merge($ret, $childcats);
            }
        }
    }
    return $ret;
}

function cdash_display_categories_dropdown($args){
  //if ( !empty($taxonomies) ) :

    //$output = '<li id="categories">';
    $output = '';
    $output .= wp_dropdown_categories( $args );
    ?>

      <?php
    //$output .= '</li>';

    return $output;
//endif;
?>

<?php
}

// ------------------------------------------------------------------------
// CHECK IF MEMBER UPDATER IS ACTIVE
// ------------------------------------------------------------------------
function cdash_is_member_updater_active(){
    /**
 * Detect plugin. For use on Front End only.
 */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(is_plugin_active('chamber-dashboard-member-updater/cdash-member-updater.php')){
        return true;
    }else{
        return false;
    }
}

function cdash_enqueue_styles(){
  wp_enqueue_style( 'cdash-business-directory', plugins_url( 'css/cdash-business-directory.css', dirname(__FILE__) ), '', null );
  wp_enqueue_style( 'cdash-business-directory', plugins_url( 'css/cdash-business-directory-old.css', dirname(__FILE__) ), '', null );
  
}

function cdash_enqueue_scripts(){
  wp_enqueue_script( 'cdash-business-directory', plugins_url( 'js/cdash-business-directory.js', dirname(__FILE__) ) );
}

function cdash_admin_scripts() {
  //wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
  wp_enqueue_script('jquery-ui');
  wp_enqueue_script( 'jquery-ui-dialog' );
  wp_enqueue_script(' jquery-ui-draggable');

  //wp_enqueue_script( 'cdash-demo-content', plugins_url( 'js/cdash_demo_content.js', dirname(__FILE__) ) );
  wp_enqueue_script( 'cdash-demo-content', plugins_url( 'js/cdash_demo_content.js', dirname(__FILE__)), 'jquery-ui');
}

add_action('admin_enqueue_scripts', 'cdash_admin_scripts');
//add_action( 'admin_init', 'cdash_admin_scripts' );

function cdash_demo_content_styles(){
  //wp_enqueue_style('jquery-ui-styles', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');
  wp_enqueue_style('jquery-ui-styles', plugins_url('css/jquery_ui_smoothness_theme_css.css', dirname(__FILE__)));
  //wp_enqueue_style('jquery-ui-styles',  plugins_url( 'css/jquery_ui.css', dirname(__FILE__)));
}

function cdash_frontend_scripts(){
    wp_enqueue_script( 'cdash-bus-category-filter', plugins_url( 'js/cdash_bus_category_filter.js', dirname(__FILE__)), 'jquery-ui');
}

global $pagenow;
if(isset($_GET['page'])){
  $page = sanitize_text_field($_GET['page']);
}else{
    $page = '';
}
if(isset($_GET['tab'])){
  $tab = sanitize_text_field($_GET['tab']);
}

if($pagenow == 'admin.php' && $page == 'cdash-about' && $tab == 'cdash-about'){
  add_action('admin_enqueue_scripts', 'cdash_demo_content_styles');
  //add_action( 'admin_init', 'cdash_demo_content_styles' );
}

function cdash_check_license_message($license_validity, $site_count, $license_limit, $license_expiry_date){
  $message = '';
  if($license_validity == 'valid'){
    $message .= '<p class="license_information" style="font-style:italic; font-size:12px;"><span class="cdash_active_license" style="color:green;">';
    $message .= __( 'Your license key is active. ' );
    $message .= '</span>';

    if(isset($license_expiry_date) && $license_expiry_date != 'lifetime'){
      $message .= __( 'It expires on ' . date_i18n( get_option( 'date_format' ), strtotime( $license_expiry_date, current_time( 'timestamp' ) ) ) );
    }
     $message .=  __(' You have ' . $site_count .'/' .$license_limit . ' sites active.' );
     $message .= '</p>';
  }elseif($license_validity == 'invalid'){
    $message .= '<p class="license_information" style="font-style:italic; font-size:12px;"><span class="cdash_inactive_license" style="color:red;">';
    $message .= __( 'Your license key is not active.' );
    $message .= '</span></p>';
  }
  return $message;
}

function cdash_display_page_select_dropdown($name, $id, $option_name, $disabled){
    $select_dropdown = '';
    $select_dropdown .= '<select name="' . $name . '" id="' . $id . '"' . $disabled .'>
      <option value="">' . esc_attr( __( 'Select page' ) ) . '</option>';
          $selected_page = $option_name;
          $pages = get_pages();
          foreach ( $pages as $page ) {
              $select_dropdown .= '<option value="' . $page->ID . '" ';
              $select_dropdown .= ( $page->ID == $selected_page ) ? 'selected="selected"' : '';
              $select_dropdown .= '>';
              $select_dropdown .= $page->post_title;
              $select_dropdown .= '</option>';
              //echo $option;
          }
    $select_dropdown .= '</select>';
    return $select_dropdown;
}

//Check if Member Updater is active
function cdash_check_mu_active(){
  if(function_exists('cdashmu_requires_wordpress_version')){
    return true;
  }else{
    return false;
  }
}

//Check if Member Manager is active
function cdash_check_mm_active(){
  if(function_exists('cdashmm_requires_wordpress_version')){
    return true;
  }else{
    return false;
  }
}

function cdash_check_mm_active_ajax(){
  $response = array();
  $response['cdash_mm_active'] = cdash_check_mm_active();
  echo json_encode($response);
  wp_die();
}

add_action('wp_ajax_cdash_check_mm_active_action', 'cdash_check_mm_active_ajax');
add_action('wp_ajax_nopriv_cdash_check_mm_active_action', 'cdash_check_mm_active_ajax');

//Check if CRM is active
function cdash_check_cd_crm_active(){
  if(function_exists('cdash_requires_wordpress_version')){
		$plugins = cdash_get_active_plugin_list();
		if ((in_array('cdash-crm.php', $plugins))) {
			return true;
		}else{
			return false;
		}
	}
}
?>
