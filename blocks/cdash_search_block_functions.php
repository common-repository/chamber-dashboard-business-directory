<?php 

function cdash_business_search_block_output($attributes){
    cdash_enqueue_block_search_scripts();
    add_action( 'enqueue_block_editor_assets', 'cdash_search_block_editor_css' );

    if(!isset($search_form)){
        $search_form = '';

        if(isset($_GET['buscat'])){
            $buscat = sanitize_text_field($_GET['buscat']);
        }else{
            $buscat = '';
        }

        if(isset($_GET['searchtext'])){
            $searchtext = sanitize_text_field($_GET['searchtext']);
            $search_form .= cdash_business_search_form_block($attributes);
            $search_form .= cdash_search_results_block($attributes, $searchtext, $buscat);
        }else{
            $searchtext = '';
            $search_form .= cdash_business_search_form_block($attributes);
        }

        return $search_form;
    }
}

function cdash_business_search_form_block($attributes){
    $search_form = '';

    $class = "business_search_form";

    if(isset($attributes['searchFormAlignment'])){
        $class .= " " . $attributes['searchFormAlignment'];
        //$class = $attributes['searchFormAlignment'];
    }


    $results_page = home_url() .  $_SERVER['REQUEST_URI'];

    $search_form = "<div id='business-search' class='" . $class . "'>";
    //$search_form = "<div class='" . $class . "'>";

    if(isset($attributes['searchFormCustomTitle']) && '' !== $attributes['searchFormCustomTitle']){
        $custom_search_form_title = $attributes['searchFormCustomTitle'];
    }else{
        $custom_search_form_title = '';
    }

    if(isset($attributes['searchFormTitleDisplay']) && $attributes['searchFormTitleDisplay'] == true){
        $search_form .= "<h3>" . __($custom_search_form_title, 'cdash') . "</h3>";
    }
    

    $search_form .= "<form id='business-search-form' method='get' action='" . get_the_permalink() . "'>";
    $search_form .= "<p class='business-search-term'>";

    if(isset($attributes['customSearchFormLabel']) && '' !== $attributes['customSearchFormLabel']){
        $custom_search_term_label = $attributes['customSearchFormLabel'];
    }else{
        $custom_search_term_label = 'Search Term';
    }
    
    if(isset($attributes['searchFormLabelDisplay']) && $attributes['searchFormLabelDisplay'] == true){
        $search_form .= "<label id='business-search-term' aria-label='search-term'>" . __($custom_search_term_label, 'cdash') . "</label><br />";
    }
    
    if(isset($attributes['searchInputPlaceholder']) && $attributes['searchInputPlaceholder'] != '' ){
        $placeholder = $attributes['searchInputPlaceholder'];
    }else{
        $placeholder = '';
    }
    
    $search_form .= "<input aria-label='search-text' type='text' value='' name='searchtext' id='searchtext' placeholder = '". __($placeholder, 'cdash') ."' /></p>";
    // I would really like to be able to search by city, but since WPAlchemy serializes the locations array, I don't think this is possible

    if(isset($attributes['customCategoryFieldLabel']) && $attributes['customCategoryFieldLabel'] != ''){
        $custom_category_field_label = $attributes['customCategoryFieldLabel'];
    }else{
        $custom_category_field_label = 'Business Category';
    }

    if(isset($attributes['categoryFieldDisplay']) && $attributes['categoryFieldDisplay'] == true){
        $search_form .= "<p class='business-category-text'>";
    
        if(isset($attributes['categoryFieldLabelDisplay']) && $attributes['categoryFieldLabelDisplay'] == true){
            $search_form .= "<label id='business-category-text'>" . __($custom_category_field_label, 'cdash') . "</label><br />";
        }
    
        $search_form .= "<select aria-label='select a business category' name='buscat'><option value=''>";

        $terms = get_terms( 'business_category', 'hide_empty=0' );
        foreach ($terms as $term) {
            $search_form .= "<option value='" . $term->slug . "'>" . $term->name;
        }
        $search_form .= "</select></p>";
    }
    
    
    $search_form .= "<input type='submit' value='" . __('Search', 'cdash') . "'>";
    $search_form .= "</form>";
    
    $search_form .= "</div>";
    return $search_form;

}

function cdash_search_results_block($attributes, $searchtext, $buscat){
    cdash_enqueue_styles();
    $search_results = '';

    // Set up a query with the search terms
    $options = get_option('cdash_directory_options');
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    if(isset($attributes['order'])){
        $order = $attributes['order'];
    }else{
        $order = 'asc';
    }

    if(isset($attributes['orderBy'])){
        $order_by = $attributes['orderBy'];
    }else{
        $order_by = 'title';
    }

    if(isset($attributes['perPage']) && $attributes['perPage'] != ''){
        $restuls_per_page = $attributes['perPage'];
    }else{
        $restuls_per_page = $options['search_results_per_page'];
    }


    $args = array(
        'post_type' => 'business',
        'posts_per_page' => $restuls_per_page,
        'paged' => $paged,
        'order' => $order,
        'orderby' => $order_by
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

    if(isset($attributes['searchDisplayFormat'])){
        $format = $attributes['searchDisplayFormat'];
    }else{
        $format = "list";
    }
    $args = cdash_add_hide_lapsed_members_filter($args);
    $search_query = new WP_Query( $args );

    if ( $search_query->have_posts() ) {
        // Display the search results
			$search_results .= "<h2>" . __('Search Results', 'cdash') . "</h2>";
            $search_results .= "<div id='search-results' class='" . $format . "'>";
            while ( $search_query->have_posts() ) :
                $search_query->the_post();
                $search_results .= "<div class='search-result business'>";
				
                $options = get_option('cdash_directory_options');
                
                // make location/address metabox data available
				global $buscontact_metabox;
				$contactmeta = $buscontact_metabox->the_meta();

				// make logo metabox data available
				global $buslogo_metabox;
				$logometa = $buslogo_metabox->the_meta();
                global $post;
                
                //display the selected image
                if(isset($attributes['imageType'])){
                    $image_type = $attributes['imageType'];
                }else{
                    $image_type = "featured";
                }

                if(isset($attributes['imageSize'])){
                    $image_size = $attributes['imageSize'];
                }else{
                    $image_size = "medium";
                }

                if(isset($attributes['imageAlignment'])){
                    $image_align = $attributes['imageAlignment'];
                }else{
                    $image_align = 'left';
                }

                if(isset($attributes['businessTitleFontSize']) && '' !== $attributes['businessTitleFontSize']){
                    $title_font_size = $attributes['businessTitleFontSize'];
                }else{
                    $title_font_size = 26;
                }

                $search_results .= "<h3 style='font-size:".$title_font_size."px'><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></h3>";

                if($image_type == "featured"){
                    $image_class="featured" . " ". $image_align;
                    $search_results .= '<a href="' . get_the_permalink() . '">' . get_the_post_thumbnail( $post->ID, $image_size) . '</a>';
                }elseif($image_type == "logo" && isset($logometa['buslogo'])){
                    $image_class="logo" . " " . $image_align;
                    $attr = array(
						'class'	=> $image_class,
					);
                    $search_results .= wp_get_attachment_image( $logometa['buslogo'], $image_size, 0, $attr );
                }

                if(isset($attributes['displayDescription']) && true == $attributes['displayDescription']){
                    $search_results .= '<div class="cdash-description">' . get_the_excerpt() . '</div>';
                }

                if(isset($attributes['displayMemberLevel']) && '' != $attributes['displayMemberLevel']){
                    $search_results .= cdash_display_membership_level( $post->ID );
                }

                if(isset($attributes['displayCategory']) && '' != $attributes['displayCategory']){
                    $search_results .= cdash_display_business_categories( $post->ID );
                }

                if(isset($attributes['displayTags']) && '' != $attributes['displayTags']){
                    $search_results .= cdash_display_business_tags( $post->ID );
                }

                if(isset($attributes['displaySocialMedia']) && '' != $attributes['displaySocialMedia']){
                    $search_results .= cdash_display_social_media( $post->ID );
                }

                if( isset( $contactmeta['location'] ) && is_array( $contactmeta['location'] ) ) {
                    $locations = $contactmeta['location'];
                    foreach($locations as $location) {
                        if( isset( $location['donotdisplay'] ) && "1" == $location['donotdisplay'] ) {
                            continue;
                        } else {
                            $search_results .= cdash_display_business_location_info($attributes, $location);
                        }
                    }
                }

                if ( isset( $options['bus_custom'] ) && "1" == $options['bus_custom'] ) {
					$search_results .= cdash_display_custom_fields( $post->ID );
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
    }else{
        $search_results = __("<p>We're sorry, your search for <b>".$searchtext . "</b> did not produce any results.<br /></p>", "cdash");
        $search_results .= "<h3>Search Suggestions</h3>";
        $search_results .= "<ul><li>Try a different search term</li>";
        $search_results .= "<li>Check for typos or spelling errors</li><ul>";

    }
    
    //enqueue styles for the search results
    return $search_results;
}

//function cdash_display_business_location_info($locations){
    function cdash_display_business_location_info($attributes, $location){
        if(!isset($search_results)){
            $search_results = '';
        }

        if(isset($attributes['businessLocationNameFontSize']) && '' !== $attributes['businessLocationNameFontSize']){
            $location_name_font_size = $attributes['businessLocationNameFontSize'];
        }else{
            $location_name_font_size = 26;
        }
        $search_results .= "<div class='location'>";

       if(isset($attributes['displayLocationName']) && '' != $attributes['displayLocationName']){
           if(isset($location['altname'])){
                $search_results .= "<h3 style='font-size:".$location_name_font_size."px'>" . $location['altname'] . "</h3>";
            }
        }
        if(isset($attributes['displayAddress']) && '' != $attributes['displayAddress']){
            $search_results .= cdash_display_address( $location );
        }

        if(isset($attributes['displayWebsite']) && '' != $attributes['displayWebsite']){
            if(isset($location['url']) && '' !== $location['url']){
                $search_results .= cdash_display_url( $location['url'] );
            }
        }

        if(isset($attributes['displayHours']) && '' != $attributes['displayHours']){
            if(isset($location['hours']) && '' !== $location['hours']){
                $search_results .= $location['hours'];
            }
            
        }

        if(isset($attributes['displayPhone']) && '' != $attributes['displayPhone']){
            if(isset($location['phone']) && '' !== $location['phone']){
                $search_results .= cdash_display_phone_numbers( $location['phone'] );
            }
        }

        if(isset($attributes['displayEmail']) && '' != $attributes['displayEmail']){
            if(isset($location['email']) && '' !== $location['email']){
                $search_results .= cdash_display_email_addresses( $location['email'] );
            }
        }
        $search_results .= "</div><!-- .location -->";

    // Reset Post Data

    wp_reset_postdata();
    return $search_results;
}

function cdash_enqueue_block_search_scripts(){
    wp_enqueue_style( 'search_block_css', plugins_url( '../css/search_block.css', __FILE__ ));
}
 ?>