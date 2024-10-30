<?php
add_filter( 'wp_privacy_personal_data_erasers', 'cdash_people_eraser', 20 );

function cdash_people_eraser( $people_erasers ) {
    $people_erasers['chamber-dashboard-people'] = array(
        'eraser_friendly_name' => 'CD People Eraser', //isn't shown anywhere
        'callback' => 'cdash_people_eraser_function', //name of the callback function which is below
    );
    return $people_erasers;
}

add_filter( 'wp_privacy_personal_data_erasers', 'cdash_business_eraser', 10 );
function cdash_business_eraser($business_erasers){
    $business_erasers['chamber-dashboard-business'] = array(
        'eraser_friendly_name' => 'CD Business Eraser', //isn't shown anywhere
        'callback' => 'cdash_business_eraser_function', //name of the callback function which is below
    );
    return $business_erasers;
}

function cdash_people_eraser_function($email_address, $iteration = 1){
    $iteration = (int) $iteration;
    $items_removed = false;

    global $person_metabox;

    $user = get_user_by( 'email', $email_address );

    $user_id = $user->ID;

    $person_id = cdash_get_person_id_from_user_id($user_id, true);
    
    
    // Find connected posts
	$people = get_posts( array(
		'connected_type' => 'people_to_user',
	  	'connected_items' => get_queried_object(),
	  	'nopaging' => true,
		'suppress_filters' => false
    ) );
    
    if($people){
        foreach ( (array) $people as $person ){
            $person_id = $person->ID;
            //$person_meta = $person_metabox->the_meta($person->ID);
            $my_post = array(
                'ID' => $person_id,
                'post_title' => 'Anonymous',
                'post_status' => 'draft'
            );
            //wp_update_post($my_post);
            // Delete connection
            p2p_type( 'people_to_user' )->disconnect( $person, $user );
            //Delete the person record
            wp_delete_post($person_id);
            
            $items_removed = true;
        }
    }

    $done = count( $people ) < $iteration;
    
	return array(
		'items_removed' => $items_removed,
		'items_retained' => false,
		'messages' => array(''), // you can add any custom message to be shown in /wp-admin/
		'done' => $done,
	);
}

function cdash_business_eraser_function($email_address, $iteration = 1){
    $iteration = (int) $iteration;
    $items_removed = false;

    global $buscontact_metabox;
	$contactmeta = $buscontact_metabox->the_meta();

	global $person_metabox;
    
    global $billing_metabox;
    $billing_meta = $billing_metabox->the_meta();
    
    $businesses_with_matching_billing_email = get_posts( array(
		'post_type' => 'business',
		'posts_per_page' => 100, // how much to process each time
		'paged' => $iteration,
		'meta_key'	=> '_cdash_billing_email',
		'meta_value' => $email_address
    ) );

    // Find businesses connected to people & users
	$user = get_user_by( 'email', $email_address );
	$user_id = $user->ID;

	$person_id = cdash_get_person_id_from_user_id($user_id, true);

	$business_id = cdash_get_business_id_from_person_id($person_id, true);

	$businesses_connected_to_people = get_posts( array(
		'connected_type' => 'businesses_to_people',
	  	'connected_items' => $person_id,
	  	'nopaging' => true,
		'suppress_filters' => false
    ) );
    
    $businesses = array_merge($businesses_with_matching_billing_email, $businesses_connected_to_people);
    
    if($businesses){
        foreach ( (array) $businesses as $business ){
            $business_id = $business->ID;
            $my_post = array(
                'ID' => $business_id,
                'post_title' => $business->post_title . __(' - Delete per GDPR', 'cdash'),
                'post_status' => 'draft'
            );
            wp_update_post($my_post);
            $items_removed = true;
        }
    }

    $done = count( $businesses ) < $iteration;
    return array(
		'items_removed' => $items_removed,
		'items_retained' => false,
		'messages' => array(''), // you can add any custom message to be shown in /wp-admin/
		'done' => $done,
	);


}

?>