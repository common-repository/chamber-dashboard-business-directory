<div class="my_meta_control clearfix">

	<label><?php esc_html_e('Billing Address', 'cdash'); ?></label>
	<p>
		<?php $metabox->the_field('billing_address'); ?>
		<textarea name="<?php sanitize_text_field($metabox->the_name()); ?>" rows="3" id="billing-address"><?php sanitize_textarea_field($metabox->the_value()); ?></textarea>
	</p>

	<div class="fourth">
		<?php $mb->the_field('billing_city'); ?>
		<label><?php esc_html_e('City', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-city" /></p>
	</div>

	<div class="fourth">
		<?php $mb->the_field('billing_state'); ?>
		<label><?php esc_html_e('State', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-state" /></p>
	</div>

	<div class="fourth">
		<?php $mb->the_field('billing_zip'); ?>
		<label><?php esc_html_e('Zip', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-zip" /></p>
	</div>

	<div class="fourth">
		<?php $mb->the_field('billing_country'); ?>
		<label><?php esc_html_e('Country', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-country" /></p>
	</div>

	<div class="half">
		<?php $mb->the_field('billing_email'); ?>
		<label><?php esc_html_e('Billing Email', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-email" /><br />
		<span class="explain"><?php esc_html_e( 'Separate multiple email addresses with commas', 'cdash' ); ?></span></p>
	</div>

	<div class="half">
		<?php $mb->the_field('billing_phone'); ?>
		<label><?php esc_html_e('Billing Phone', 'cdash'); ?></label>
		<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>" id="billing-phone" /></p>
	</div>

</div>
