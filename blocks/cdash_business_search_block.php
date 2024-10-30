<?php 
//Business Directory Shortcode rendering
if ( function_exists( 'register_block_type' ) ) {
    // Hook server side rendering into render callback
    register_block_type(
        'cdash-bd-blocks/business-directory-search', [
            'render_callback' => 'cdash_bus_directory_search_block_callback',
            'attributes'  => array(
                'searchFormTitleDisplay'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'searchFormCustomTitle' => array(
                    'type'  => 'string',
                    'default'   => __('Search', 'cdash'),
                ),
                'searchFormAlignment'    => array(
                    'type'  => 'string',
                    'default'   => 'left',
                ),
                'searchFormLabelDisplay'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'customSearchFormLabel' => array(
                    'type'  => 'string',
                    'default'   => __('Search Term', 'cdash'),
                ),
                'categoryFieldDisplay'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'categoryFieldLabelDisplay'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'customCategoryFieldLabel'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'searchInputPlaceholder'    => array(
                    'type'  => 'string',
                    'default'   => '',
                ),
                'searchDisplayFormat'    => array(
                    'type'  => 'string',
                    'default'   => 'list',
                ),
                'displayDescription'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayMemberLevel'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayCategory'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayTags'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displaySocialMedia'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayUrl'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayEmail'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'perPage'    => array(
                    'type'  => 'number',
                    'default'   => -1,
                ),
                'orderBy'    => array(
                    'type'  => 'string',
                    'default'   => 'title',
                ),
                'order'    => array(
                    'type'  => 'string',
                    'default'   => 'asc',
                ),
                'imageType'    => array(
                    'type'  => 'string',
                    'default'   => 'featured',
                ),
                'imageSize'    => array(
                    'type'  => 'string',
                    'default'   => 'medium',
                ),
                'imageAlignment'    => array(
                    'type'  => 'string',
                    'default'   => 'left',
                ),
                'displayLocationName'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayAddress'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayWebsite'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayHours'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'displayPhone'    => array(
                    'type'  => 'boolean',
                    'default'   => 'true',
                ),
                'businessTitleFontSize' => array(
                    'type'  => 'number',
                    'default'   => 26,
                ),
                'businessLocationNameFontSize' => array(
                    'type'  => 'number',
                    'default'   => 26,
                ),
            )
        ]
    );
}

function cdash_bus_directory_search_block_callback($attributes){
    $search = '';
    //check if search_query is set

    //if search query is set, and there are results, show the search form and the results below it

    //if there are no search resutls, show the sorry message and the search form

    //if the search_query is not set, show the search form

    $search .= cdash_business_search_block_output($attributes);

    return $search;

    //return "This is the search block!";
}
?>