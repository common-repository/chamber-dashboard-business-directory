<?php 
//Business Directory Category Shortcode rendering
if ( function_exists( 'register_block_type' ) ) {
    // Hook server side rendering into render callback
    register_block_type(
        'cdash-bd-blocks/business-category', [
            'render_callback' => 'cdash_bus_category_block_callback',
            'attributes'  => array(
                'align' => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'cd_block'  => array(
                    'type'  => 'string',
                    'default' => 'yes',
                ),
                'format'  => array(
                    'type'  => 'string',
                    'default' => 'list',
                ),
                'orderby'  => array(
                    'type'  => 'string',
                    'default' => 'name',
                ),
                'order'  => array(
                    'type'  => 'string',
                    'default' => 'ASC',
                ),
                'showcount'  => array(
                    'type'  => 'number',
                    'default' => 0,
                ),
                'showCountToggle'  => array(
                    'type'  => 'boolean',
                    'default' => false,
                ),
                'hierarchical'  => array(
                    'type'  => 'number',
                    'default' => 1,
                ),
                'hierarchyToggle'  => array(
                    'type'  => 'boolean',
                    'default' => true,
                ),
                'hide_empty'  => array(
                    'type'  => 'number',
                    'default' => 1,
                ),
                'hideEmptyToggle'  => array(
                    'type'  => 'boolean',
                    'default' => true,
                ),
                'child_of'  => array(
                    'type'  => 'number',
                    'default' => 0,
                ),
                'exclude'  => array(
                    'type'  => 'number',
                    'default' => 0,
                ),
                'excludeCategories' => array(
                    'type'  => 'array',
                    'default'  => array(),
                ),
                'depth' => array(
                    'type'  => 'number',
                    'default'   => 0
                ),
            ),
        ]
    );
}

function cdash_bus_category_block_callback($attributes){
    $business_categories = '';

    if(isset($attributes['excludeCategories']) && '' != $attributes['excludeCategories']){
        $attributes['exclude'] = $attributes['excludeCategories'];
    }

    $business_categories .= cdash_business_categories_shortcode($attributes);

    return $business_categories;
}
?>