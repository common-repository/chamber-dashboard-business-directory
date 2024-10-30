<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_enqueue_scripts', 'cdash_addons_enqueue_scripts' );
function cdash_addons_enqueue_scripts(){
  // enqueue the thickbox scripts and styles
  wp_enqueue_script( 'thickbox' );
  wp_enqueue_style( 'thickbox' );

  wp_enqueue_style( 'addons.css', plugins_url( 'includes/addons.css', __FILE__ ));
	wp_enqueue_style( 'Business directory admin styles', plugins_url( 'css/admin.css', __FILE__ ), '', null);
}

/* Options Page for Chamber Dashboard Business Directory */

// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'cdash_delete_plugin_options')
// --------------------------------------------------------------------------------------

// Delete options table entries ONLY when plugin deactivated AND deleted
function cdash_delete_plugin_options() {
	delete_option('cdash_directory_options');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'cdash_add_defaults')
// ------------------------------------------------------------------------------

// Define default option settings
function cdash_add_defaults() {
	$tmp = get_option('cdash_directory_options');
  if(!isset($tmp['bus_phone_type'])){
    $tmp['bus_phone_type'] = 'Main, Office, Cell';
  }

  if(!isset($tmp['bus_email_type'])){
    $tmp['bus_email_type'] = 'Main, Sales, Accounting, HR';
  }

  if(!isset($tmp['cdash_default_thumb'])){
    $tmp['cdash_default_thumb'] = '';
  }

  if(!isset($tmp['sv_description'])){
    $tmp['sv_description'] = '1';
  }

  if(!isset($tmp['sv_name'])){
    $tmp['sv_name'] = '1';
  }

  if(!isset($tmp['sv_address'])){
    $tmp['sv_address'] = '1';
  }

  if(!isset($tmp['sv_hours'])){
    $tmp['sv_hours'] = '1';
  }

  if(!isset($tmp['sv_map'])){
    $tmp['sv_map'] = '1';
  }

  if(!isset($tmp['sv_url'])){
    $tmp['sv_url'] = '1';
  }

  if(!isset($tmp['sv_phone'])){
    $tmp['sv_phone'] = '1';
  }

  if(!isset($tmp['sv_email'])){
    $tmp['sv_email'] = '1';
  }

  if(!isset($tmp['sv_logo'])){
    $tmp['sv_logo'] = '1';
  }

  if(!isset($tmp['sv_thumb'])){
    $tmp['sv_thumb'] = '1';
  }

  if(!isset($tmp['sv_memberlevel'])){
    $tmp['sv_memberlevel'] = '1';
  }

  if(!isset($tmp['sv_category'])){
    $tmp['sv_category'] = '1';
  }

  if(!isset($tmp['sv_tags'])){
    $tmp['sv_tags'] = '1';
  }

  if(!isset($tmp['sv_social'])){
    $tmp['sv_social'] = '1';
  }

  if(!isset($tmp['sv_comments'])){
    $tmp['sv_comments'] = '1';
  }

  if(!isset($tmp['tax_name'])){
    $tmp['tax_name'] = '1';
  }

  if(!isset($tmp['tax_address'])){
    $tmp['tax_address'] = '1';
  }

  if(!isset($tmp['tax_hours'])){
    $tmp['tax_hours'] = '1';
  }

  if(!isset($tmp['tax_url'])){
    $tmp['tax_url'] = '1';
  }

  if(!isset($tmp['tax_phone'])){
    $tmp['tax_phone'] = '1';
  }

  if(!isset($tmp['tax_email'])){
    $tmp['tax_email'] = '1';
  }

  if(!isset($tmp['tax_logo'])){
    $tmp['tax_logo'] = '1';
  }

  if(!isset($tmp['tax_thumb'])){
    $tmp['tax_thumb'] = '1';
  }

  if(!isset($tmp['tax_category'])){
    $tmp['tax_category'] = '1';
  }

  if(!isset($tmp['tax_tags'])){
    $tmp['tax_tags'] = '1';
  }

  if(!isset($tmp['tax_social'])){
    $tmp['tax_social'] = '1';
  }

  if(!isset($tmp['tax_orderby_name'])){
    $tmp['tax_orderby_name'] = '1';
  }

  if(!isset($tmp['sm_display'])){
    $tmp['sm_display'] = 'icons';
  }

  if(!isset($tmp['sm_icon_size'])){
    $tmp['sm_icon_size'] = '32px';
  }

  if(!isset($tmp['currency'])){
    $tmp['currency'] = 'USD';
  }

  if(!isset($tmp['currency_symbol'])){
    $tmp['currency_symbol'] = '$';
  }

  if(!isset($tmp['currency_position'])){
    $tmp['currency_position'] = 'before';
  }

  if(!isset($tmp['search_results_per_page'])){
    $tmp['search_results_per_page'] = '5';
  }

  if(!isset($tmp['business_listings_url'])){
    $tmp['business_listings_url'] = '';
  }

  if(!isset($tmp['business_listings_url_text'])){
    $tmp['business_listings_url_text'] = 'Return to Business Listings';
  }

  if(!isset($tmp['google_maps_api'])){
    $tmp['google_maps_api'] = '';
  }

  if(!isset($tmp['google_maps_server_api'])){
    $tmp['google_maps_server_api'] = '';
  }

  update_option('cdash_directory_options', $tmp);
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'cdash_init' )
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_init' HOOK FIRES, AND REGISTERS YOUR PLUGIN
// SETTING WITH THE WORDPRESS SETTINGS API. YOU WON'T BE ABLE TO USE THE SETTINGS
// API UNTIL YOU DO.
// ------------------------------------------------------------------------------

// Init plugin options to white list our options
function cdash_init(){
	register_setting( 'cdash_plugin_options', 'cdash_directory_options', 'cdash_validate_options' );
	register_setting( 'cdash_plugin_version', 'cdash_directory_version', 'cdash_validate_options' );
  //register_setting( 'cdash_plugin_options', 'cdash_directory_options', 'cdash_handle_file_upload' );

}

// ------------------------------------------------------------------------------
// ADDING SECTIONS AND FIELDS TO THE SETTINGS PAGE
// ------------------------------------------------------------------------------
add_action( 'admin_init', 'cdash_options_init' );

function cdash_options_init(){

  add_settings_section(
    'cdash_options_main_section',
    __('General Directory Settings', 'cdash'),
    'cdash_general_settings_callback',
    'cdash_plugin_options'
  );

  add_settings_section(
    'cdash_options_single_view_section',
    __('Single Business View Options', 'cdash'),
    'cdash_single_business_view_text_callback',
    'cdash_plugin_options'
  );

  add_settings_section(
    'cdash_options_tax_view_section',
    __('Category/Membership Level View Options', 'cdash'),
    'cdash_taxonomy_view_text_callback',
    'cdash_plugin_options'
  );

  add_settings_section(
    'cdash_options_misc_view_section',
    __('Other Settings', 'cdash'),
    'cdash_options_misc_view_text_callback',
    'cdash_plugin_options'
  );

  add_settings_field(
    'bus_phone_type',
    __( 'Phone Number Types', 'cdash' ),
    'cdash_bus_phone_type_render',
    'cdash_plugin_options',
    'cdash_options_main_section',
    array(
      __( 'When you enter a phone number for a business, you can choose what type of phone number it is.  The default options are "Main, Office, Cell".  To change these options, enter a comma-separated list here.  (Note: your entry will over-ride the default, so if you still want main and/or office and/or cell, you will need to enter them.', 'cdash' )
    )
  );

  add_settings_field(
    'bus_email_type',
    __( 'Email Types', 'cdash' ),
    'cdash_bus_email_type_render',
    'cdash_plugin_options',
    'cdash_options_main_section',
    array(
      __( 'When you enter an email address for a business, you can choose what type of email address it is.  The default options are "Main, Sales, Accounting, HR".  To change these options, enter a comma-separated list here.  (Note: your entry will over-ride the default, so if you still want main and/or sales and/or accounting and/or HR, you will need to enter them.', 'cdash' )
    )
  );

  add_settings_field(
    'cdash_default_thumb',
    __( 'Default Featured Image for businesses', 'cdash' ),
    'cdash_default_thumb_render',
    'cdash_plugin_options',
    'cdash_options_main_section',
    array(
      __( 'This image will show up as the default featured image for any business that does not have a featured image.', 'cdash' )
    )
  );

  add_settings_field(
    'sv_description',
    __( 'Description', 'cdash' ),
    'cdash_sv_description_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_name',
    __( 'Location Name', 'cdash' ),
    'cdash_sv_name_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( 'Note: you can hide individual locations in the "edit business" view.', 'cdash' )
    )
  );

  add_settings_field(
    'sv_address',
    __( 'Location Address', 'cdash' ),
    'cdash_sv_address_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_hours',
    __( 'Location Hours', 'cdash' ),
    'cdash_sv_hours_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_map',
    __( 'Map', 'cdash' ),
    'cdash_sv_map_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( 'To display maps in your Directory, you’ll need to generate a new Google Maps API Key, scroll down for details.', 'cdash' )
    )
  );

  add_settings_field(
    'sv_url',
    __( 'Location Web Address', 'cdash' ),
    'cdash_sv_url_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_phone',
    __( 'Phone Number(s)', 'cdash' ),
    'cdash_sv_phone_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_email',
    __( 'Email Address(es)', 'cdash' ),
    'cdash_sv_email_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_logo',
    __( 'Logo', 'cdash' ),
    'cdash_sv_logo_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_thumb',
    __( 'Featured Image', 'cdash' ),
    'cdash_sv_thumb_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( 'Your theme might already display the featured image.  If it does not, you can check this box to display the featured image', 'cdash' )
    )
  );

  add_settings_field(
    'sv_memberlevel',
    __( 'Membership Level', 'cdash' ),
    'cdash_sv_memberlevel_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_category',
    __( 'Business Categories', 'cdash' ),
    'cdash_sv_category_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_tags',
    __( 'Business Tags', 'cdash' ),
    'cdash_sv_tags_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_social',
    __( 'Social Media Links', 'cdash' ),
    'cdash_sv_social_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sv_comments',
    __( 'Comments', 'cdash' ),
    'cdash_sv_comments_render',
    'cdash_plugin_options',
    'cdash_options_single_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_name',
    __( 'Location Name', 'cdash' ),
    'cdash_tax_name_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( 'Note: you can hide individual locations in the "edit business" view.', 'cdash' )
    )
  );

  add_settings_field(
    'tax_address',
    __( 'Location Address', 'cdash' ),
    'cdash_tax_address_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_hours',
    __( 'Location Hours', 'cdash' ),
    'cdash_tax_hours_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_url',
    __( 'Location Web Address', 'cdash' ),
    'cdash_tax_url_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_phone',
    __( 'Phone Number(s)', 'cdash' ),
    'cdash_tax_phone_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_email',
    __( 'Email Address(es)', 'cdash' ),
    'cdash_tax_email_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_logo',
    __( 'Logo', 'cdash' ),
    'cdash_tax_logo_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_thumb',
    __( 'Featured Image', 'cdash' ),
    'cdash_tax_thumb_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( 'Your theme might already display the featured image.  If it does not, you can check this box to display the featured image.', 'cdash' )
    )
  );

  add_settings_field(
    'tax_memberlevel',
    __( 'Membership Level', 'cdash' ),
    'cdash_tax_memberlevel_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_category',
    __( 'Business Categories', 'cdash' ),
    'cdash_tax_category_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_tags',
    __( 'Business Tags', 'cdash' ),
    'cdash_tax_tags_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_social',
    __( 'Social Media Links', 'cdash' ),
    'cdash_tax_social_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'tax_orderby_name',
    __( 'Order category pages by business name (default order is by publication date)', 'cdash' ),
    'cdash_tax_orderby_name_render',
    'cdash_plugin_options',
    'cdash_options_tax_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'sm_display',
    __( 'Social Media Display', 'cdash' ),
    'cdash_sm_display_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'currency',
    __( 'Currency', 'cdash' ),
    'cdash_currency_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Select the currency that will be used on invoices.', 'cdash' )
    )
  );

  add_settings_field(
    'currency_symbol',
    __( 'Currency Symbol', 'cdash' ),
    'cdash_currency_symbol_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the symbol that should appear next to all currency.', 'cdash' )
    )
  );

  add_settings_field(
    'currency_position',
    __( 'Currency Position', 'cdash' ),
    'cdash_currency_position_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( '', 'cdash' )
    )
  );

  add_settings_field(
    'search_results_per_page',
    __( 'Search Results Per Page', 'cdash' ),
    'cdash_search_results_per_page_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the number of search results you would like to display per page.', 'cdash' )
    )
  );

  add_settings_field(
    'business_listings_url',
    __( 'Business Listings URL', 'cdash' ),
    'cdash_business_listings_url_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the url for your business listings page here. It will be displayed on the single business pages so that users can navigate back to the business listings page.', 'cdash' )
    )
  );

  add_settings_field(
    'business_listings_url_text',
    __( 'Business Listings URL text', 'cdash' ),
    'cdash_business_listings_url_text_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the text you want to show for the Return to Business Listings link on the single business page.', 'cdash' )
    )
  );

  add_settings_field(
    'google_maps_api',
    __( 'Google Maps Browser API Key', 'cdash' ),
    'cdash_google_maps_api_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the Google Maps API Key. You can find the instructions <a href="https://chamberdashboard.com/docs/plugin-features/business-directory/google-maps-api-key/" target="_blank">here</a>.', 'cdash' )
    )
  );

  add_settings_field(
    'google_maps_server_api',
    __( 'Google Maps Server API Key', 'cdash' ),
    'cdash_google_maps_server_api_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'Enter the Google Maps Server API Key. You can find the instructions <a href="https://chamberdashboard.com/docs/plugin-features/business-directory/google-maps-api-key/" target="_blank">here</a>.', 'cdash' )
    )
  );

  add_settings_field(
    'cdash_custom_fields',
    __( 'Custom Fields', 'cdash' ),
    'cdash_custom_fields_render',
    'cdash_plugin_options',
    'cdash_options_misc_view_section',
    array(
      __( 'If you need to store additional information about businesses, you can create custom fields here.', 'cdash' )
    )
  );

}

function cdash_general_settings_callback(){
    echo __('<span class="desc"></span>', 'cdash');
}

function cdash_single_business_view_text_callback(){
    echo __('<span class="desc">What information would you like to display on the single business view?</span>', 'cdash');
}

function cdash_taxonomy_view_text_callback(){
  echo __('<span class="desc">What information would you like to display on the category/membership level view?  Note: Chamber Dashboard might not be able to over-ride all of your theme settings (for instance, your theme might show the featured image on category pages).  If you don\'t like how your theme displays category and membership level pages, you might want to create custom pages using the [business_directory] shortcode.  This is more labor-intensive, but gives you more control over appearance.</span>', 'cdash');
}

function cdash_options_misc_view_text_callback(){
    echo __('<span class="desc"></span>', 'cdash');
}

function cdash_bus_phone_type_render( $args ) {
	$options = get_option('cdash_directory_options');
	?>
  <input type='text' name='cdash_directory_options[bus_phone_type]' value='<?php echo $options['bus_phone_type']; ?>'>
	<br /><span class="description"><?php echo $args[0]; ?></span>
	<?php
}

//Check if license page exists in the CD admin menu
function cdash_license_page(){
	/*if ( empty ( $GLOBAL['admin_page_hooks']['chamber_dashboard_license'] ) ){
		add_submenu_page( '/chamber-dashboard-business-directory/options.php', 'Licenses', 'Licenses', 'manage_options', 'chamber_dashboard_license', 'cdash_about_screen' );
	}*/

    if ( empty ( $GLOBAL['admin_page_hooks']['chamber_dashboard_license'] ) ){
		add_submenu_page( '/chamber-dashboard-business-directory/options.php', 'Licenses', 'Licenses', 'manage_options', 'chamber_dashboard_license', 'chamber_dashboard_licenses_page_render' );
	}
}

//Creating the custom hook for adding the license page
function cdash_add_licence_page_menu_hook(){
  do_action('cdash_add_licence_page_menu_hook');
}

//Callback function for add_action('admin_menu', 'cdash_options_page');
function cdash_options_page(){
    // Add the menu item and page
    $page_title = 'Chamber Dashboard';
    $menu_title = 'Chamber Dashboard';
    $capability = 'manage_options';
    $slug = '/cd-settings';
    //$slug = '/chamber-dashboard-business-directory/options.php';
    //$callback = array( $this, 'plugin_settings_page_content' );
    $callback = 'cdash_settings';
    $icon = 'dashicons-admin-plugins';
    $position = 80;
    add_menu_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );

    add_submenu_page( $slug, 'CD Settings', 'CD Settings', 'manage_options', 'cd-settings', '' );
    add_submenu_page( $slug, 'Getting Started', 'Getting Started', 'manage_options', 'cd-welcome', 'cdash_welcome_page' );
    $license_url = get_admin_url() . 'admin.php?page=chamber_dashboard_license';
    $plugins = cdash_get_active_plugin_list();
        if( in_array( 'cdash-recurring-payments.php', $plugins ) || in_array('cdash-member-updater.php', $plugins) || in_array('cdash-exporter.php', $plugins) || in_array('cdash-crm-importer.php', $plugins) || in_array('cdash-member-manager-pro.php', $plugins) || in_array( 'cdash-wc-payments.php', $plugins ) || in_array('cd-mailchimp-addon.php', $plugins) || in_array('cdash-payment-options.php', $plugins) ) {
            add_submenu_page( $slug, 'Licenses', 'Licenses', 'manage_options', 'chamber_dashboard_license', 'chamber_dashboard_licenses_page_render' );
        }
				//cdash_add_licence_page_menu_hook();
    //add_submenu_page( $slug, 'Addons', 'Addons', 'manage_options', 'cd-addons', 'chamber_dashboard_addons_page_render' );

    add_submenu_page( $slug, 'Support', 'Support', 'manage_options', 'cd-settings&tab=support', 'cdash_support_page_render' );
}

//New CD Settings
function cdash_settings(){
    global $cdash_active_tab;
    $cdash_active_tab = isset( $_GET['tab'] ) ? sanitize_text_field($_GET['tab']) : 'directory';
	?>
    <h2 class="nav-tab-wrapper">
	<?php
		do_action( 'cdash_settings_tab' );
	?>
	</h2>
	<?php
		do_action( 'cdash_settings_content' );
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'cdash_add_options_page');
// ------------------------------------------------------------------------------
function cdash_add_options_page() {
	add_menu_page(
		'CD Extensions',
		'CD Extensions',
		'manage_options',
		'/chamber-dashboard-business-directory/options.php',
		'cdash_render_form',
		plugin_dir_url( __FILE__ ) . '/images/cdash-settings.png',
		85
	);

	// this is a hidden submenu page for updating geolocation data
	add_submenu_page( NULL, 'Update Geolocation Data', 'Update Geolocation Data', 'manage_options', 'chamber-dashboard-update-geolocation', 'cdash_update_geolocation_data_page' );
}

// Render the Plugin options form
function cdash_render_form() {
    ?>
    <?php chamber_dashboard_addons_page_render(); ?>
    <?php $addons_url = get_admin_url() . 'admin.php?page=cd-addons'; ?>
    <!--<h4><?php echo __('Chamber Dashboard provides you with a suite of plugins that enable you to build a powerful membership site. You can checkout our additional plugins in the <a href="'.$addons_url.'">addons</a> page.', 'cdash'); ?></h4>-->

    <?php
	}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function cdash_validate_options($input) {
	// delete the old custom fields
	delete_option('cdash_directory_options');
	$input['bus_phone_type'] =  wp_filter_nohtml_kses($input['bus_phone_type']);
	$input['bus_email_type'] =  wp_filter_nohtml_kses($input['bus_email_type']);
	if( isset( $input['currency_symbol'] ) ) {
		$input['currency_symbol'] =  wp_filter_nohtml_kses($input['currency_symbol']);
	}

  if( isset( $input['business_listings_url'] ) ) {
		$input['business_listings_url'] =  esc_url_raw($input['business_listings_url']);
	}

  if( isset( $input['business_listings_url_text'] ) ) {
		$input['business_listings_url_text'] =  wp_filter_nohtml_kses($input['business_listings_url_text']);
	}

  if( isset( $input['cdash_default_thumb'] ) ){
    $input['cdash_default_thumb'] = esc_url_raw( cdash_sanitize_image( $input['cdash_default_thumb'] ) );
  }
	return $input;
}

function cdash_sanitize_image( $input ){

    /* default output */
    $output = '';

    /* check file type */
    $filetype = wp_check_filetype( $input );
    $mime_type = $filetype['type'];

    /* only mime type "image" allowed */
    if ( strpos( $mime_type, 'image' ) !== false ){
        $output = $input;
    }

    return $output;
}

add_action( 'admin_init', 'cdash_watch_for_export' );
function cdash_watch_for_export() {
	if( isset( $_POST['cdash_export'] ) && 'cdash_do_export' == $_POST['cdash_export'] ) {
		require_once( dirname(__FILE__) . '/export.php' );
		cdash_simple_export();
        exit();
	}
}
?>
