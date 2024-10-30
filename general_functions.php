<?php

//Check if the checkbox or radio button options are set and equal to 1
function cdash_is_option_selected_checkbox($plugin_options, $option_name) {
	$options = get_option( $plugin_options );
  return isset($options[$option_name]) && ($options[$option_name] == 1);
}

//Check if an option is set and not null
function cdash_is_option_selected($plugin_options, $option_name) {
	$options = get_option( $plugin_options );
  return isset($options[$option_name]) && ($options[$option_name] !='');
}

//Get the page url from the dropdown page selector
function cdash_get_page_url($plugin_options, $option_name){
    $options = get_option($plugin_options);
    if(cdash_is_option_selected($plugin_options, $option_name)){
      $login_page_id = $options[$option_name];
      $login_page_slug = get_post_field( 'post_name', $login_page_id );
      $site_url = home_url() . '/' . $login_page_slug;
    }else{
      $site_url = '';
    }
    return $site_url;
  }


?>