<?php
// ------------------------------------------------------------------------
// SINGLE BUSINESS VIEW
// ------------------------------------------------------------------------
// Enqueue stylesheet for single businesses and taxonomies

function cdash_single_business_style() {
	if( is_singular( 'business' ) || is_tax( 'business_category' ) || is_tax( 'membership_level' ) ) {
		cdash_enqueue_styles();
	}
}
add_action( 'wp_enqueue_scripts', 'cdash_single_business_style' );

// Display single business (filter content)
function cdash_single_business($content) {
	if(in_array('get_the_excerpt', $GLOBALS['wp_current_filter'])) {
		return $content;
	}
	if( is_singular('business') && is_main_query() ) {
		$post_id = get_the_id();
		$meta = get_post_custom($post_id);
		$options = get_option('cdash_directory_options');
		$member_options = get_option('cdashmm_options');


		// make location/address metabox data available
		global $buscontact_metabox;
		$contactmeta = $buscontact_metabox->the_meta();

		// make logo metabox data available
		global $buslogo_metabox;
		$logometa = $buslogo_metabox->the_meta();

		global $post;
		$business_content = "<div id='business'>";
		if((isset($member_options['hide_lapsed_members'])) && (cdash_display_business_status($post_id) == "lapsed")) {
			$business_content .= __("This business is not a current member.", "cdash");
		}else{
		if( isset( $options['sv_thumb'] ) && "1" == $options['sv_thumb'] ) {
			$business_content .= cdash_display_featured_image($post_id, false, '', 'full', '');
		}

		if( isset( $options['sv_logo'] ) && isset( $logometa['buslogo'] ) && "1" == $options['sv_logo'] ) {
			$attr = array(
				'class'	=> 'alignleft logo',
			);
			$business_content .= wp_get_attachment_image($logometa['buslogo'], 'full', 0, $attr );
		}

		if( isset( $options['sv_description'] ) && "1" == $options['sv_description'] ) {
			$business_content .= $content;
		}

		if( isset( $options['sv_social'] ) && "1" == $options['sv_social'] ) {
			$business_content .= cdash_display_social_media( $post_id );
		}

		if( isset( $options['sv_memberlevel'] ) && "1" == $options['sv_memberlevel'] ) {
			$business_content .= cdash_display_membership_level( $post_id );
		}

		if( isset( $options['sv_category'] ) && "1" == $options['sv_category'] ) {
			$business_content .= cdash_display_business_categories( $post_id );
		}

		if( isset( $options['sv_tags'] ) && "1" == $options['sv_tags'] ) {
			$business_content .= cdash_display_business_tags($post_id);
		}
		if( isset( $contactmeta['location'] ) && '' !== $contactmeta['location'] ) {
			$locations = $contactmeta['location'];
			
			foreach( $locations as $location ) {
				if( isset( $location['donotdisplay'] ) && "1" == $location['donotdisplay'] ) {
					continue;
				} else {
					$business_content .= "<div class='location'>";
					if( isset($options['sv_name'] ) && "1" == ( $options['sv_name'] ) && isset( $location['altname'] ) && '' !== $location['altname'] ) {
						$business_content .= "<h3>" . $location['altname'] . "</h3>";
					}
					if( isset( $options['sv_address'] ) && "1" == $options['sv_address'] ) {
						$business_content .= cdash_display_address( $location );
						//$address_for_maps = cdash_display_address( $location );
						$business_content .= cdash_display_google_map_link($location);
					}

          if( isset($options['sv_hours'] ) && "1" == ( $options['sv_hours'] ) && isset( $location['hours'] ) && '' !== $location['hours'] ) {
						$business_content .= $location['hours'];
					}

					if( isset( $options['sv_url'] ) && "1" == $options['sv_url'] && isset( $location['url'] ) && '' !== $location['url'] ) {
						$business_content .= cdash_display_url( $location['url'] );
					}

					if( isset( $options['sv_phone'] ) && "1" == $options['sv_phone'] && isset( $location['phone'] ) && '' !== $location['phone'] ) {
						$business_content .= cdash_display_phone_numbers( $location['phone'] );
					}

					if( isset( $options['sv_email'] ) && "1" == $options['sv_email'] && isset( $location['email'] ) && '' !== $location['email'] ) {
						$business_content .= cdash_display_email_addresses( $location['email'] );
					}

				$business_content .= "</div>";
				}
			}
		}

		if( isset($options['bus_custom'] ) ) {
		 	$business_content .= cdash_display_custom_fields( get_the_id() );
		}
		$business_contacts = '';
		$business_content .= apply_filters( 'cdash_single_business_before_map', $business_contacts );
		if( isset( $options['sv_map']) && "1" == $options['sv_map'] ) {
			// only show the map if locations have addresses entered
			$needmap = "false";
			if( isset( $contactmeta['location'] ) && '' !== $contactmeta['location'] ) {
				$locations = $contactmeta['location'];
				foreach ( $locations as $location ) {
					if( ( isset( $location['address'] ) || ( isset( $location['custom_latitude'] ) && isset( $location['custom_longitude'] ) ) ) && !isset( $location['donotdisplay'] ) ) {
						$needmap = "true";
					}
				}
			}

			if( $needmap == "true" ) {
				$business_content .= "<div id='map-canvas' style='width: 100%; height: 300px; margin: 20px 0;'></div>";
				add_action('wp_footer', 'cdash_single_business_map');
			}
		}
	}
		$business_content .= "</div>";
        $business_content .= cdash_display_edit_link($post_id);

				if(isset($options['business_listings_url']) ) {
					$business_content .= cdash_back_to_bus_link();
				}

	$content = $business_content;
	}
	return $content;
	//wp_reset_postdata();
}
add_filter('the_content', 'cdash_single_business');

// ------------------------------------------------------------------------
// Add map to single business view
// ------------------------------------------------------------------------

function cdash_single_business_map() {
	$options = get_option('cdash_directory_options');
	if( is_singular('business') && isset($options['sv_map']) && $options['sv_map'] == "1" ) {
		global $buscontact_metabox;
		$contactmeta = $buscontact_metabox->the_meta();
		$locations = $contactmeta['location'];
		$google_map_api_key = cdash_get_google_maps_api_key();
		?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_api_key; ?>">
		</script>
		<script type="text/javascript">

		function initialize() {
			var locations = [
				<?php
				foreach($locations as $location) {
					$location_info = cdash_get_location_info($location);

					$address = $location_info['address'];
					$city = $location_info['city'];
					$state = $location_info['state'];
					$zip = $location_info['zip'];
					$country = $location_info['country'];

					if( isset( $location['donotdisplay'] ) && $location['donotdisplay'] == "1") {
						continue;
					} else {
						if(!isset($location['latitude']) || !isset($location['custom_latitude']) || $location['latitude'] == 0 && !isset($location['longitude']) || !isset($location['custom_longitude']) || $location['longitude'] == 0 ){
							//Get lat and long from address
							//$latLng = cdash_get_lat_long($location['address'], $location['city'], $location['state'], $location['zip'], $location['country'] );
							$latLng = cdash_get_lat_long($address, $city, $state, $zip, $country );
							$lat = $latLng[0];
							$long = $latLng[1];
						}else{
							//Get the lat and long values from the backend
							if( isset( $location['custom_latitude'] ) ) {
								$lat = $location['custom_latitude'];
							} else {
								$lat = $location['latitude'];
							}
							if( isset( $location['custom_longitude'] ) ) {
								$long = $location['custom_longitude'];
							} else {
								$long = $location['longitude'];
							}
						}

							// get the map icon
							$id = get_the_id();
							$buscats = get_the_terms( $id, 'business_category');
							if( isset( $buscats ) && is_array( $buscats ) ) {
								foreach($buscats as $buscat) {
									$buscatid = $buscat->term_id;
									$iconid = get_tax_meta($buscatid,'category_map_icon');
									if($iconid !== '') {
										$icon = $iconid['src'];
									}
								}
							}

							if(!isset($icon)) {
								//$icon = plugins_url( '/images/map_marker.png', __FILE__ );
								$icon = plugin_dir_url( dirname(__FILE__) ) . '/images/map_marker.png';
							}

							if(isset($location['altname'])) {
								$htmlname = $location['altname'];
								$poptitle = htmlentities($htmlname, ENT_QUOTES);
							} else {
								$htmltitle = htmlentities(get_the_title(), ENT_QUOTES);
								$poptitle = esc_html($htmltitle, ENT_QUOTES);
							}

							// get other information for the pop-up window
							if(isset($location['address'])){
								$popaddress = esc_html( $location['address'] );
							}else{
								$popaddress = '';
							}
							
							if(isset($location['city'])){
								$popcity = esc_html( $location['city'] );
							}else{
								$popcity = '';
							}

							if(isset($location['state'])){
								$popstate = esc_html( $location['state'] );
							}else{
								$popstate = '';
							}

							if(isset($location['zip'])){
								$popzip = esc_html($location['zip']);
							}else{
								$popzip = '';
							}
							
							
							?>

							['<div class="business" style="width: 150px; height: 150px;"><h5><?php echo $poptitle; ?></h5><?php echo $popaddress; ?><br /><?php echo $popcity; ?>, <?php echo $location['state']; ?> <?php echo $popzip; ?> </div>', <?php echo $lat; ?>, <?php echo $long; ?>, '<?php echo $icon; ?>'],
							<?php
						//}
					}
				} ?>

				];

				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					//center: {lat: $lat, lng: $long},
				    //zoom: 13
				}
				var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
				<?php
				$map_style = '';
				echo apply_filters( 'cdash_map_styles', $map_style ); ?>
				var infowindow = new google.maps.InfoWindow();
				var marker, i;

			    for (i = 0; i < locations.length; i++) {
			    	marker = new google.maps.Marker({
			        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			        map: map,
			        icon: locations[i][3]
			    	});

					bounds.extend(marker.position);

					// Don't zoom in too far on only one marker - http://stackoverflow.com/questions/3334729/google-maps-v3-fitbounds-zoom-too-close-for-single-marker

				    if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
				       var extendPoint1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
				       var extendPoint2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.01, bounds.getNorthEast().lng() - 0.01);
				       bounds.extend(extendPoint1);
				       bounds.extend(extendPoint2);
				    }

				    map.fitBounds(bounds);

					google.maps.event.addListener(marker, 'click', (function(marker, i) {
					    return function() {
					        infowindow.setContent(locations[i][0]);
					        infowindow.open(map, marker);
					    }
					})(marker, i));

					map.fitBounds(bounds);
				}
			}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	<?php }
}

function cdash_info_window() {
	global $post;
	$output = "<div style='width: 200px; height: 150px'>";
	$output .= $location['altname'];
	$output .= "</div>";
	return $output;
}

function cdash_get_location_info($location){
	$location_info = array();
	if(isset($location['address'])){
		$location_info['address'] = esc_html( $location['address'] );
	}else{
		$location_info['address'] = '';
	}

	if(isset($location['city'])){
		$location_info['city'] = esc_html( $location['city'] );
	}else{
		$location_info['city'] = '';
	}

	if(isset($location['state'])){
		$location_info['state'] = esc_html( $location['state'] );
	}else{
		$location_info['state'] = '';
	}

	if(isset($location['zip'])){
		$location_info['zip'] = esc_html($location['zip']);
	}else{
		$location_info['zip'] = '';
	}

	if(isset($location['country'])){
		$location_info['country'] = esc_html($location['country']);
	}else{
		$location_info['country'] = '';
	}

	return $location_info;
}

?>
