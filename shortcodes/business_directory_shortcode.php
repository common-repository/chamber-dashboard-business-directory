<?php
// ------------------------------------------------------------------------
// BUSINESS DIRECTORY SHORTCODE
// ------------------------------------------------------------------------

function cdash_business_directory_shortcode( $atts ) {
	global $wp;
	$options = get_option('cdash_directory_options');
	$member_options = get_option('cdashmm_options');
    global $post;
		global $business_list;
		$business_list = '';
	// Set our default attributes
	extract( shortcode_atts(
		array(
			'format' => 'list',  // options: list, grid2, grid3, grid4, responsive
			'text' => 'excerpt', // options: excerpt, description, none
			'orderby' => 'title', // options: date, modified, menu_order, rand, membership_level
			'order' => 'asc', //options: asc, desc
			'image' => 'logo', // options: logo, featured, none
			'category' => '', // options: slug of any category
			'tags'	=>	'', // options: slug of any tag
			'level' => '', // options: slug of any membership level
			'display' => '', // options: address, url, phone, email, location_name, category, level, social_media, location, hours
			'single_link' => 'yes', // options: yes, no
			'perpage' => '-1', // options: any number
			
			'status' => '', // options: slug of any membership status
			'image_size'	=> '', //options: thumbnail, medium, large, full
			'alpha'	=> 'no',	//options: yes, no
			'logo_gallery' => 'no', // options: yes, no
			'show_category_filter' => 'no', //options: yes, no
			'cd_block' => 'no',
			'changeTitleFontSize' => true,
			'titleFontSize' => '',
			'disablePagination' => false,
            'displayImageOnTop' => false,
            'align'             => '',
			'textAlignment'		=>	'left',
			'enableBorder'		=>	false,
			'borderColor'		=>	'',
			'borderThickness'	=>	0,
			'borderStyle'		=>	'',
			'borderRadius'		=>	0,
			'borderRadiusUnits'	=>	'px',

		), $atts )
	);

	cdash_enqueue_styles();
	cdash_enqueue_scripts();

	if($show_category_filter == 'yes'){
		cdash_frontend_scripts();
	}
	
	// If user wants to display stuff other than the default, turn their display options into an array for parsing later
	if($display !== '') {
		if($cd_block == "yes"){
			$displayopts = explode( ",", $display);
		}else if($cd_block == "no"){
			$displayopts = explode( ", ", $display);
		}
  	}else{
		$displayopts = '';
	}

	
	if(is_front_page()){
		$paged = (int)get_query_var('page');
	}else{
		$paged = (int)get_query_var('paged');
	}

	if(isset($_GET['bus_category'])){
		$category = sanitize_text_field($_GET['bus_category']);
	}

	$args = array(
		'post_type' => 'business',
		//'no_found_rows' => true,
		'posts_per_page' => $perpage,
		'paged' => $paged,
		'orderby' => $orderby,
		'order' => $order,
	  	'business_category' => $category,
	  	'membership_level' => $level
	);

	if($disablePagination == '1'){
		$args['no_found_rows'] = true;
	}

	if((isset($status)) && ($status != '')){
		$args['tax_query'][] = array(
			'taxonomy' => 'membership_status',
		    'field' => 'slug',
            'terms' => array($status),
			'operator' => 'IN'
			);
	}

	$business_list = '';
	if($alpha == 'yes'){
		$business_list .= cdash_list_alphabet($align);
		if(isset($_GET['starts_with'])) {
			$args['starts_with'] = sanitize_text_field($_GET['starts_with']);
		}
	}

	if($show_category_filter == 'yes'){
		 $business_list .= cdash_display_bus_cat_filter();
	}

	$args = cdash_add_hide_lapsed_members_filter($args);
	$businessquery = new WP_Query( $args );

	$total_business_posts = $businessquery->found_posts;
  //$total_business_pages = ceil($total_business_posts / $perpage);
	$total_business_pages = $businessquery->max_num_pages;

	if($logo_gallery == "yes"){
		$logo_class = "logo_gallery";
	}else{
		$logo_class = "";
	}

	$border_styles = array();
	if(isset($enableBorder) && $enableBorder === true){
		$border = $borderColor . ' ' . $borderThickness . 'px ' . $borderStyle;
		$border_radius = $borderRadius . $borderRadiusUnits;
		$border_styles['class']	= "border_set";
		$border_styles['border'] = 'style = "border: ' . $border . ';border-radius: ' . $border_radius .'";';
	}else{
		$border_styles['class'] = '';
		$border_styles['border'] = '';
	}

	$text_align = 'has-text-align-'.$textAlignment;
	if($align == "center" || $align == "left" || $align == "right"){
		$block_align = "";
	}else{
		$block_align = 'align'.$align;
	}
	

	// The Loop
	if ( $businessquery->have_posts() ) :
		$image_sizes = cdash_get_wp_image_sizes();
		//$business_list = '';
		$business_list .= "<div id='output'></div>";
		if($cd_block == "yes"){
			$block_class = "cd_block";
		}else{
			$block_class = "";
        }
        //$business_list .= "<div class='".$block_align."'>";
        
		$business_list .= "<div id='businesslist' class='" . $format . ' ' . $image_size . ' '. $logo_class . ' ' . $block_class . ' ' . $text_align . ' ' . $block_align . "'>";
		
		$count = 0;
			while ( $businessquery->have_posts() ) :
				$businessquery->the_post();
				$add = ( $count % 2 ) ? ' even_post' : ' odd_post';
				$count++;
				$post_id = $post->ID;
				global $buslogo_metabox;
				$logometa = $buslogo_metabox->the_meta();
				if($logo_gallery == "yes"){
					if( isset( $logometa['buslogo'] ) ) {
						$business_list .= cdash_display_business_listings($add, $single_link, $image, $image_size, $post_id, $logo_gallery, $text, $display, $displayopts, $cd_block, $changeTitleFontSize, $titleFontSize, $displayImageOnTop, $border_styles);
					}
				}else{
					$business_list .= cdash_display_business_listings($add, $single_link, $image, $image_size, $post_id, $logo_gallery, $text, $display, $displayopts, $cd_block, $changeTitleFontSize, $titleFontSize, $displayImageOnTop, $border_styles);
				}
			endwhile;
            $business_list .= "</div><!--end of businesslist-->";
            //$business_list .= "</div>";
			// pagination links
			$total_pages = $businessquery->max_num_pages;
			if ($total_pages > 1){
				if(is_front_page()){
					$current_page = max(1, get_query_var('page'));
				}else{
					$current_page = max(1, get_query_var('paged'));
				}
				//$current_page = max(1, get_query_var('page'));
   				$business_list .= "<div class='cdash_bus_directory pagination'>";
					$url_parts = explode("?", get_pagenum_link(1));
					$base_url = rtrim($url_parts[0], "/");
					$format = '/page/%#%';
					$add_args = array();
					if (count($url_parts) > 1) {
						$starts_with_args = explode("=", $url_parts[1]);
						$add_args[$starts_with_args[0]] = $starts_with_args[1];
					}
			  	$business_list .= paginate_links( array (
			      	'base' => $base_url . '%_%',
			      	'format' => $format,
			      	'current' => $current_page,
			      	'total' => $total_pages,
					'prev_text'    => __('« prev'),
            		'next_text'    => __('next »'),
					'add_args' => $add_args
			    ) );
			    $business_list .= "</div>";
			}
		wp_reset_postdata();
	else:
		$business_list .= __("No businesses found.");
	endif;
	return $business_list;
	//Moved the reset_postdata to above the return $business_list so that it works properly with elementor
	//wp_reset_postdata();
}
add_shortcode( 'business_directory', 'cdash_business_directory_shortcode' );

//Display the list of alphabet
function cdash_list_alphabet($align){
    global $wp;
    $align_class = "align".$align;
	$results = str_split("0ABCDEFGHIJKLMNOPQRSTUVWXYZ");
	$alpha = '';
	$alpha .= "<div class='alpha_listings ".$align_class."'>";
	$alpha .= "<ul>";
	$url_parts = explode("?", get_pagenum_link(1));
	$base_url = $url_parts[0];
	foreach($results as $result) {
		$alpha .= "<li><a href='";
		$alpha .= $base_url . "?starts_with=" . $result;
		$alpha .= "'>";
		$alpha .= ($result == '0') ? "0-9" : $result;
		$alpha .= "</a></li>";
	}
	$alpha .= "<li><a href='" . $base_url . "'>View All</a></li>";
	$alpha .= "</ul></div>";

	return $alpha;
}

function cdash_starts_with_query_filter( $where, $query ) {
    global $wpdb;

    $starts_with = $query->get( 'starts_with' );

		if($starts_with === '0'){
				$where .= " AND $wpdb->posts.post_title regexp '^[0-9].*'";
		} elseif($starts_with){
				$where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
		}
    return $where;
}
add_filter( 'posts_where', 'cdash_starts_with_query_filter', 10, 2 );

function cdash_display_business_listings($add, $single_link, $image, $image_size, $post_id, $logo_gallery, $text, $display, $displayopts, $cd_block, $changeTitleFontSize, $titleFontSize, $displayImageOnTop, $border_styles){
	if(!isset($business_list)){
		$business_list = '';
	}
	$business_list .= "<div class='" . $add . " business " . $border_styles['class'] . ' ' . join(' ', get_post_class() ) . "' " . $border_styles['border'] . ">";

	$business_list .= cdash_display_bus_title_and_image($cd_block, $single_link, $changeTitleFontSize, $titleFontSize, $displayImageOnTop, $image, $image_size, $post_id, $logo_gallery, $text);

	if($logo_gallery == "no"){
		$business_list .= cdash_bus_directory_display_meta_fields($display, $displayopts);
		$options = get_option( 'cdash_directory_options' );
		if( isset($options['bus_custom'] )) {
			$business_list .= cdash_display_custom_fields( get_the_id() );
		}
		$business_contacts = '';
		$business_list .= apply_filters( 'cdash_end_of_shortcode_view', $business_contacts );
	}


	$business_list .= "</div>";

	return $business_list;
}

function cdash_bus_directory_display_title($single_link, $cd_block, $changeTitleFontSize, $titleFontSize){
	if(!isset($business_list)){
		$business_list = '';
	} 
	$size = '';
	if($cd_block == 'yes'){
		if(isset($changeTitleFontSize) && $changeTitleFontSize == 1){
			//$size = " style='font-size:".$titleFontSize."px'";
			$size = " style='font-size:".$titleFontSize."px'";
			//$size = " style='font-size:".$font_size."'";
		}
	}	if($single_link == "yes") {
		$business_list .= "<h3". $size ."><a href='" . get_the_permalink() . "'>" . get_the_title() . "</a></h3>";
	} else {
		$business_list .= "<h3". $size .">" . get_the_title() . "</h3>";
    }

    return $business_list;
}

function cdash_bus_directory_display_image($image, $image_size, $single_link, $post_id, $logo_gallery){
	if(!isset($business_list)){
		$business_list = '';
	}

	if(isset($image_size) && $image_size !=""){
		$image_class = $image_size . " ". $image;
	}else{
		$image_class = "alignleft auto " . $image;
		//$image_class = "alignleft ";
	}
	
	if( "logo" == $image ) {
		global $buslogo_metabox;
		$logometa = $buslogo_metabox->the_meta();
		if( isset( $logometa['buslogo'] ) ) {
		$logoattr = array(
			//'class'	=> 'alignleft logo',
			//'class'	=> $image_size . ' logo',
			'class' => $image_class,
			//'alt' => 'testing alt atribute'
			);
			if( $single_link == "yes" ) {
				$business_list .= "<a href='" . get_the_permalink() . "'>" . wp_get_attachment_image($logometa['buslogo'], $image_size, 0, $logoattr ) . "</a>";
			} else {
				$business_list .= wp_get_attachment_image($logometa['buslogo'], $image_size, 0, $logoattr );
			}
		}
	} elseif( "featured" == $image ) {
		if($logo_gallery == "no"){
			$thumbattr = array(
				//'class'	=> 'alignleft logo',
				'class'	=> $image_class,
			);
			if( $single_link == "yes" ) {
				$business_list .= cdash_display_featured_image($post_id, true, get_the_permalink(), $image_size, $thumbattr);
			} else {
				$business_list .= cdash_display_featured_image($post_id, false, '', $image_size, $thumbattr);
			}
		}else{
			$business_list .= '';
		}

	}

	return $business_list;
}

function cdash_display_bus_title_and_image($cd_block, $single_link, $changeTitleFontSize, $titleFontSize, $displayImageOnTop, $image, $image_size, $post_id, $logo_gallery, $text){
	if(!isset($business_list)){
		$business_list = '';
	}

	if($logo_gallery == "yes"){
		//$business_list .= "<div class='description'>";
		$business_list .= cdash_bus_directory_display_image($image, $image_size, $single_link, $post_id, $logo_gallery);
		//$business_list .= "</div>";
	}elseif($cd_block == "yes" && $displayImageOnTop == "yes"){

		//display image, title, content
		//$business_list .= "<div class='description bus_listing_image'>";
		$business_list .= cdash_bus_directory_display_image($image, $image_size, $single_link, $post_id, $logo_gallery);
		//$business_list .= "</div>";
		$business_list .= cdash_bus_directory_display_title($single_link, $cd_block, $changeTitleFontSize, $titleFontSize);
		$business_list .= "<div class='description bus_content'>";
		$business_list .= cdash_bus_directory_display_content($text);
		$business_list .= "</div>";
	}else{
		//display title, image and content
		$business_list .= cdash_bus_directory_display_title($single_link, $cd_block, $changeTitleFontSize, $titleFontSize);
		$business_list .= "<div class='description'>";
		$business_list .= cdash_bus_directory_display_image($image, $image_size, $single_link, $post_id, $logo_gallery);
		$business_list .= '<span class="bus_content">' . cdash_bus_directory_display_content($text) . '</span>';
		$business_list .= "</div>";
	}
	return $business_list;
}

function cdash_bus_directory_display_content($text){
	if(!isset($business_list)){
		$business_list = '';
	}

	if( "excerpt" == $text ) {
		$business_list .= get_the_excerpt();
	} elseif( "description" == $text ) {
		$business_list .= get_the_content();
	}

	return $business_list;
}

function cdash_bus_directory_display_meta_fields($display, $displayopts){
	if(!isset($business_list)){
		$business_list = '';
	}
	if( '' !== $display ) {
		global $buscontact_metabox;
		$contactmeta = $buscontact_metabox->the_meta();
		if( isset( $contactmeta['location'] ) ) {
			$locations = $contactmeta['location'];
			if( is_array( $locations ) ) {
				foreach( $locations as $location ) {
					if( isset( $location['donotdisplay'] ) && "1" == $location['donotdisplay'] ) {
						continue;
					}else{
						if( in_array( "location_name", $displayopts ) && isset( $location['altname'] ) && '' !== $location['altname'] ) {
							$business_list .= "<p class='location-name'>" . $location['altname'] . "</p>";
						}
						if( in_array( "address", $displayopts ) ) {
								$business_list .= cdash_display_address( $location );
						}
						if( in_array( "hours", $displayopts ) && isset( $location['hours'] ) && '' !== $location['hours'] ) {
								$business_list .= $location['hours'];
						}

						if( in_array( "phone", $displayopts ) && isset( $location['phone'] ) && '' !== $location['phone'] ) {
							$business_list .= cdash_display_phone_numbers( $location['phone'] );
						}

						if( in_array( "email", $displayopts ) && isset( $location['email'] ) && '' !== $location['email'] ) {
							$business_list .= cdash_display_email_addresses( $location['email'] );
						}

						if( in_array( "url", $displayopts ) && isset( $location['url'] ) && '' !== $location['url'] ) {
							$business_list .= cdash_display_url( $location['url'] );
						}
					}
				}
			}
		}
		if( in_array( "social_media", $displayopts ) ) {
			$business_list .= cdash_display_social_media( get_the_id() );
		}

		if(in_array("level", $displayopts)){
			$business_list .= cdash_display_membership_level( get_the_id() );
		}else if( isset( $options['tax_memberlevel'] ) && "1" == $options['tax_memberlevel'] ) {
			$business_list .= cdash_display_membership_level( get_the_id() );
			}

		if( in_array( "category", $displayopts ) ) {
			$business_list .= cdash_display_business_categories( get_the_id() );
		}

		if( in_array( "tags", $displayopts ) ) {
			$business_list .= cdash_display_business_tags( get_the_id() );
		}
	}

	return $business_list;
}

function cdash_bus_logo_exists(){
	global $buslogo_metabox;
	$logometa = $buslogo_metabox->the_meta();
	if( isset( $logometa['buslogo'] ) ) {
		return true;
	}else{
		return false;
	}
}

function cdash_display_bus_cat_filter(){
    if(!isset($business_list)){
        $business_list = '';
    }
    global $wp;
    // remove pagination from url
    $pattern = "/page(\/)*([0-9\/])*/i";
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
    $url = preg_replace($pattern, '', $current_url);
    $business_list .= '<p class="cdash_cat_filter">' . cdash_bus_cat_dropdown();
    if(isset($_GET['bus_category'])){
        $business_list.= '<a href="'.$url.'">Clear Filter</a>';
    }
    $business_list .= '</p>';
    $business_list .= '<p id="cdash_bus_list_page">'.$url.'</p>';
    if(isset($_GET['bus_category'])){
        $bus_cat_slug = sanitize_text_field($_GET['bus_category']);
        $bus_cat_name = get_term_by('slug', $bus_cat_slug, 'business_category');
        $business_list .= '<p>Category: ' . $bus_cat_name->name . '</p>';
    }
    return $business_list;
}
?>
