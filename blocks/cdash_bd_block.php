<?php 
//Business Directory Shortcode rendering
if ( function_exists( 'register_block_type' ) ) {
    // Hook server side rendering into render callback
    register_block_type(
      'cdash-bd-blocks/business-directory', [
            'render_callback' => 'cdash_bus_directory_block_callback',
            'attributes'  => array(
              'align'  => array(
                    'type'  => 'string',
                    'default' => 'center',
                ),
                'textAlignment' =>  array(
                    'type'  =>  'string',
                    'default'   =>  'left',
                ),
                'cd_block'  => array(
                    'type'  => 'string',
                    'default' => 'yes',
                ),
                'postLayout'    => array(
                    'type'  => 'string',
                    'default'   => 'grid3',
                ),
                'format'    => array(
                    'type'  => 'string',
                    'default'   => 'grid3',
                ),
                'categoryArray'    => array(
                    'type'  => 'array',
                    'default'   => [],
                    'items'   => [
                        'type' => 'string',
                    ],
                ),
                'category'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'tags'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'membershipLevelArray'    => array(
                    'type'  => 'array',
                    'default'   => [],
                    'items'   => [
                        'type' => 'string',
                    ],
                ),
                'level'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'displayPostContent'=> array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'text'    => array(
                    'type'  => 'string',
                    'default'   => 'none',
                ),
                'display'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'singleLinkToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'single_link'    => array(
                    'type'  => 'string',
                    'default'   => 'yes',
                ),
                'perpage'    => array(
                    'type'  => 'number',
                    'default'   => -1,
                ),
                'orderby'    => array(
                    'type'  => 'string',
                    'default'   => 'title',
                ),
                'order'    => array(
                    'type'  => 'string',
                    'default'   => 'asc',
                ),
                'image'    => array(
                    'type'  => 'string',
                    'default'   => 'featured',
                ),
                'membershipStatusArray'    => array(
                    'type'  => 'array',
                    'default'   => [],
                    'items'   => [
                        'type' => 'string',
                    ],
                ),
                'status'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'image_size'    => array(
                    'type'  => 'string',
                    'default'   => 'medium',
                ),
                'alphaToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'alpha'    => array(
                    'type'  => 'string',
                    'default'   => 'no',
                ),
                'logo_gallery'    => array(
                    'type'  => 'string',
                    'default'   => 'no',
                ),
                'categoryFilterToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'show_category_filter'    => array(
                    'type'  => 'string',
                    'default'   => 'no',
                ),
                'displayAddressToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayUrlToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayPhoneToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayEmailToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayCategoryToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayTagsToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayLevelToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displaySocialMediaLinkToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displaySocialMediaIconsToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayLocationNameToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayHoursToggle'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'changeTitleFontSize'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'titleFontSize'    => array(
                    'type'  => 'number',
                    'default'   => 16,
                ),
                'disablePagination'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'displayImageOnTop'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'enableBorder'    => array(
                    'type'  => 'boolean',
                    'default'   => 'false',
                ),
                'borderColor'    => array(
                    'type'  => 'string',
                    'default'   => '#000000',
                ),
                'borderThickness'    => array(
                    'type'  => 'number',
                    'default'   => '1',
                ),
                'borderStyle'    => array(
                    'type'  => 'string',
                    'default'   => 'solid',
                ),
                'borderRadius'    => array(
                    'type'  => 'number',
                    'default'   => '0',
                ),
                'borderRadiusUnits'    => array(
                    'type'  => 'string',
                    'default'   => 'px',
                ),
            ),
        ]
    );
}

function cdash_set_display_options($attributes, $displayOptions, $toggle_name, $string_value){
  if(isset($attributes[$toggle_name]) && $attributes[$toggle_name] === true){
      array_push($displayOptions, $string_value);
  }
  return $displayOptions;
}

function cdash_bus_directory_block_callback($attributes){

  $displayOptions = [];

  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayAddressToggle', 'address');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayUrlToggle', 'url');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayPhoneToggle', 'phone');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayEmailToggle', 'email');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayCategoryToggle', 'category');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayTagsToggle', 'tags');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayLevelToggle', 'level');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displaySocialMediaIconsToggle', 'social_media');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayLocationNameToggle', 'location_name');
  $displayOptions = cdash_set_display_options($attributes, $displayOptions, 'displayHoursToggle', 'hours');


  $attributes['display'] = implode(',', $displayOptions);

  if(isset($attributes['categoryArray']) && '' != $attributes['categoryArray']){
      $attributes['category'] = $attributes['categoryArray'];
  }

  if(isset($attributes['membershipLevelArray']) && '' != $attributes['membershipLevelArray']){
      $attributes['level'] = $attributes['membershipLevelArray'];
  }
  if(cdash_check_mm_active()){
      if(isset($attributes['membershipStatusArray']) && '' != $attributes['membershipStatusArray']){
          $attributes['status'] = implode(',', $attributes['membershipStatusArray']);
      }
  }else{
      $attributes['status'] = '';
  }

  $business_listings = cdash_business_directory_shortcode($attributes);

  return $business_listings;

}
?>