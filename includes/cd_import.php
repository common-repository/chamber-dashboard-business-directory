<?php
function cdash_import_form() { ?>
	<!--<div class="wrap">-->
	<h2><?php _e('Import', 'cdash'); ?></h2>
	<span class="desc"></span>
	<div class="content">
		<h4><?php _e( 'Import Businesses', 'cdash' ); ?></h4>
		<p><?php _e('Chamber Dashboard Business Directory plugin includes a free import feature. You can import businesses from a CSV file.  First, you must format the CSV properly.  Your CSV must have the following columns in the following order, even if some of the columns are empty: <ul><li>Business Name</li><li>Description</li><li>Category (separate multiple with semicolons)</li><li>Membership Level (separate multiple with semicolons)</li><li>Location Name</li><li>Address</li><li>City</li><li>State</li><li>Zip</li><li>Country</li><li>Business Hours</li><li>URL</li><li>Phone (separate multiple with semicolons)</li><li>Email (separate multiple with semicolons)</li></ul>', 'cdash'); ?></p>
		<p><?php _e( 'Some programs format CSV files differently.  You might need to use either Google Drive or Open Office to save your CSV file so that it will upload correctly. Visit our <a href="https://chamberdashboard.com/docs/plugin-features/import-export/" target="_blank">documentation</a> pages for more information.', 'cdash' ); ?></p>
		<p><a href="https://chamberdashboard.com/docs/plugin-features/business-directory/add-import-listings/" target="_blank"><?php _e('Download a sample CSV to see how to format your file.', 'cdash'); ?></a></p>
		<?php wp_import_upload_form('admin.php?page=cd-settings&tab=import_export'); ?>
<?php

	$args =  array(
		'post_type' => 'business'
	);
	$query = new WP_Query($args);

	?>
	</div>

		<!--</div>-->

	<?php $file = wp_import_handle_upload();

	if(isset($file['file'])) {

		$row = 0;
		$header_row = [];
		if (($handle = fopen($file['file'], "r")) !== FALSE) {
		    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				 //print_r($data);

		    	if($row == 0) {
		    		// Don't do anything with the header row
		    		$row++;
		    		continue;
		    	} else {
		    		$row++;
					// Get the post data
					if(isset($data[0])){
						$post_title = sanitize_text_field( $data[0] );
					}
					if(isset($data[1])){
						$post_content = sanitize_textarea_field( $data[1] );
					}
					$businessinfo = array (
						'post_type'     => 'business',
						'post_title'    => $post_title,
						'post_content' 	=> $post_content,
						'post_status'   => 'publish',
						);
					// Create a business
					$newbusiness = wp_insert_post($businessinfo, true);
					// Add business categories
					if(isset($data[2])) {
						$categories = explode(';', sanitize_text_field($data[2]));
						wp_set_object_terms( $newbusiness, $categories, 'business_category' );
					}

					// Add membership levels
					if(isset($data[3])) {
						$levels = explode(';', sanitize_text_field($data[3]));
						wp_set_object_terms( $newbusiness, $levels, 'membership_level' );
					}

					// add a serialised array for wpalchemy to work - see http://www.2scopedesign.co.uk/wpalchemy-and-front-end-posts/
					$fields = array('_cdash_location');
					$str = $fields;
					update_post_meta( $newbusiness, 'buscontact_meta_fields', $str );

					// Get all the phone numbers and put them in the array format wpalchemy expects
					$numbers = array();
					if(isset($data[12]) && !empty($data[12])) {
						$tempnums = explode(';', sanitize_text_field($data[12]));
						foreach ($tempnums as $number) {
							$numbers[]['phonenumber'] = $number;
						}
					} else {
						$numbers = '';
					}

					// Get all the email addresses and put them in the array format wpalchemy expects
					$emails = array();
					if(isset($data[13]) && !empty($data[13])) {
						$tempmails = explode(';', sanitize_email($data[13]));
						foreach ($tempmails as $email) {
							$emails[]['emailaddress'] = $email;
						}
					} else {
						$emails = '';
					}

					//sanitize the input data
					if(isset($data[4])){
						$location_name = sanitize_text_field($data[4]);
					}
					if(isset($data[5])){
						$street_address = sanitize_text_field($data[5]);
					}

					if(isset($data[6])){
						$city = sanitize_text_field($data[6]);
					}

					if(isset($data[7])){
						$state = sanitize_text_field($data[7]);
					}

					if(isset($data[8])){
						$zip = sanitize_text_field($data[8]);
					}

					if(isset($data[9])){
						$country = sanitize_text_field($data[9]);
					}

					if(isset($data[10])){
						$hours = sanitize_text_field($data[10]);
					}

					if(isset($data[11])){
						$url = esc_url($data[11]);
					}

					// Get the geolocation data
					if( isset( $street_address ) ) {
						// ask Google for the latitude and longitude
						$rawaddress = $street_address;
						if( isset( $data[6] ) ) {
							$rawaddress .= ' ' . $city;
						}
						if( isset( $data[7] ) ) {
							$rawaddress .= ' ' . $state;
						}
						if( isset( $data[8] ) ) {
							$rawaddress .= ' ' . $zip;
						}
						$address = urlencode( $rawaddress );
						$json = wp_remote_get(cdash_get_google_map_url($address));
						$json = json_decode($json['body'], true);
						if( is_array( $json ) && $json['status'] == 'OK') {
							$latitude = $json['results'][0]['geometry']['location']['lat'];
							$longitude = $json['results'][0]['geometry']['location']['lng'];
						}else{
							$latitude = '';
							$longitude = '';
						}
					}

					// Create the array of location information for wpalchemy
					$locationfields = array(
							array(
							'altname' 	=> $location_name,
							'address'	=> $street_address,
							'city'		=> $city,
							'state'		=> $state,
							'zip'		=> $zip,
              				'country'   => $country,
              				'hours'     => $hours,
							'latitude'	=> $latitude,
							'longitude'	=> $longitude,
							'url'		=> $url,
							'phone'		=> $numbers,
							'email'		=> $emails,
							)
						);

					// Add all of the post meta data in one fell swoop
					add_post_meta( $newbusiness, '_cdash_location', $locationfields );
				}
		    }
		    $success = $row - 1;
		    echo "<p style='font-size:1.2em;'>" . $success . " businesses successfully imported!</p>";
		    fclose($handle);
		}
	}

	do_action( 'cdash_importer' );
}
