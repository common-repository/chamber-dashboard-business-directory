<?php 
//Business Directory Shortcode rendering
if ( function_exists( 'register_block_type' ) ) {
    // Hook server side rendering into render callback
  register_block_type(
      'cdash-bd-blocks/logo-gallery', [
          'render_callback' => 'cdash_logo_gallery_block_callback',
          'attributes'  => array(
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
                  'default'   => 'logo',
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
              'alpha'    => array(
                  'type'  => 'string',
                  'default'   => 'no',
              ),
              'logo_gallery'    => array(
                  'type'  => 'string',
                  'default'   => 'yes',
              ),
              'show_category_filter'    => array(
                  'type'  => 'string',
                  'default'   => 'no',
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
          ),
      ]
  );
}


function cdash_logo_gallery_block_callback($attributes){

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