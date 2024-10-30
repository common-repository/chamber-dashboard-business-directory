<div class="my_meta_control">

<?php $options = get_option('cdash_directory_options');
$customfields = $options['bus_custom'];
if(isset($customfields) && is_array($customfields) && array_filter($customfields) != [] ){
	foreach($customfields as $field) {
		if($field['type'] == "text") {
			$mb->the_field($field['name']); ?>
			<label><?php echo $field['name']; ?></label>
			<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>

		<?php } elseif ($field['type'] == "textarea") { ?>
			<label><?php echo $field['name']; ?></label>
			<p>
				<?php $metabox->the_field($field['name']); ?>
				<textarea name="<?php sanitize_text_field($metabox->the_name()); ?>" rows="5"><?php sanitize_textarea_field($metabox->the_value()); ?></textarea>
			</p>

		<?php } else {
			esc_html_e('<p>The field ' . $field['name'] . ' does not have an assigned field type.  Please go to the <a href="' . home_url() . '/wp-admin/admin.php?page=chamber-dashboard-business-directory/options.php">Chamber Dashboard settings page</a> and give this field a type so you can use it.</p>', 'cdash');
		}

	}
}else{
	?>
	<p><?php echo esc_html_e('There are no custom fields. You can add custom fields on the <a href="' . home_url() . '/wp-admin/admin.php?page=chamber-dashboard-business-directory/options.php">Business Directory settings page.</a>'); ?></p>
	<?php
}
 ?>

</div>
