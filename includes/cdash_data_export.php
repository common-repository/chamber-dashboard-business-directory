<?php
//if(cdash_check_cd_crm_active()){
	add_filter( 'wp_privacy_personal_data_exporters', 'cdash_register_people_exporter', 10);
//}
	function cdash_register_people_exporter( $exporters_array ) {
		if(cdash_check_cd_crm_active()){
			$exporters_array['chamber-dashboard-people'] = array(
				'exporter_friendly_name' => 'CD People exporter', //isn't shown anywhere
				'callback' => 'cdash_people_exporter_function', //name of the callback function which is below
			);
		}else{
			$exporters_array = [];
		}
		
		return $exporters_array;
	}


add_filter( 'wp_privacy_personal_data_exporters', 'cdash_register_business_exporter', 10);
function cdash_register_business_exporter( $exporters_array ) {
	$exporters_array['chamber-dashboard-business-directory'] = array(
		'exporter_friendly_name' => 'CD Business exporter', //isn't shown anywhere
		'callback' => 'cdash_business_exporter_function', //name of the callback function which is below
	);
	return $exporters_array;
}


function cdash_people_exporter_function($email_address, $page = 1){
	// Limit us to 500 at a time to avoid timing out.
	$number = 500;
	$page   = (int) $page;
	
	global $person_metabox;

	$export_items = array();

	//Check if there are any prople records connected to the user with the given email
	$user = get_user_by( 'email', $email_address );
	$user_id = $user->ID;

	if(cdash_check_cd_crm_active()){
		$person_id = cdash_get_person_id_from_user_id($user_id, true);

		global $person_metabox;
		$person_details = array();

		$options = get_option( 'cdcrm_options' );

		// Find connected posts
		$people = get_posts( array(
			'connected_type' => 'people_to_user',
			'connected_items' => get_queried_object(),
			'nopaging' => true,
			'suppress_filters' => false
		) );
	}else{
		$people = '';
	}

	
	if($people != ''){
        foreach ( (array) $people as $person ){
			$person_meta = $person_metabox->the_meta($person->ID);
			$person_details = cdash_get_person_data($person, $person_meta);

			$data = array(
				array(
					'name' => __('Name', 'cdash'),
					'value' => $person->post_title
				),
				array(
					'name' => __('Emails', 'cdash'),
					'value' => $person_details['email']
				),
				array(
					'name' => __('Phone Numbers', 'cdash'),
					'value' => $person_details['phone']
				),
				array(
					'name' => __('Address', 'cdash'),
					'value' => $person_details['address']
				),
			);

			$export_items[] = array(
                'group_id' => 'cd_people',
				'group_label' => __('People', 'cdash'),
				'group_description' => __( 'User&#8217;s Chamber Dashboard People data.', 'cdash' ),
                'item_id' => 'person-'.$person->ID,
                'data' => $data
           );
		}
	}
		
	$done = count( $people ) < $number;
	return array(
		'data' => $export_items,
		'done' => $done,
	);
}

function cdash_business_exporter_function($email_address, $page = 1){
	// Limit us to 500 at a time to avoid timing out.
	$number = 500;
    $page   = (int) $page;
    
    $export_items = array();
	
	global $buscontact_metabox;
	$contactmeta = $buscontact_metabox->the_meta();

	//global $person_metabox;
    
    global $billing_metabox;
	$billing_meta = $billing_metabox->the_meta();
	
	if(isset($billing_meta['billing_email'])){
		$billing_email = $billing_meta['billing_email'];
	}else{
		$billing_email = '';
	}

	//Get businesse with matching billing email
	$businesses_with_matching_billing_email = get_posts( array(
		'post_type' => 'business',
		'posts_per_page' => 100, // how much to process each time
		'paged' => $page,
		'meta_key'	=> '_cdash_billing_email',
		'meta_value' => $email_address
	) );

	// Find businesses connected to people & users
	$user = get_user_by( 'email', $email_address );
	$user_id = $user->ID;
	
	if(cdash_check_cd_crm_active()){
		$person_id = cdash_get_person_id_from_user_id($user_id, true);

		$business_id = cdash_get_business_id_from_person_id($person_id, true);

		$businesses_connected_to_people = get_posts( array(
			'connected_type' => 'businesses_to_people',
			'connected_items' => $person_id,
			'nopaging' => true,
			'suppress_filters' => false
		) );
		$businesses = array_merge($businesses_with_matching_billing_email, $businesses_connected_to_people);
	}else{
		$businesses = $businesses_with_matching_billing_email;
	}

    if($businesses){
		global $buscontact_metabox;
		global $billing_metabox;
    	
		
        foreach ( (array) $businesses as $business ){
			$contactmeta = $buscontact_metabox->the_meta($business->ID);
			$billing_meta = $billing_metabox->the_meta($business->ID);
			
			$business_details = cdash_export_bus_location_data($contactmeta);
   
            // here you can specify the fields, that exist in any way
			$data = array(
				array(
					'name' => 'Business Name',
					'value' => $business->post_title
				),
				array(
					'name' => 'Billing Email',
					'value' => $billing_meta['billing_email']
				),
				array(
					'name' => 'Address',
					'value' => $business_details['address']
				),
				array(
					'name' => 'Phone',
					'value' => $business_details['phone']
				),
				array(
					'name' => 'Email',
					'value' => $business_details['email']
				),
            );
            $export_items[] = array(
                'group_id' => 'businesses',
                'group_label' => 'Businesses',
                'item_id' => 'business-'.$business->ID,
                'data' => $data
           );
        }	
}
	// $done identifies whether or not the number of $comments is less than $number. If it is, all comments have been processed and we're done.
	$done = count( $businesses ) < $number;
	// The function should return an array with the (array)'data' to be exported and whether or not we're (bool)'done'
	return array(
		'data' => $export_items,
		'done' => $done,
	);

}

function cdash_export_bus_location_data($contactmeta){
	$business_details = array();
	$locations = $contactmeta['location'];
	$phone_number = '';
	$email = '';
	$business_address = '';
	if( isset( $contactmeta['location'] ) ) {
		foreach( $locations as $location ) {
			if(isset( $location['address'] ) ){
				$address = $location['address'];
			}else{
				$address = "";
			}

			if(isset( $location['city'] ) ){
				$city = $location['city'];
			}else{
				$city = '';
			}

			if(isset( $location['state'] ) ){
				$state = $location['state'];
			}else{
				$state = '';
			}

			if(isset( $location['zip'] ) ){
				$zip = $location['zip'];
			}else{
				$zip = '';
			}

			if(isset( $location['country'] ) ){
				$country = $location['country'];
			}else{
				$country = '';
			}
			$business_address = $address . ', ' . $city . ', ' . $state . ' ' . $zip . ' ' . $country;
			$business_details['address'] = $business_address;

			if(isset($location['phone'])) {
				$phones = $location['phone'];
				if(is_array($phones)) {
					foreach($phones as $phone) {
						if(isset($phone['phonenumber'])){
							$phone_number .= $phone['phonenumber'] . ', ';
						}
					}
					$phone_number = rtrim($phone_number, ', ');
				}
			}else{
				$phone_number = '';
			}
			$business_details['phone'] = $phone_number;

			$email_address = '';
			if(isset($location['email'])) {
				$emails = $location['email'];
				if(is_array($emails)) {
					foreach($emails as $email) {
						if(isset($email['emailaddress'])){
							$email_address .= $email['emailaddress'] . ', ';
						}
					}
					$email_address = rtrim($email_address, ', ');
				}
			}else{
				$email_address = '';
			}
			$business_details['email'] = $email_address;
		}
	}
	return $business_details;
}

function cdash_get_person_data($person, $person_meta){
	$person_details = array();
	$email_address = '';
	$phone_numbers = '';
	if(isset($person->title) && ''!= $person->title){
		$person_details['name'] = $person->title;
	}else{
		$person_details['name'] = '';
	}

	if(isset($person_meta['email']) && '' != $person_meta['email']){
		$emails = $person_meta['email'];
		if(is_array($emails)){
			foreach($emails as $email){
				if(isset($email['emailaddress'])){
					$email_address .= $email['emailaddress'] . ', ';
				}
			}
			$email_address = rtrim($email_address, ', ');
		}
	}else{
		$email_address = '';
	}
	$person_details['email'] = $email_address;

	if(isset($person_meta['phone']) && '' != $person_meta['phone']){
		$phones = $person_meta['phone'];
		if(is_array($phones)){
			foreach($phones as $phone){
				if(isset($phone['phonenumber'])){
					$phone_numbers .= $phone['phonenumber'] . ', ';
				}
			}
			$phone_numbers = rtrim($phone_numbers, ', ');
		}
	}else{
		$phone_numbers = '';
	}
	$person_details['phone'] = $phone_numbers;

	if( isset( $person_meta['address'] ) && '' !== $person_meta['address'] ) {
		$person_address = $person_meta['address']; 
	}else{
		$person_address = '';
	}

	if( isset( $person_meta['city'] ) && '' !== $person_meta['city'] ) {
		$person_city = $person_meta['city']; 
	}else{
		$person_city = '';
	}

	if( isset( $person_meta['state'] ) && '' !== $person_meta['state'] ) {
		$person_state = $person_meta['state']; 
	}else{
		$person_state = '';
	}

	if( isset( $person_meta['zip'] ) && '' !== $person_meta['zip'] ) {
		$person_zip = $person_meta['zip']; 
	}else{
		$person_zip = '';
	}

	$person_address_details = $person_address . ', ' . $person_city . ', ' . $person_state . ' ' . $person_zip;
	$person_details['address'] = $person_address_details;

	return $person_details;
}


?>