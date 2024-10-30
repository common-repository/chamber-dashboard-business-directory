<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//Adding Business tags to the archive
function cdash_business_tags( $query ) {
    if ( $query->is_tag() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'business' ) );
    }
}
add_action( 'pre_get_posts', 'cdash_business_tags' );

// ------------------------------------------------------------------------
// DISPLAY ADDRESS
// ------------------------------------------------------------------------
function cdash_display_address( $location ) {
	$address = '';
	$address .= "<p class='address'>";
		if( isset( $location['address'] ) && '' !== $location['address'] ) {
			$street_address = $location['address'];
			$address .= str_replace("\n", '<br />', $street_address);
		}

    if( isset( $location['city'] ) && '' !== $location['city'] ) {
			$address .= "<br />" . $location['city'] . ",&nbsp;";
		}

		if( isset( $location['state'] ) && '' !== $location['state'] ) {
			$address .= $location['state'] . "&nbsp;";
		}

		if( isset( $location['zip'] ) && '' !== $location['zip'] ) {
			$address .= $location['zip'] . "&nbsp;";
		}

    if( isset( $location['country'] ) && '' !== $location['country'] ) {
			$address .= $location['country'];
		}
	$address .= "</p>";
	$address = apply_filters( 'cdash_filter_address', $address, $location );
	return $address;
}

// ------------------------------------------------------------------------
// DISPLAY GOOGLE MAP LINK
// ------------------------------------------------------------------------
function cdash_display_google_map_link( $location ) {
	$google_map_link = '';
	//$google_map_link .= "<p class='google_map_link'>";
	if( isset( $location['address'] ) && '' !== $location['address'] ) {
		$google_map_link .= "<p><a target='_blank' href='https://www.google.com/maps/search/?api=1&query=";
		//if( isset( $location['address'] ) && '' !== $location['address'] ) {
			$street_address = $location['address'];
			$street_address_array = explode(" ", $street_address);
			$cdash_st_ad_array_len = count($street_address_array);
			for($i=0; $i<count($street_address_array); $i++){
				$google_map_link .= $street_address_array[$i] . "%20";
			}
		//}

    	if( isset( $location['city'] ) && '' !== $location['city'] ) {
			$google_map_link .= $location['city'] . "%20";
		}

		if( isset( $location['state'] ) && '' !== $location['state'] ) {
			$google_map_link .= $location['state'] . "%20";
		}

		if( isset( $location['zip'] ) && '' !== $location['zip'] ) {
			$google_map_link .= $location['zip'] . "%20";
		}

    	if( isset( $location['country'] ) && '' !== $location['country'] ) {
			$google_map_link .= $location['country'];
		}
		$google_map_link .= "'>". __('Get Directions', 'cdash') . "</a></p><br /><br />";
	}else{
		$google_map_link .= '';
	}


	return $google_map_link;
}

function cdash_display_social_media( $postid ) {
	// get options
	$options = get_option( 'cdash_directory_options' );
	// get meta
	global $buscontact_metabox;
	$meta = $buscontact_metabox->the_meta();
	$display = '<div class="cdash-social-media">';

	if( isset( $options['sm_display'] ) && "text" == $options['sm_display'] ) {
		// display text links
		if( isset( $meta['social'] ) ) {
			$social_links = $meta['social'];
			if( isset( $social_links ) ) {
				$display .= '<ul class="text-links">';
				foreach( $social_links as $link ) {
					$url = $link['socialurl'];
					if( null === parse_url( $url, PHP_URL_SCHEME )) {
						$url = "http://" . $url;
					}
					$display .= '<li><a href="' . $url . '" target="_blank">' . ucfirst( $link['socialservice'] ) . '</a></li>';
				}
				$display .= '</ul>';
			}
		}
	} elseif( isset( $options['sm_display'] ) && "icons" == $options['sm_display'] ) {
		// display icons
		if( isset( $meta['social'] ) ) {
			$social_links = $meta['social'];
			if( !empty( $social_links ) ) {
				$display .= '<ul class="icons">';
				foreach( $social_links as $link ) {
          if(isset($link['socialurl'])){
            $url = $link['socialurl'];
          }else{
            $url='';
          }

					if( null === parse_url( $url, PHP_URL_SCHEME )) {
						$url = "http://" . $url;
					}
					//$display .= '<li><a href="' . $url . '" target="_blank"><img src="' . plugins_url() . '/chamber-dashboard-business-directory/images/social-media/' . $link['socialservice'] . '-' . $options['sm_icon_size'] . '.png" alt="' . ucfirst( $link['socialservice'] ) . '"></a></li>';
          $display .= '<li><a href="' . $url . '" target="_blank"><img src="' . plugins_url('/images/social-media/', dirname(__FILE__)) . $link['socialservice'] . '-' . $options['sm_icon_size'] . '.png" alt="' . ucfirst( $link['socialservice'] ) . '"></a></li>';
				}
				$display .= '</ul>';
			}
		}
	}
	$display .= "</div>";
	$display = apply_filters( 'cdash_filter_social_media', $display, $postid );
	return $display;
}

// ------------------------------------------------------------------------
// DISPLAY CUSTOM FIELDS
// ------------------------------------------------------------------------
function cdash_display_custom_fields( $postid ) {
	$options = get_option( 'cdash_directory_options' );
	$customfields = $options['bus_custom'];
	global $custom_metabox;
	$custommeta = $custom_metabox->the_meta();

	$custom_fields = '';
	if( isset( $customfields ) && is_array( $customfields ) ) {
		$custom_fields .= "<div class='custom-fields'>";
		foreach($customfields as $field) {
			if( is_singular( 'business' ) && isset( $field['display_single'] ) && "yes" == $field['display_single'] ) {
				$fieldname = $field['name'];
				if( isset( $custommeta[$fieldname] ) ) {
					$custom_fields .= "<p class='custom " . $field['name'] . "'><strong class='custom cdash-label " . $field['name'] . "'>" . $field['name'] . ":</strong>&nbsp;" . $custommeta[$fieldname] . "</p>";
				} elseif ( isset( $custommeta['_cdash_'.$fieldname] ) ) {
					$custom_fields .= "<p class='custom " . $field['name'] . "'><strong class='custom cdash-label " . $field['name'] . "'>" . $field['name'] . ":</strong>&nbsp;" . $custommeta['_cdash_'.$fieldname] . "</p>";
				}
			} elseif( isset( $field['display_dir'] ) && "yes" !== $field['display_dir'] ) {
				continue;
			} else {
				$fieldname = $field['name'];
				if( isset( $custommeta[$fieldname] ) ) {
					$custom_fields .= "<p class='custom " . $field['name'] . "'><strong class='custom cdash-label " . $field['name'] . "'>" . $field['name'] . ":</strong>&nbsp;" . $custommeta[$fieldname] . "</p>";
				} elseif( isset( $custommeta['_cdash_'.$fieldname] ) ) {
					$custom_fields .= "<p class='custom " . $field['name'] . "'><strong class='custom cdash-label " . $field['name'] . "'>" . $field['name'] . ":</strong>&nbsp;" . $custommeta['_cdash_'.$fieldname] . "</p>";
				}
			}
		}
		$custom_fields .= "</div>";
	}

	$custom_fields = apply_filters( 'cdash_filter_custom_fields', $custom_fields, $postid );
	return $custom_fields;
}

// ------------------------------------------------------------------------
// DISPLAY PHONE NUMBERS
// ------------------------------------------------------------------------
function cdash_display_phone_numbers( $phone_numbers ) {
	$phones_content = '';
	if( is_array( $phone_numbers ) ) {
		$phones_content .= "<p class='phone'>";
			$i = 1;
			foreach( $phone_numbers as $phone ) {
				if( $i !== 1 ) {
					$phones_content .= "<br />";
				}
				if( isset( $phone['phonenumber'] ) && '' !== $phone['phonenumber'] ){
					$phones_content .= "<a href='tel:" . $phone['phonenumber'] . "'>" . $phone['phonenumber'] . "</a>";
					if( isset( $phone['phonetype'] ) && '' !== $phone['phonetype'] ) {
						$phones_content .= "<span class='phone_type'>&nbsp;(" . $phone['phonetype'] . ")</span>";
					}
				}
				$i++;
			}
		$phones_content .= "</p>";
	}
	$phones_content = apply_filters( 'cdash_display_phone_numbers', $phones_content, $phone_numbers );
	return $phones_content;
}

// ------------------------------------------------------------------------
// DISPLAY EMAIL ADDRESSES
// ------------------------------------------------------------------------
function cdash_display_email_addresses( $email_addresses ) {
	$email_content = '';
	if( is_array( $email_addresses ) ) {
		$email_content .= "<p class='email'>";
			$i = 1;
			foreach( $email_addresses as $email ) {
				if( $i !== 1 ) {
					$email_content .= "<br />";
				}
				$email_content .= "<a href='mailto:" . $email['emailaddress'] . "'>" . $email['emailaddress'] . "</a>";
				if( isset( $email['emailtype'] ) && '' !== $email['emailtype']) {
					$email_content .= "<span class='email_type'>&nbsp;(". $email['emailtype'] .")</span>";
				}
				$i++;
			}
		$email_content .= "</p>";
	}
	$email_content = apply_filters( 'cdash_filter_email_addresses', $email_content, $email_addresses );
	return $email_content;
}

// ------------------------------------------------------------------------
// DISPLAY URL
// ------------------------------------------------------------------------
function cdash_display_url( $url ) {
	if( null === parse_url( $url, PHP_URL_SCHEME )) {
		$url = "http://" . $url;
	}
	$url_content = "<p class='website'><a href='" . $url . "' target='_blank'>" . __( 'Website', 'cdash' ) . "</a></p>";
	$url_content = apply_filters( 'cdash_filter_url', $url_content, $url );
	return $url_content;
}

// ------------------------------------------------------------------------
// DISPLAY MEMBERSHIP LEVEL
// ------------------------------------------------------------------------
function cdash_display_membership_level( $id ) {
	$levels_content = '';
	$levels = get_the_terms( $id, 'membership_level');
	if($levels) {
		$levels_content .= "<p class='membership'><span>" . __('Membership Level:&nbsp;', 'cdash') . "</span>";
		$i = 1;
		foreach($levels as $level) {
			if($i !== 1) {
				$levels_content .= ",&nbsp;";
			}
			$levels_content .= $level->name;
			$i++;
		}
	}
	$levels_content = apply_filters( 'cdash_filter_membership_level', $levels_content, $id );
	return $levels_content;
}

// ------------------------------------------------------------------------
// DISPLAY CATEGORIES
// ------------------------------------------------------------------------
function cdash_display_business_categories( $id ) {
	$category_content = '';
	$buscats = get_the_terms( $id, 'business_category');
	if($buscats) {
		$category_content .= "<p class='categories'><span>" . __('Categories:&nbsp;', 'cdash') . "</span>";
		$i = 1;
		foreach($buscats as $buscat) {
			$buscat_link = get_term_link( $buscat );
			if($i !== 1) {
				$category_content .= ",&nbsp;";
			}
			$category_content .= "<a href='" . $buscat_link . "'>" . $buscat->name . "</a>";
			$i++;
		}
	}
	$category_content = apply_filters( 'cdash_filter_business_categories', $category_content, $id );
	return $category_content;
}

// ------------------------------------------------------------------------
// DISPLAY TAGS
// ------------------------------------------------------------------------
function cdash_display_business_tags($id){
	$tags_content = '';
	$bustags = get_the_tags();
	if($bustags) {
		$tags_content .= "<p class='categories'><span>" . __('Tags:&nbsp;', 'cdash') . "</span>";
		$i = 1;
		foreach($bustags as $bustag) {
			$bustag_link = get_term_link( $bustag );
			if($i !== 1) {
				$tags_content .= ",&nbsp;";
			}
			$tags_content .= "<a href='" . $bustag_link . "'>" . $bustag->name . "</a>";
			$i++;
		}
	}
	$category_content = apply_filters( 'cdash_filter_business_tags', $tags_content, $id );
	return $tags_content;
}


// ------------------------------------------------------------------------
// DISPLAY BUSINESS STATUS
// ------------------------------------------------------------------------
function cdash_display_business_status( $id ) {
    if(function_exists( 'cdashmm_requires_wordpress_version' )){
        $status_content = '';
        $statuses = get_the_terms( $id, 'membership_status');
        if($statuses) {
            //$status_content .= "<p class='categories'><span>" . __('Status:&nbsp;', 'cdash') . "</span>";
            $i = 1;
            foreach($statuses as $status) {
                $status_link = get_term_link( $status );
                if($i !== 1) {
                    $status_content .= ",&nbsp;";
                }
                $status_content .= $status->slug;
                $i++;
            }
        }
        $status_content = apply_filters( 'cdash_filter_business_status', $status_content, $id );
        $membership_status = $status_content;
        return $status_content;
    }
}

// ------------------------------------------------------------------------
// ADD TAXONOMY FILTER TO HIDE LAPSED BUSINESSES
// ------------------------------------------------------------------------
function cdash_add_hide_lapsed_members_filter($args){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if(is_plugin_active('chamber-dashboard-member-manager/cdash-member-manager.php')){
        $member_options = get_option('cdashmm_options');

        if(isset($member_options['hide_lapsed_members'])){
            $args['tax_query'][] = array(
                'taxonomy' => 'membership_status',
                'field' => 'slug',
                'terms' => array('lapsed'),
                'operator' => 'NOT IN'
            );
        }
    }
	return $args;
}

// ------------------------------------------------------------------------
// ADD EDIT BUTTON IF MEMBER UPDATER IS INSTALLED AND USERS ARE LOGGED IN
// ------------------------------------------------------------------------

function cdash_show_edit_link(){
    $member_options = get_option('cdashmm_options');

    if(is_plugin_active('chamber-dashboard-member-updater/cdash-member-updater.php')){
        if ( !current_user_can('publish_posts') ) {
            echo "<h2>Please Login to update your business listing. If you do not have an account, please create an account. If you have already created an account, please contact Chamber Name to activate your account. Thanks!</h2><br />";
            //Link to the member login page
            echo '<p><a href="' . $member_options['user_login_page'] . '">Login</a></p><br />';
            echo '<p><a href="' . $member_options['user_registration_page'] . '">Register</a></p><br />';
            return;

        }else{
            //Check if the person (people post type) connected to this user is published. If the person is still pending, take the user to the business, but display a message saying that they need to be approved in order to edit they business listing.
            $edit_post_link = esc_url( add_query_arg( 'post_id', get_the_ID(), home_url('/edit-post/') ) );
            $business_edit .= "<a href='" . $edit_post_link . "'>Edit Your Business Listing</a><br />";
        }
    }
    return $business_edit;
}

// ------------------------------------------------------------------------
// DISPLAY THE EDIT BUSINESS LINK ON THE SINGLE BUSINESS PAGE
// ------------------------------------------------------------------------

function cdash_display_edit_link($business_id)
{
    //$member_options = get_option('cdashmm_options');
    $member_updater = cdash_is_member_updater_active();
    if($member_updater){
        return cdashmu_display_business_edit_link($business_id);
    }
}

// ------------------------------------------------------------------------
// DISPLAY THE BACK TO BUSINESS LINK ON THE SINGLE BUSINESS PAGE
// ------------------------------------------------------------------------

function cdash_back_to_bus_link(){
	$options = get_option('cdash_directory_options');
	$back_bus_link = "";
	$back_bus_link = "<p><a href='" . $options['business_listings_url'] . "'>" . $options['business_listings_url_text'] . "</a></p>";
	return $back_bus_link;
}

// ------------------------------------------------------------------------
// DISPLAY FEATURED IMAGE
// ------------------------------------------------------------------------

function cdash_display_featured_image($post_id, $is_single_link, $permalink, $image_size, $thumbattr){
  global $post;
  $image_sizes = cdash_get_wp_image_sizes();
  if(isset($image_sizes[$image_size])){
	  $image_width = $image_sizes[$image_size]['width'];
	  $image_height = $image_sizes[$image_size]['height'];
  }else{
	  $image_width = "";
	  $image_height = "";
  }
  
  if(isset($thumbattr) && $thumbattr != ""){
	  $img_class = $thumbattr['class'];
  }else{
	  $img_class = "";
  }

  //print_r($image_sizes);
  $featured_image = '';
  $options = get_option('cdash_directory_options');
  if(!has_post_thumbnail()){
    if(isset($options['cdash_default_thumb']) && $options['cdash_default_thumb'] != ''){
      $default_featured_image = $options['cdash_default_thumb'];
      if($is_single_link){
        $featured_image .= '<a href="' . $permalink . '"><img class="'.$img_class.'" width="'.$image_width.'" height="'.$image_height.'" src="' . $default_featured_image .'" /></a>';
      }else{
        $featured_image .= '<img class="featured '.$image_size.'" width="'.$img_class.'" height="'.$image_height.'" src="' . $default_featured_image .'" /><br />';
      }
    }
  }else{
    if($is_single_link){
      $featured_image .= '<a href="' . $permalink . '">' . get_the_post_thumbnail( $post->ID, $image_size, $thumbattr) . '</a>';
    }else{
      $featured_image .= get_the_post_thumbnail( $post_id, $image_size, $thumbattr );
    }
  }
  return $featured_image;
}

function cdash_get_wp_image_sizes(){
	global $_wp_additional_image_sizes;

		$default_image_sizes = get_intermediate_image_sizes();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
			$image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
			$image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
		}

		if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		return $image_sizes;
}
?>
