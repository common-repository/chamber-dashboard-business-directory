<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function cdash_simple_export() {
//output the headers for the CSV file
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header('Content-Description: File Transfer');
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=chamber-dashboard-export.csv");
	header("Expires: 0");
	header("Pragma: public");

//open the file
	$fh = @fopen('php://output', 'w');

//Add the UTF-8 BOM so that Excel knows how to deal with it
fwrite($fh, chr(0xEF).chr(0xBB).chr(0xBF));

// Find all the businesses
	$args = array(
		'post_type' => 'business',
		'posts_per_page' => -1,
		'order' => 'ASC',
	);

// Find out how many locations there are, so that we know how many columns to put in the CSV
	$exportquery = new WP_Query($args);
	$numberoflocations = 0;

	if ($exportquery->have_posts()) :
		while ($exportquery->have_posts()) : $exportquery->the_post();
			$id = get_the_id();
			$variable = get_post_meta($id, '_cdash_location', true);
			if (sizeof($variable) > $numberoflocations) {
				$numberoflocations = sizeof($variable);
			}
		endwhile;
	endif;

// Get a list of headers we need for each business
	$header = array(
		'Business Name',
		'Description',
		'Category',
		'Membership Level',
	);

// Get a list of the headers we need for each location
	$locationheaders = array(
		'Location Name',
		'Address',
		'City',
		'State',
		'Zip',
    	'Country',
    	'Hours',
		'URL',
		'Phone',
		'Email',
	);

// Add location headers to the list of business headers
	for ($i = 0; $i < $numberoflocations; $i++) {
		$header = array_merge($header, $locationheaders );
	}
	unset($i);

// Add the headers to the CSV
	fputcsv($fh, $header);

// Loop through businesses and add a line to the CSV for each business
	if ($exportquery->have_posts()) :
		while ($exportquery->have_posts()) : $exportquery->the_post();
			$post_id = get_the_id();
			$cats = wp_get_post_terms($post_id, 'business_category', array('fields' => 'names'));
			if( isset( $cats ) && is_array( $cats ) ) {
	      $cats_new = array_map('cdash_export_html_decode', $cats);
	      $catlist = implode(", ", $cats_new);
	    }
      //$catlist = implode(", ", $cats);
			$levels = wp_get_post_terms($post_id, 'membership_level', array('fields' => 'names'));
			$levellist = implode(", ", $levels);
			//$title = get_the_title();
			$title = get_the_title();
			//$title_export = preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $title);
			$title = html_entity_decode($title);
			//$fields[] = utf8_decode(wp_specialchars_decode(html_entity_decode(get_the_title() )));
			$content = html_entity_decode(get_the_content() );
			$fields = array(
				$title,
				$content,
        $catlist,
				//'Membership Level'
				$levellist,
			);
			global $buscontact_metabox;
			$contactmeta = $buscontact_metabox->the_meta();
			if (isset($contactmeta['location']) && is_array($contactmeta['location'])) {
				$locations = $contactmeta['location'];
				foreach ($locations as $location) {
					$locationinfo = array(
						'altname' => '',
						'address' => '',
						'city' => '',
						'state' => '',
						'zip' => '',
            			'country' => '',
           				'hours' => '',
						'url' => '',
					);
					foreach ($locationinfo as $key => $value) {

						if (isset($location[$key])) {
							#$locationinfo[$key.$location_number] = $location[$key];
							$fields[] = $location[$key];
						} else {
							#$locationinfo[$key.$location_number] = '';
							$fields[] = '';
						}
					}


					if (isset($location['phone'])) {
						$phones = $location['phone'];
						if (is_array($phones)) {
							$phoneinfo = '';
							foreach ($phones as $phone) {
								$phoneinfo .= $phone['phonenumber'];
								if (isset($phone['phonetype']) && '' !== $phone['phonetype']) {
									$phoneinfo .= " (" . $phone['phonetype'] . ")";
								}
							}
							$fields[] = $phoneinfo;
						}
					} else {
						$fields[] = '';
					}

					if (isset($location['email'])) {
						$emails = $location['email'];
						if (is_array($emails)) {
							$emailinfo = '';
							foreach ($emails as $email) {
								$emailinfo .= $email['emailaddress'];
								if (isset($email['emailtype']) && '' !== $email['emailtype']) {
									$emailinfo .= " (" . $email['emailtype'] . ")";
								}
							}
							$fields[] = $emailinfo;
						}
					} else {
						$fields[] = '';
					}
				}
			}

// Add the business to the CSV
			fputcsv($fh, $fields);

		endwhile;
	endif;

// Reset Post Data
	wp_reset_postdata();
// Close the file stream
	fclose($fh);
}

function cdash_export_html_decode($cat_name){
  return html_entity_decode($cat_name, ENT_HTML5);
}
?>
