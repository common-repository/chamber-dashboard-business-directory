<?php
// ------------------------------------------------------------------------
// BUSINESS CATEGORIES SHORTCODE
// ------------------------------------------------------------------------
function cdash_business_categories_shortcode( $atts ) {
	// Set our default attributes
	extract( shortcode_atts(
		array(
        'align' => '',
        'cd_block'  => '',
		'orderby' => 'name', // options: name, count
		'order' => 'ASC',
		'showcount' => 0,
		'hierarchical' => 1,
		'hide_empty' => 1, //can be 0
		'child_of' => 0,
		'exclude' => '',
        'format' 	=> 'list', //options are list, grid
        'showCatImage' => 0,
        'showCatDesc'   => 0,
        'depth' => 0
		), $atts )
	);

	$taxonomy = 'business_category';
	$args = array(
		'taxonomy' => $taxonomy,
		'orderby' => $orderby,
		'order' => $order,
		'show_count' => $showcount,
		'hierarchical' => $hierarchical,
		'hide_empty' => $hide_empty,
		'child_of' => $child_of,
		'exclude' => $exclude,
		'echo' => 0,
        'title_li' => '',
        'depth' => $depth
    );
    
    if($format == 'grid'){
		$args['style'] = '';
	}

	$taxonomies = get_terms( $args );
    if($cd_block){
        $align_class = 'align'.$align;
    }else{
        $align_class='';
    }

	if($format == 'list'){
		$categories = '<ul class="business-categories ' . $align_class. '">' . 	wp_list_categories($args) . '</ul>';
	}else if($format == 'grid'){
		cdash_enqueue_styles();
		$categories = display_categories_grid($taxonomies, $showcount, $showCatImage, $showCatDesc, $hierarchical, $align_class, $depth, $child_of);
	}
	return $categories;
}
add_shortcode( 'business_categories', 'cdash_business_categories_shortcode' );

?>
