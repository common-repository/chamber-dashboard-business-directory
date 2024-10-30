<?php
// ------------------------------------------------------------------------
// BUSINESS MAP SHORTCODE
// ------------------------------------------------------------------------

function cdash_business_map_shortcode( $atts ) {
	// Set our default attributes
	extract( shortcode_atts(
		array(
			'category' => '', // options: slug of any category
			'level' => '', // options: slug of any membership level
			'single_link' => 'yes', // options: yes, no
			'perpage' => '-1', // options: any number
			'cluster' => 'no', // options: yes or no
			'width'	  => '100%', //options - any number with % or px
			'height'  => '500px' // options - any number with px
		), $atts )
	);

	$args = array(
		'post_type' => 'business',
		'posts_per_page' => $perpage,
    	'business_category' => $category,
    	'membership_level' => $level,
	);
	cdash_enqueue_styles();
	$google_map_api_key = cdash_get_google_maps_api_key();

	$args = cdash_add_hide_lapsed_members_filter($args);
	$mapquery = new WP_Query( $args );
	$business_map = "<div id='map-canvas' style='width:" . $width . "; height:" . $height . ";'></div>";
	$business_map .= "<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=";
	$business_map .= $google_map_api_key;
	$business_map .= "'></script>";
	if( "yes" == $cluster ) {
        $business_map .= "<script src='" . plugin_dir_url( dirname(__FILE__) ) . "js/markerclusterer.js'></script>";
	}
	$business_map .= "<script type='text/javascript'>";
	$business_map .= "function initialize() {
				var locations = [";

	// The Loop
	if ( $mapquery->have_posts() ) :
		while ( $mapquery->have_posts() ) : $mapquery->the_post();
			global $buscontact_metabox;
			$contactmeta = $buscontact_metabox->the_meta();
			if( isset( $contactmeta['location'] ) ) {
				$locations = $contactmeta['location'];
				if( !empty( $locations ) ) {
					foreach( $locations as $location ) {
						if( isset( $location['donotdisplay'] ) && $location['donotdisplay'] == "1") {
							continue;
						} elseif( isset( $location['address'] ) ) {
							// Get the latitude and longitude from the address
							if( ( isset( $location['latitude'] ) && isset( $location['longitude'] ) ) || isset( $location['custom_latitude'] ) && isset( $location['custom_longitude'] ) ) {
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

								// Get the map icon
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
									$icon = plugin_dir_url( dirname(__FILE__) ) . '/images/map_marker.png';
                	//$icon = plugins_url( plugin_dir_url( __FILE__ ) . '/images/map_marker.png', dirname(__FILE__ ) );
								}

								// Create the pop-up info window
								$popaddress = esc_html( $location['address'] );
								$popcity = esc_html( $location['city'] );
								$popstate = esc_html( $location['state'] );
								if(isset($location['zip'])){
									$popzip = $location['zip'];
								}
								$poptitle = esc_html( get_the_title() );

								if($single_link == "yes") {
									$thismapmarker = "['<div class=\x22business\x22 style=\x22width: 150px; height: 150px;\x22><h5><a href=\x22" . get_the_permalink() . "\x22>" . $poptitle . "</a></h5> " . $popaddress . "<br />" . $popcity . ", " . $popstate . "&nbsp;" . $popzip . "</div>', " . $lat . ", " . $long . ", '" . $icon . "'],";

									$business_map .= str_replace(array("\r", "\n"), '', $thismapmarker);
								} else {
									$thismapmarker .= "['<div class=\x22business\x22 style=\x22width: 150px; height: 150px;\x22><h5>" . $poptitle . "</h5> " . $popaddress . "<br />" . $popcity . ", " . $popstate . "&nbsp;" . $location['zip'] . "</div>', " . $lat . ", " . $long . ", '" . $icon . "'],";
									$business_map .= str_replace(array("\r", "\n"), '', $thismapmarker);
								}
							}
						}
					}
				}
			}
		endwhile;
	endif;
	$business_map .= "];

					var bounds = new google.maps.LatLngBounds();
					var mapOptions = {
					    zoom: 13,
					    scrollwheel: false
					}

					var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);";

					if( "yes" == $cluster ) {
						$business_map .=
                        "var options = {
                            imagePath: '" . plugins_url( '/js/images/m', dirname(__FILE__) ) . "'
                        };

                        var markerCluster = new MarkerClusterer(map, marker, options)";

					}

					$map_style = '';
					$business_map .= apply_filters( 'cdash_map_styles', $map_style );
					$business_map .= "
					var infowindow = new google.maps.InfoWindow();
					var marker, i;

				    for (i = 0; i < locations.length; i++) {
				    	marker = new google.maps.Marker({
				        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				        map: map,
				        icon: locations[i][3]
				    	});";

						if( "yes" == $cluster ) {
							$business_map .= "markerCluster.addMarker(marker);";
						}

						$business_map .= "
						bounds.extend(marker.position);
						google.maps.event.addListener(marker, 'click', (function(marker, i) {
						    return function() {
						        infowindow.setContent(locations[i][0]);
						        infowindow.open(map, marker);
						    }
						})(marker, i));
						map.fitBounds(bounds);

						if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
					       var extendPoint1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.01, bounds.getNorthEast().lng() + 0.01);
					       var extendPoint2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.01, bounds.getNorthEast().lng() - 0.01);
					       bounds.extend(extendPoint1);
					       bounds.extend(extendPoint2);
					    }
					}
				}

			google.maps.event.addDomListener(window, 'load', initialize);

		</script>";
		wp_reset_postdata();
	return $business_map;
    //return "Testing";
		//Moved the reset_postdata to above the return $business_map so that it works properly with elementor
	//wp_reset_postdata();
}

add_shortcode( 'business_map', 'cdash_business_map_shortcode' );

?>
