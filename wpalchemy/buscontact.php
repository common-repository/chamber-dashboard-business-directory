<div class="my_meta_control">

	<a href="#" class="dodelete-location button"><?php esc_html_e('Remove All Locations', 'cdash'); ?></a>

	<?php while($mb->have_fields_and_multi('location')): ?>
	<?php $mb->the_group_open(); ?>

		<div class="location clearfix">

		<?php $mb->the_field('altname'); ?>
		<label><?php esc_html_e('Location Name', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>

		<?php $mb->the_field('donotdisplay'); ?>
		<label><?php esc_html_e('Do Not Display', 'cdash'); ?></label>
		<p class="explain"><?php esc_html_e('Check this if you do not want this location to display to the public on the website'); ?></p>
		<p><input type="checkbox" name="<?php esc_attr( sanitize_text_field($mb->the_name())); ?>" value="1"<?php if ($mb->get_the_value()) echo ' checked="checked"'; ?>/> <?php esc_html_e('Do Not Display', 'cdash'); ?></p>

		<div class="address-data">
			<label><?php esc_html_e('Address', 'cdash'); ?></label>
			<p class="address-wrapper">
				<?php $metabox->the_field('address'); ?>
				<textarea class="trigger-geolocation" name="<?php sanitize_text_field($metabox->the_name()); ?>" rows="3"><?php sanitize_textarea_field($metabox->the_value()); ?></textarea>
			</p>

			<?php $options = get_option('cdash_directory_options'); ?>

			<div class="fourth city-wrapper">
				<?php $mb->the_field('city'); ?>
				<label><?php esc_html_e('City', 'cdash'); ?></label>
				<p><input type="text" class="city trigger-geolocation" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
			</div>

			<div class="fourth state-wrapper">
				<?php $mb->the_field('state'); ?>
				<label><?php esc_html_e('State', 'cdash'); ?></label>
				<p><input type="text" class="state trigger-geolocation" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
			</div>

			<div class="fourth zip-wrapper">
				<?php $mb->the_field('zip'); ?>
				<label><?php esc_html_e('Zip', 'cdash'); ?></label>
				<p><input type="text" class="zip trigger-geolocation" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
			</div>

			<div class="fourth country-wrapper">
				<?php $mb->the_field('country'); ?>
				<label><?php esc_html_e('Country', 'cdash'); ?></label>
				<p><input type="text" class="country trigger-geolocation" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
			</div>

			<div class="geolocation-data clearfix">
				<p class="clearfix"><a href="#" class="button button-primary preview-map"><?php esc_html_e( 'Preview Map', 'cdash' ); ?></a></p>
				<div class="map-canvas half" style="width:300px; height: 300px; display: none; margin: 0 20px 20px 0;"></div>
				<a href="#" class="button custom-coords" style="display:none;"><?php esc_html_e( 'Change Map Coordinates', 'cdash' ); ?></a>
				<div class="enter-custom-coords" style="display: none;">
					<p><?php esc_html_e( 'If you want the map marker to appear in a different place, you can enter the latitude and longitude yourself.', 'cdash' ); ?></p>
					<p><a href="http://www.latlong.net/" target="_blank"><?php esc_html_e( 'Find the latitude and longitude', 'cdash' ); ?></a></p>
					<div class="half custom-coords-fields">
						<?php $mb->the_field('custom_latitude'); ?>
						<label><?php esc_html_e( 'Latitude', 'cdash' ); ?></label>
						<input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" class="custom-latitude new-coords" value="<?php sanitize_text_field($mb->the_value()); ?>"/>

						<?php $mb->the_field('custom_longitude'); ?>
						<label><?php esc_html_e( 'Longitude', 'cdash' ); ?></label>
						<input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" class="custom-longitude new-coords" value="<?php sanitize_text_field($mb->the_value()); ?>"/>
						<p class="update-preview">
							<a href="#" class="update-map button"><?php esc_html_e( 'Update Map Preview', 'cdash' ); ?></a>
							<span class="update-reminder" style="display:none;"><?php esc_html_e( 'Make sure you save your changes!', 'cdash' ); ?></span>
						</p>
					</div>
				</div>
				<?php $mb->the_field('latitude'); ?>
				<input type="hidden" name="<?php sanitize_text_field($mb->the_name()); ?>" class="latitude" value="<?php sanitize_text_field($mb->the_value()); ?>"/>

				<?php $mb->the_field('longitude'); ?>
				<input type="hidden" name="<?php sanitize_text_field($mb->the_name()); ?>" class="longitude" value="<?php sanitize_text_field($mb->the_value()); ?>"/>
			</div>
		</div>

		<div class="clearfix">
			<?php $mb->the_field('url'); ?>
			<label><?php esc_html_e('Web Address', 'cdash'); ?></label>
			<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" placeholder="http://"/></p>
		</div>

		<fieldset class="half left phone-fieldset">
			<legend><?php esc_html_e('Phone Number(s)', 'cdash'); ?></legend>

			<a href="#" class="dodelete-phone button"><?php esc_html_e('Remove All Phone Numbers', 'cdash'); ?></a>

			<?php while($mb->have_fields_and_multi('phone')): ?>
			<?php $mb->the_group_open(); ?>
				<?php $mb->the_field('phonenumber'); ?>
				<label><?php esc_html_e('Phone Number', 'cdash'); ?></label>
				<p><input type="text" class="phone" name="<?php esc_attr( $mb->the_name() ); ?>" value="<?php esc_attr( sanitize_text_field($mb->the_value()) ); ?>"/></p>

				<?php $mb->the_field('phonetype'); ?>
				<label><?php esc_html_e('Phone Number Type', 'cdash'); ?></label>
				<?php $selected = ' selected="selected"'; ?>
				<select name="<?php sanitize_text_field($mb->the_name()); ?>">
					<option value=""></option>
					<?php $mb->the_field('phonetype'); ?>
					<?php $options = get_option('cdash_directory_options');
				 	$phonetypes = $options['bus_phone_type'];
					$typesarray = array_map('trim', explode(',', $phonetypes));
				 	//$typesarray = explode( ",", $phonetypes);
				 	foreach ($typesarray as $type) { ?>
				 		<option value="<?php echo $type; ?>" <?php if ($mb->get_the_value() == $type) echo $selected; ?>><?php echo $type; ?></option>
				 	<?php } ?>
				</select>

			<a href="#" class="dodelete button"><?php esc_html_e('Remove This Phone Number', 'cdash'); ?></a>
			<hr />

			<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>
			<p><a href="#" class="docopy-phone button"><?php esc_html_e('Add Another Phone Number', 'cdash'); ?></a></p>
		</fieldset>

		<fieldset class="half email-fieldset">
			<legend><?php esc_html_e('Email Address(es)', 'cdash'); ?></legend>
			<a href="#" class="dodelete-email button"><?php esc_html_e('Remove All Email Addresses', 'cdash'); ?></a>

			<?php while($mb->have_fields_and_multi('email')): ?>
			<?php $mb->the_group_open(); ?>
				<?php $mb->the_field('emailaddress'); ?>
				<label><?php esc_html_e('Email Address', 'cdash'); ?></label>
				<p><input type="text" class="email" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>

				<?php $mb->the_field('emailtype'); ?>
				<label><?php esc_html_e('Email Address Type', 'cdash'); ?></label>
				<?php $selected = ' selected="selected"'; ?>
				<select name="<?php sanitize_text_field($mb->the_name()); ?>">
					<option value=""></option>
					<?php $mb->the_field('emailtype'); ?>
					<?php $options = get_option('cdash_directory_options');
				 	$emailtypes = $options['bus_email_type'];
					$typesarray = array_map('trim', explode(',', $emailtypes));
				 	//$typesarray = explode( ",", $emailtypes);
				 	foreach ($typesarray as $type) { ?>
				 		<option value="<?php echo $type; ?>" <?php if ($mb->get_the_value() == $type) echo $selected; ?>><?php echo $type; ?></option>
				 	<?php } ?>
				</select>

			<a href="#" class="dodelete button"><?php esc_html_e('Remove This Email Address', 'cdash'); ?></a>
			<hr />

			<?php $mb->the_group_close(); ?>
			<?php endwhile; ?>
			<p><a href="#" class="docopy-email button"><?php esc_html_e('Add Another Email Address', 'cdash'); ?></a></p>
		</fieldset>


		<div class="fourth hours-wrapper">
            <?php $mb->the_field('hours'); ?>
            <label><?php esc_html_e('Business Hours', 'cdash'); ?></label>
            <p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
        </div>

        <p class="clearfix"><a href="#" class="button billing-copy"><?php esc_html_e('Use This Location for Billing', 'cdash'); ?></a></p>
		<span class="copy-confirm" style="display: none;"><?php esc_html_e( 'Done!  Make sure you save your changes!', 'cdash' ); ?></span>
		<p class="clearfix"><a href="#" class="dodelete button"><?php esc_html_e('Remove This Location', 'cdash'); ?></a></p>

		</div>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 	<p class="explain"><?php esc_html_e('If this business has multiple locations, but you want them all to appear in one business listing, add the other locations here.  If you want the other locations to have their own individual listing on the site, create a new business with this business as the parent.', 'cdash'); ?></p>
	<p><a href="#" class="docopy-location button"><?php esc_html_e('Add Another Location', 'cdash'); ?></a></p>

	<fieldset>
		<legend><?php esc_html_e('Social Media Links', 'cdash'); ?></legend>

		<a href="#" class="dodelete-social button"><?php esc_html_e('Remove All Social Media Links', 'cdash'); ?></a>

		<?php while($mb->have_fields_and_multi('social')): ?>
		<?php $mb->the_group_open(); ?>
		<div class="half">
			<?php $mb->the_field('socialservice'); ?>
			<label><?php esc_html_e('Social Media Service', 'cdash'); ?></label>
			<?php $selected = ' selected="selected"'; ?>
			<select name="<?php sanitize_text_field($mb->the_name()); ?>">
				<option value=""></option>
				<?php $mb->the_field('socialservice'); ?>
				<option value="avvo" <?php if ($mb->get_the_value() == 'avvo') echo $selected; ?>><?php esc_html_e( 'Avvo', 'cdash' ); ?></option>
				<option value="facebook" <?php if ($mb->get_the_value() == 'facebook') echo $selected; ?>><?php esc_html_e( 'Facebook', 'cdash' ); ?></option>
				<option value="flickr" <?php if ($mb->get_the_value() == 'flickr') echo $selected; ?>><?php esc_html_e( 'Flickr', 'cdash' ); ?></option>
				<option value="google" <?php if ($mb->get_the_value() == 'google') echo $selected; ?>><?php esc_html_e( 'Google +', 'cdash' ); ?></option>
				<option value="instagram" <?php if ($mb->get_the_value() == 'instagram') echo $selected; ?>><?php esc_html_e( 'Instagram', 'cdash' ); ?></option>
				<option value="linkedin" <?php if ($mb->get_the_value() == 'linkedin') echo $selected; ?>><?php esc_html_e( 'LinkedIn', 'cdash' ); ?></option>
				<option value="pinterest" <?php if ($mb->get_the_value() == 'pinterest') echo $selected; ?>><?php esc_html_e( 'Pinterest', 'cdash' ); ?></option>
				<option value="tripadvisor" <?php if ($mb->get_the_value() == 'tripadvisor') echo $selected; ?>><?php esc_html_e( 'Trip Advisor', 'cdash' ); ?></option>
				<option value="tumblr" <?php if ($mb->get_the_value() == 'tumblr') echo $selected; ?>><?php esc_html_e( 'Tumblr', 'cdash' ); ?></option>
				<option value="twitter" <?php if ($mb->get_the_value() == 'twitter') echo $selected; ?>><?php esc_html_e( 'Twitter', 'cdash' ); ?></option>
				<option value="urbanspoon" <?php if ($mb->get_the_value() == 'urbanspoon') echo $selected; ?>><?php esc_html_e( 'Urbanspoon', 'cdash' ); ?></option>
				<option value="vimeo" <?php if ($mb->get_the_value() == 'vimeo') echo $selected; ?>><?php esc_html_e( 'Vimeo', 'cdash' ); ?></option>
				<option value="website" <?php if ($mb->get_the_value() == 'website') echo $selected; ?>><?php esc_html_e( 'Website', 'cdash' ); ?></option>
				<option value="youtube" <?php if ($mb->get_the_value() == 'youtube') echo $selected; ?>><?php esc_html_e( 'YouTube', 'cdash' ); ?></option>
				<option value="yelp" <?php if ($mb->get_the_value() == 'yelp') echo $selected; ?>><?php esc_html_e( 'Yelp', 'cdash' ); ?></option>
			</select>
		</div>
		<div class="half">
			<?php $mb->the_field('socialurl'); ?>
			<label><?php esc_html_e('Social Media URL', 'cdash'); ?></label>
			<p><input placeholder="http://" type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>
		</div>

		<a href="#" class="dodelete button"><?php esc_html_e('Remove This Social Media Link', 'cdash'); ?></a>
		<hr />

		<?php $mb->the_group_close(); ?>
		<?php endwhile; ?>
		<p><a href="#" class="docopy-social button"><?php _e('Add Another Social Media Link', 'cdash'); ?></a></p>
	</fieldset>
</div>
