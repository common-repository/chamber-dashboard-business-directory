<?php 
//get people connected to the user, get the first person from the connection
//if there is no such person, logout
function cdash_get_person_id_from_user_id($user_id, $include_pending){
    if($user_id == null){
        return null;
    }

    //Find connected people

    $connection_params = array(
        'connected_type' => 'people_to_user',
        'connected_items' => $user_id,
        'nopaging' => true
    );

    if($include_pending){
        $connection_params['post_status'] = 'any';
    }

    $connected = new WP_Query($connection_params);

    //Get the person ID
    if($connected->have_posts()):

    while($connected->have_posts() ): $connected->the_post();
        //get the person connected to the user
        $person_id = get_the_ID();
        break;
    endwhile;

    //Prevent wierdness
    wp_reset_postdata();

    else:
    $person_id = null;
    endif;

    return $person_id;
}

//get businesses connected to the person and get the first business id
function cdash_get_business_id_from_person_id($person_id, $include_pending) {
    if($person_id == null){
        return null;
    }
    // Find connected businesses

    $connection_params = array(
	  'connected_type' => 'businesses_to_people',
	  'connected_items' => $person_id,
	  'nopaging' => true
	);

    if($include_pending){
        $connection_params['connected_query'] = array('post_status' => 'any');
    }
    $connected = new WP_Query( $connection_params);


    // Get the business ID
    if ( $connected->have_posts() ) :

    while ( $connected->have_posts() ) : $connected->the_post();
        //get the business connected to the person
        $business_id = get_the_ID();
        break;
    endwhile;

    // Prevent weirdness
    wp_reset_postdata();

    else:
        $business_id = null;
    endif;

    return $business_id;
}
?>