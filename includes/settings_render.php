<?php
function cdash_bus_email_type_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="57" name="cdash_directory_options[bus_email_type]" value="<?php echo $options['bus_email_type']; ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
<?php
}

function cdash_default_thumb_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input id="cdash_default_thumb" type="text" name="cdash_directory_options[cdash_default_thumb]" value="<?php if(isset($options['cdash_default_thumb'])){ echo $options['cdash_default_thumb']; } ?>" />

  <input id="cdash_default_thumb_button" type="button" class="button-primary" value="Upload Image" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_description_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_description]" type="checkbox" value="1" <?php if (isset($options['sv_description'])) { checked('1', $options['sv_description']); } ?> />
  <?php
}

function cdash_sv_name_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_name]" type="checkbox" value="1" <?php if (isset($options['sv_name'])) { checked('1', $options['sv_name']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_address_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_address]" type="checkbox" value="1" <?php if (isset($options['sv_address'])) { checked('1', $options['sv_address']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_hours_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_hours]" type="checkbox" value="1" <?php if (isset($options['sv_hours'])) { checked('1', $options['sv_hours']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_map_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_map]" type="checkbox" value="1" <?php if (isset($options['sv_map'])) { checked('1', $options['sv_map']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_url_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_url]" type="checkbox" value="1" <?php if (isset($options['sv_url'])) { checked('1', $options['sv_url']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_phone_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_phone]" type="checkbox" value="1" <?php if (isset($options['sv_phone'])) { checked('1', $options['sv_phone']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_email_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_email]" type="checkbox" value="1" <?php if (isset($options['sv_email'])) { checked('1', $options['sv_email']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_logo_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_logo]" type="checkbox" value="1" <?php if (isset($options['sv_logo'])) { checked('1', $options['sv_logo']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_thumb_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_thumb]" type="checkbox" value="1" <?php if (isset($options['sv_thumb'])) { checked('1', $options['sv_thumb']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_memberlevel_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_memberlevel]" type="checkbox" value="1" <?php if (isset($options['sv_memberlevel'])) { checked('1', $options['sv_memberlevel']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}


function cdash_sv_category_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_category]" type="checkbox" value="1" <?php if (isset($options['sv_category'])) { checked('1', $options['sv_category']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_tags_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_tags]" type="checkbox" value="1" <?php if (isset($options['sv_tags'])) { checked('1', $options['sv_tags']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_social_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_social]" type="checkbox" value="1" <?php if (isset($options['sv_social'])) { checked('1', $options['sv_social']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sv_comments_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sv_comments]" type="checkbox" value="1" <?php if (isset($options['sv_comments'])) { checked('1', $options['sv_comments']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_name_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_name]" type="checkbox" value="1" <?php if (isset($options['tax_name'])) { checked('1', $options['tax_name']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_address_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_address]" type="checkbox" value="1" <?php if (isset($options['tax_address'])) { checked('1', $options['tax_address']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_hours_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_hours]" type="checkbox" value="1" <?php if (isset($options['tax_hours'])) { checked('1', $options['tax_hours']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_url_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_url]" type="checkbox" value="1" <?php if (isset($options['tax_url'])) { checked('1', $options['tax_url']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_phone_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_phone]" type="checkbox" value="1" <?php if (isset($options['tax_phone'])) { checked('1', $options['tax_phone']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_email_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_email]" type="checkbox" value="1" <?php if (isset($options['tax_email'])) { checked('1', $options['tax_email']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}


function cdash_tax_logo_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_logo]" type="checkbox" value="1" <?php if (isset($options['tax_logo'])) { checked('1', $options['tax_logo']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_thumb_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_thumb]" type="checkbox" value="1" <?php if (isset($options['tax_thumb'])) { checked('1', $options['tax_thumb']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_memberlevel_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_memberlevel]" type="checkbox" value="1" <?php if (isset($options['tax_memberlevel'])) { checked('1', $options['tax_memberlevel']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_category_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_category]" type="checkbox" value="1" <?php if (isset($options['tax_category'])) { checked('1', $options['tax_category']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_tags_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_tags]" type="checkbox" value="1" <?php if (isset($options['tax_tags'])) { checked('1', $options['tax_tags']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_social_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_social]" type="checkbox" value="1" <?php if (isset($options['tax_social'])) { checked('1', $options['tax_social']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_tax_orderby_name_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[tax_orderby_name]" type="checkbox" value="1"<?php if (isset($options['tax_orderby_name'])) { checked('1', $options['tax_orderby_name']); } ?> />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_sm_display_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[sm_display]" type="radio" value="text" <?php checked('text', $options['sm_display']); ?> /> <?php _e( 'Text links ', 'cdash' ); ?><?php _e( '(Display social media as text links)', 'cdash' ); ?><br /><br />

  <input name="cdash_directory_options[sm_display]" type="radio" value="icons" <?php checked('icons', $options['sm_display']); ?> /> <?php _e( 'Icons ', 'cdash' ); ?><?php _e( '(Display social media links as icons)', 'cdash' ); ?>
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <label><?php _e('Icon Size: ', 'cdash'); ?></label>
  <select name='cdash_directory_options[sm_icon_size]'>
  <option value='16px' <?php selected('16px', $options['sm_icon_size']); ?>>16px</option>
  <option value='32px' <?php selected('32px', $options['sm_icon_size']); ?>>32px</option>
  <option value='64px' <?php selected('64px', $options['sm_icon_size']); ?>>64px</option>
  <option value='128px' <?php selected('128px', $options['sm_icon_size']); ?>>128px</option>
</select>
<br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_currency_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <select name='cdash_directory_options[currency]'>
  <?php global $currencies;
  foreach($currencies['codes'] as $code => $currency)
  {
    echo '<option value="'.esc_attr($code).'"'.selected($options['currency'], $code, false).'>'.esc_html($currency).'</option>';
  } ?>
</select>
<br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_currency_symbol_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[currency_symbol]" value="<?php if(isset($options['currency_symbol'])) { echo $options['currency_symbol']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_currency_position_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input name="cdash_directory_options[currency_position]" type="radio" value="before" <?php checked('before', $options['currency_position']); ?> /><?php _e( ' Before the price', 'cdash' ); ?><br />
  <input name="cdash_directory_options[currency_position]" type="radio" value="after" <?php checked('after', $options['currency_position']); ?> /><?php _e( ' After the price', 'cdash' ); ?>
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_search_results_per_page_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[search_results_per_page]" value="<?php if(isset($options['search_results_per_page'])) { echo $options['search_results_per_page']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_business_listings_url_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[business_listings_url]" value="<?php if(isset($options['business_listings_url'])) { echo $options['business_listings_url']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_business_listings_url_text_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[business_listings_url_text]" value="<?php if(isset($options['business_listings_url_text'])) { echo $options['business_listings_url_text']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_google_maps_api_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[google_maps_api]" value="<?php if(isset($options['google_maps_api'])) { echo $options['google_maps_api']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_google_maps_server_api_render($args){
  $options = get_option('cdash_directory_options');
  ?>
  <input type="text" size="35" name="cdash_directory_options[google_maps_server_api]" value="<?php if(isset($options['google_maps_server_api'])) { echo $options['google_maps_server_api']; } ?>" />
  <br /><span class="description"><?php echo $args[0]; ?></span>
  <?php
}

function cdash_custom_fields_render($args){
  $options = get_option('cdash_directory_options');
  if(isset($options['bus_custom']) && is_array($options['bus_custom']) && array_filter($options['bus_custom']) != [] ) {
    $field_set = true;
  	$customfields = $options['bus_custom'];
  	$i = 1;
  	foreach($customfields as $field) {
       ?>
  		<div class="repeating" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
  			<?php
        cdash_custom_fields_name($field_set, $options, $i);
        cdash_custom_fields_type($field_set, $options, $i);
        cdash_custom_fields_display_dir($field_set, $options, $i);
        cdash_custom_fields_display_single($field_set, $options, $i);
        ?>
        <br />
        <a href="#" class="delete-this"><?php _e('Delete This Custom Field', 'cdash'); ?></a>
  		</div>
      <?php $i++;
  	}
  } else {
    ?>
  	<div class="repeating" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
  		<?php cdash_custom_fields_name(false, $options, '');
            cdash_custom_fields_type(false, $options, '');
            cdash_custom_fields_display_dir(false, $options, '');
            cdash_custom_fields_display_single(false, $options, '');
       ?>
       <br />
  		<a href="#" class="delete-this"><?php _e('Delete This Custom Field', 'cdash'); ?></a>
  	</div>
  <?php } ?>
  <p><a href="#" class="repeat"><?php _e('Add Another Custom Field', 'cdash'); ?></a></p>
<?php
}



function cdash_options_section_callback(  ) {

	//echo __( 'Chamber Dashboard Business Directory Settings', 'cdash' );

}

function cdash_custom_fields_name($field_set, $options, $i){
  ?>
  <p><strong><?php _e('Custom Field Name', 'cdash'); ?></strong></p>
  <p><span style="color:#666666;margin-left:2px;"><?php _e('<strong>Note:</strong> If you change the name of an existing custom field, you will lose all data stored in that field!', 'cdash'); ?></span></p>
  <?php
  if($field_set){
  ?>
    <input type="text" size="30" name="cdash_directory_options[bus_custom][<?php echo $i; ?>][name]" value="<?php if(isset($options['bus_custom'])){ echo $options['bus_custom'][$i]['name']; } ?>" />
  <?php
  }else{
  ?>
    <input type="text" size="30" name="cdash_directory_options[bus_custom][1][name]" value="<?php if(isset($options['bus_custom'])){ echo $options['bus_custom'][1]['name']; } ?>" />
  <?php
  }
}

function cdash_custom_fields_name_new($i, $value){
  ?>
  <p><strong><?php _e('Custom Field Name', 'cdash'); ?></strong></p>
  <p><span style="color:#666666;margin-left:2px;"><?php _e('<strong>Note:</strong> If you change the name of an existing custom field, you will lose all data stored in that field!', 'cdash'); ?></span></p>
  <input type="text" size="30" name="cdash_directory_options[bus_custom][<?php echo $i; ?>][name]" value="<?php echo $value; ?>" />
  <?php
}

function cdash_custom_fields_type($field_set, $options, $i){
  if($field_set){
    ?>
    <p><strong><?php _e('Custom Field Type'); ?></strong></p>
      <select name='cdash_directory_options[bus_custom][<?php echo $i; ?>][type]'>
        <option value=''></option>
        <option value='text' <?php selected('text', $options['bus_custom'][$i]['type']); ?>><?php _e('Short Text Field', 'cdash'); ?></option>
        <option value='textarea' <?php selected('textarea', $options['bus_custom'][$i]['type']); ?>><?php _e('Multi-line Text Area', 'cdash'); ?></option>
      </select>
    <?php
  }else{
    ?>
    <p><strong><?php _e('Custom Field Type'); ?></strong></p>
      <select name='cdash_directory_options[bus_custom][1][type]'>
        <option value=''></option>
        <option value='text' <?php if(isset($options['bus_custom'][1]['type']) == "text" ){echo "selected='selected'";}  ?>><?php _e('Short Text Field', 'cdash'); ?></option>
        <option value='textarea' <?php if(isset($options['bus_custom'][1]['type']) == "textarea" ){echo "selected='selected'";} ?>><?php _e('Multi-line Text Area', 'cdash'); ?></option>
      </select>
    <?php
  }
}

function cdash_custom_fields_display_dir($field_set, $options, $i){
  if($field_set){
    ?>
    <p><strong><?php _e('Display in Business Directory?', 'cdash'); ?></strong></p>
    <?php $field['display_dir'] = "";
    if(isset($options['bus_custom'][$i]['display_dir'])){
      $display_dir = $options['bus_custom'][$i]['display_dir'];
    }else{
      $display_dir = '';
    }
    ?>
      <label><input name="cdash_directory_options[bus_custom][<?php echo $i; ?>][display_dir]" type="radio" value="yes" <?php checked('yes', $display_dir, true ); ?> /><?php _e('Yes', 'cdash'); ?></label><br />
      <label><input name="cdash_directory_options[bus_custom][<?php echo $i; ?>][display_dir]" type="radio" value="no" <?php checked('no', $display_dir, true); ?> /><?php _e('No', 'cdash'); ?></label><br />
    <?php
  }else{
    ?>
    <p><strong><?php _e('Display in Business Directory?', 'cdash'); ?></strong></p>
      <label><input name="cdash_directory_options[bus_custom][1][display_dir]" type="radio" value="yes" /> <?php _e('Yes', 'cdash'); ?></label><br />
      <label><input name="cdash_directory_options[bus_custom][1][display_dir]" type="radio" value="no" /><?php _e('No', 'cdash'); ?></label><br />
    <?php
  }
}

function cdash_custom_fields_display_single($field_set, $options, $i){
  if($field_set){
    if(isset($options['bus_custom'][$i]['display_single'])){
      $display_single = $options['bus_custom'][$i]['display_single'];
    }else{
      $display_single = '';
    }
    ?>
    <p><strong><?php _e('Display in Single Business View?', 'cdash'); ?></strong></p>
    <?php $field['display_single'] = ""; ?>
      <label><input name="cdash_directory_options[bus_custom][<?php echo $i; ?>][display_single]" type="radio" value="yes" <?php checked('yes', $display_single); ?> /><?php _e('Yes', 'cdash'); ?></label><br />
      <label><input name="cdash_directory_options[bus_custom][<?php echo $i; ?>][display_single]" type="radio" value="no" <?php checked('no', $display_single); ?> /><?php _e('No', 'cdash'); ?></label><br />
    <?php
  }else{
    ?>
    <p><strong><?php _e('Display in Single Business View?', 'cdash'); ?></strong></p>
      <label><input name="cdash_directory_options[bus_custom][1][display_single]" type="radio" value="yes" /><?php _e('Yes', 'cdash'); ?></label><br />
      <label><input name="cdash_directory_options[bus_custom][1][display_single]" type="radio" value="yes" /><?php _e('No', 'cdash'); ?></label><br />
    <?php
  }
}
