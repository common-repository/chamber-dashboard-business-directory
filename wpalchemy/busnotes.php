<div class="my_meta_control">

	<p class="explain"><?php esc_html_e('These notes are for your internal use, and will never be displayed on the website.', 'cdash'); ?></p>

	<a href="#" class="dodelete-note button"><?php esc_html_e('Remove All Notes', 'cdash'); ?></a>

	<?php while($mb->have_fields_and_multi('note')): ?>
	<?php $mb->the_group_open(); ?>
		<div class="note">

			<?php $mb->the_field('date'); ?>
			<label><?php esc_html_e('Date', 'cdash'); ?></label>
			<p><input type="text" name="<?php sanitize_text_field($mb->the_name()); ?>" value="<?php sanitize_text_field($mb->the_value()); ?>"/></p>

			<label><?php esc_html_e('Note', 'cdash'); ?></label>
			<p>
				<?php $metabox->the_field('notetext'); ?>
				<textarea name="<?php sanitize_text_field($metabox->the_name()); ?>" rows="5"><?php sanitize_text_field($metabox->the_value()); ?></textarea>
			</p>
 		</div>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-note button"><?php esc_html_e('Add Another Note', 'cdash'); ?></a></p>

</div>
