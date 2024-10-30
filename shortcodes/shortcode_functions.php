<?php
function cdash_bus_cat_dropdown(){
    $args = array(
		'taxonomy' => 'business_category',
		'orderby' => 'name',
		'order' => 'ASC',
		'show_count' => 0,
		'hierarchical' => 1,
		'hide_empty' => 1,
		'child_of' => 0,
		'exclude' => '',
		'echo' => 0,
		'title_li' => '',
        'id' => 'cdash_select_bus_category',
        'show_option_none'  => __('Filter by Category', 'cdash'),
        'value_field'      => 'slug'
	);

    $bus_categories = wp_dropdown_categories($args);
    return $bus_categories;
}
?>
