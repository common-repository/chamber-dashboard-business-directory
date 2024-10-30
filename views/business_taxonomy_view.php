<?php
// ------------------------------------------------------------------------
// TAXONOMY VIEW
// ------------------------------------------------------------------------

// modify query to order by business name
function cdash_reorder_taxonomies( $query ) {
	$options = get_option( 'cdash_directory_options' );
	if( isset( $options['tax_orderby_name'] ) && "1" == $options['tax_orderby_name'] ) {
		if( !( is_admin() || is_search() ) && ( is_tax( 'business_category' ) || is_tax( 'membership_level' ) ) ) {
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
		}
	}
}

add_action( 'pre_get_posts', 'cdash_reorder_taxonomies' );

function cdash_taxonomy_filter( $content ) {
	if(in_array('get_the_excerpt', $GLOBALS['wp_current_filter'])) {
		return $content;
	}
	if( is_tax( 'business_category' ) || is_tax( 'membership_level' ) ) {
		$options = get_option( 'cdash_directory_options' );

		// make location/address metabox data available
		global $buscontact_metabox;
		$contactmeta = $buscontact_metabox->the_meta();

		// make logo metabox data available
		global $buslogo_metabox;
		$logometa = $buslogo_metabox->the_meta();
		global $post;

		$tax_content = '';
		if( isset( $options['tax_thumb'] ) && "1" == $options['tax_thumb'] ) {
			//$tax_content .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'full') . '</a>';
			$tax_content .= cdash_display_featured_image($post->ID, true, get_the_permalink(), 'full', '');
		}
		if( isset( $options['tax_logo'] ) && "1" == $options['tax_logo'] && isset( $logometa['buslogo'] ) ) {
			$attr = array(
				'class'	=> 'alignleft logo',
			);
			$tax_content .= wp_get_attachment_image( $logometa['buslogo'], 'full', false, $attr );
		}
		$tax_content .= '<div class="cdash-description">' . $content . '</div>';

		if( isset( $options['tax_social'] ) && "1" == $options['tax_social'] ) {
			$tax_content .= cdash_display_social_media( get_the_id() );
		}

		if( isset( $options['tax_memberlevel'] ) && "1" == $options['tax_memberlevel'] ) {
			$tax_content .= cdash_display_membership_level( get_the_id() );
		}

		if (isset($options['tax_category']) && $options['tax_category'] == "1") {
			$tax_content .= cdash_display_business_categories( get_the_id() );
		}

		if( isset( $options['tax_tags'] ) && "1" == $options['tax_tags'] ) {
			$tax_content .= cdash_display_business_tags(get_the_id());
		}

		if( isset( $contactmeta['location'] ) ) {
			$locations = $contactmeta['location'];
			if( is_array( $locations ) ) {
				foreach( $locations as $location ) {
					if( isset( $location['donotdisplay'] ) && "1" == $location['donotdisplay'] ) {
						continue;
					} else {
						$tax_content .= "<div class='location'>";
						if( isset( $options['tax_name'] ) && "1" == $options['tax_name'] && isset( $location['altname'] ) && '' !== $location['altname'] ) {
							$tax_content .= "<h3>" . $location['altname'] . "</h3>";
						}

						if( isset( $options['tax_address'] ) && "1" == $options['tax_address'] ) {
							$tax_content .= cdash_display_address( $location );
						}

						if( isset( $options['tax_hours'] ) && "1" == $options['tax_hours'] && isset( $location['hours'] ) && '' !== $location['hours'] ){
							$tax_content .= $location['hours'];
						}

						if( isset( $options['tax_url'] ) && $options['tax_url'] == "1" && isset( $location['url'] ) && '' !== $location['url'] ) {
							$tax_content .= cdash_display_url( $location['url'] );
						}

						if( isset( $options['tax_phone'] ) && "1" == $options['tax_phone'] && isset( $location['phone'] ) && '' !== $location['phone'] ) {
							$tax_content .= cdash_display_phone_numbers( $location['phone'] );
						}

						if( isset( $options['tax_email'] ) && "1" == $options['tax_email'] && isset( $location['email'] ) && '' !== $location['email'] ) {
							$tax_content .= cdash_display_email_addresses( $location['email'] );
						}
					$tax_content .= "</div>";
					}
				}
			}
		}

		if( isset($options['bus_custom'] )) {
		 	$tax_content .= cdash_display_custom_fields( get_the_id() );
		}
		$tax_contacts = '';
		$tax_content .= apply_filters( 'cdash_end_of_taxonomy_view', $tax_contacts );
	$content = $tax_content;
	}
	return $content;
}

add_filter( 'the_content', 'cdash_taxonomy_filter' );
// add_filter( 'get_the_excerpt', 'cdash_taxonomy_filter' ); this won't retain formatting

?>
