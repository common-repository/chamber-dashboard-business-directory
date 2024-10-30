<?php
// ------------------------------------------------------------------------
// BUSINESS SEARCH RESULTS SHORTCODE
// ------------------------------------------------------------------------
function cdash_business_search_results_shortcode( $atts ) {
	extract( shortcode_atts(
        array(
			'format' => 'list',  // options: list, grid2, grid3, grid4, responsive
			'image_size'	=> '' //options: full_width
        ), $atts )
	);
	
	cdash_enqueue_styles();
	if( $format !== 'list' ) {
		cdash_enqueue_scripts();
	}
	$search_results = "";
	// Search results
	if( $_GET ) {
		// Get the search terms
		if(isset($_GET['buscat'])){
			$buscat = sanitize_text_field($_GET['buscat']);
		}else{
			$buscat = '';
		}
		if(isset($_GET['searchtext'])){
			$searchtext = wp_strip_all_tags($_GET['searchtext']);
		}else{
			$searchtext = '';
		}

		// Set up a query with the search terms
        $options = get_option('cdash_directory_options');
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$args = array(
            'post_type' => 'business',
            'posts_per_page' => $options['search_results_per_page'],
            'paged' => $paged,
            'order' => 'ASC',
            'orderby' => 'title'
        );
        if ( $buscat ) {
            $buscat_params = array(
                'taxonomy' => 'business_category',
                'field' => 'slug',
                'terms' => $buscat,
                'operator' => 'IN',
            );
            $args['tax_query'] = array(
            	$buscat_params,
         	);
        }

        if ( $searchtext ) {
        	$args['s'] = $searchtext;
        }
		$args = cdash_add_hide_lapsed_members_filter($args);
        $search_query = new WP_Query( $args );
		if ( $search_query->have_posts() ) {
			// Display the search results
			$search_results .= "<h2>" . __('Search Results', 'cdash') . "</h2>";
			$search_results .= "<div id='search-results' class='" . $format . "'>";
			//$search_results .= "<h2>" . __('Search Results', 'cdash') . "</h2>";
			while ( $search_query->have_posts() ) : $search_query->the_post();
				$search_results .= "<div class='search-result business'>";
				$search_results .= "<h3><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></h3>";
				$options = get_option('cdash_directory_options');

				// make location/address metabox data available
				global $buscontact_metabox;
				$contactmeta = $buscontact_metabox->the_meta();

				// make logo metabox data available
				global $buslogo_metabox;
				$logometa = $buslogo_metabox->the_meta();
				global $post;

				if ( isset( $options['tax_thumb'] ) && "1" == $options['tax_thumb'] ) {
					$search_results .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail( $post->ID, 'full') . '</a>';
				}

				if($image_size != ""){
					$image_class = "logo";
				}else{
					$image_class = "alignleft logo";
				}

				if ( isset( $options['tax_logo'] ) && "1" == $options['tax_logo'] && isset( $logometa['buslogo'] ) ) {
					$attr = array(
						'class'	=> $image_class,
					);
					$search_results .= wp_get_attachment_image( $logometa['buslogo'], 'full', 0, $attr );
				}

				$search_results .= '<div class="cdash-description">' . get_the_excerpt() . '</div>';
				if ( isset( $options['tax_memberlevel'] ) && "1" == $options['tax_memberlevel'] ) {
					$search_results .= cdash_display_membership_level( $post->ID );
				}

				if ( isset( $options['tax_category'] ) && "1" == $options['tax_category'] ) {
					$search_results .= cdash_display_business_categories( $post->ID );
				}

				if ( isset( $options['tax_tags'] ) && "1" == $options['tax_tags'] ) {
					$search_results .= cdash_display_business_tags( $post->ID );
				}

				if ( isset( $options['tax_social'] ) && "1" == $options['tax_social'] ) {
					$search_results .= cdash_display_social_media( get_the_id() );
				}

				if( isset( $contactmeta['location'] ) && is_array( $contactmeta['location'] ) ) {
					$locations = $contactmeta['location'];
					foreach($locations as $location) {
						if( isset( $location['donotdisplay'] ) && "1" == $location['donotdisplay'] ) {
							continue;
						} else {
							$search_results .= "<div class='location'>";
							if ( isset( $options['tax_name'] ) && "1" == $options['tax_name'] && isset( $location['altname'] ) && '' !== $location['altname'] ) {
								$search_results .= "<h3>" . $location['altname'] . "</h3>";
							}

							if ( isset( $options['tax_address'] ) && "1" == $options['tax_address'] ) {
								$search_results .= cdash_display_address( $location );
							}

							if ( isset( $options['tax_url'] ) && "1" == $options['tax_url'] && isset( $location['url'] ) && '' !== $location['url'] ) {
								$search_results .= cdash_display_url( $location['url'] );
							}

                            if ( isset( $options['tax_hours'] ) && "1" == $options['tax_hours'] && isset( $location['hours'] ) && '' !== $location['hours'] ) {
								$search_results .= $location['hours'];
							}

							if ( isset( $options['tax_phone'] ) && "1" == $options['tax_phone'] && isset( $location['phone'] ) && '' !== $location['phone'] ) {
								$search_results .= cdash_display_phone_numbers( $location['phone'] );
							}

							if ( isset( $options['tax_email'] ) && "1" == $options['tax_email'] && isset( $location['email'] ) && '' !== $location['email'] ) {
								$search_results .= cdash_display_email_addresses( $location['email'] );
							}
							$search_results .= "</div><!-- .location -->";
						}
					}
				}

				//if( $options['bus_custom'] ) {
				if ( isset( $options['bus_custom'] ) && "1" == $options['bus_custom'] ) {
					$search_results .= cdash_display_custom_fields( get_the_id() );
				}
				$search_results .= "</div><!-- .search-result -->";
			endwhile;
			$search_results .= "</div><!-- #search-results -->";
			$total_pages = $search_query->max_num_pages;
			if ($total_pages > 1){
				$current_page = max( 1, get_query_var( 'paged' ) );
				$big = 999999999; // need an unlikely integer
   				$search_results .= "<div class='pagination'>";
			  	$search_results .= paginate_links( array (
			      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			      'format' => '?page=%#%',
			      'current' => $current_page,
			      'total' => $total_pages,
			    ) );
			    $search_results .= "</div>";
			}
			//$search_results .= "</div><!-- #search-results -->";
		//endif;
        }else{
            //$search_results = "<h2>Search Results</h2>";
        $search_results = "We're sorry, your search for <b>".$searchtext . "</b> did not produce any results.<br />";
        $search_results .= "<h3>Search Suggestions</h3>";
        $search_results .= "<ul><li>Try a different search term</li>";
        $search_results .= "<li>Check for typos or spelling errors</li><ul>";

        }

		// Reset Post Data

		wp_reset_postdata();

	}
	return $search_results;
}
add_shortcode( 'business_search_results', 'cdash_business_search_results_shortcode' );

// ------------------------------------------------------------------------
// BUSINESS SEARCH SHORTCODE
// ------------------------------------------------------------------------
function cdash_business_search_form_shortcode( $atts ) {
	extract( shortcode_atts(
		array(
			'results_page' => 'notset',  // options: any url
			'class'		   => 'business_search_form'
		), $atts )
	);

	// Search form
	$search_form = "<div id='business-search' class='" . $class . "'><h3>" . __('Search', 'cdash') . "</h3>";
	if( $results_page == 'notset') {
		$search_form .= __( 'You must enter a results page!', 'cdash' );
		//return;
	} else {
		$search_form .= "<form id='business-search-form' method='get' action='" . home_url('/') . $results_page . "'>";
		$search_form .= "<p class='business-search-term'><label id='business-search-term' aria-label='search-term'>" . __('Search Term', 'cdash') . "</label><br /><input aria-label='search-text' type='text' value='' name='searchtext' id='searchtext' /></p>";
		// I would really like to be able to search by city, but since WPAlchemy serializes the locations array, I don't think this is possible
		$search_form .= "<p class='business-category-text'><label id='business-category-text'>" . __('Business Category', 'cdash') . "</label><br /><select aria-label='select a business category' name='buscat'><option value=''>";

		$terms = get_terms( 'business_category', 'hide_empty=0' );
	        foreach ($terms as $term) {
	            $search_form .= "<option value='" . $term->slug . "'>" . $term->name;
	        }
	  $search_form .= "</select></p>";
		$search_form .= "<input type='submit' value='" . __('Search', 'cdash') . "'>";
		$search_form .= "</form>";

	}
	$search_form .= "</div>";
	return $search_form;
}
add_shortcode( 'business_search_form', 'cdash_business_search_form_shortcode' );

// ------------------------------------------------------------------------
// BUSINESS SEARCH SHORTCODE
// ------------------------------------------------------------------------
function cdash_business_search_shortcode( $atts ) {
	extract( shortcode_atts(
        array(
			'format' => 'list',  // options: grid2, grid3, grid4
        ), $atts )
	);

	$resultspage = str_replace( home_url('/'), "", get_the_permalink() );
	$business_search = do_shortcode('[business_search_results format=' . $format . ']');
	$business_search .= do_shortcode('[business_search_form results_page='.$resultspage.']');
	return $business_search;
}
add_shortcode( 'business_search', 'cdash_business_search_shortcode' );

?>
