<?php

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------
// THIS FUNCTION IS SPECIFIED IN add_options_page() AS THE CALLBACK FUNCTION THAT
// ACTUALLY RENDER THE PLUGIN OPTIONS FORM AS A SUB-MENU UNDER THE EXISTING
// SETTINGS ADMIN MENU.
// ------------------------------------------------------------------------------

//Render the New Plugin Options Page

function cdash_directory_settings(){
    ?>
	<div class="wrap">

        <?php
        $page = sanitize_text_field($_GET['page']);
        if(isset($_GET['tab'])){
            $tab = sanitize_text_field($_GET['tab']);
        }
        if(isset($_GET['section'])){
            $section = sanitize_text_field($_GET['section']);
        }else{
            $section = "bus_directory";
        }
        ?>

		<!-- Display Plugin Icon, Header, and Description -->
		<h1><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . '/images/cdash-32.png'?>"><?php _e('Chamber Dashboard Business Directory', 'cdash'); ?></h1>

        <div id="main" class="cd_settings_tab_group" style="width: 100%; float: left;">
            <div class="cdash section_group">
                <ul>
                    <li class="<?php echo $section == 'bus_directory' ? 'section_active' : ''; ?>">
                        <a href="?page=cd-settings&tab=directory&section=bus_directory" class="<?php echo $section == 'bus_directory' ? 'section_active' : ''; ?>"><?php esc_html_e( 'Business Directory Settings', 'cdash' ); ?></a><span>|</span>
                    </li>
                    <li class="<?php echo $section == 'cd_bus_docs' ? 'section_active' : ''; ?>">
                        <a href="?page=cd-settings&tab=directory&section=cd_bus_docs" class="<?php echo $section == 'cd_bus_docs' ? 'section_active' : ''; ?>"><?php esc_html_e( 'Shortcodes', 'cdash' ); ?></a>
                    </li>
                </ul>
            </div>
            <div class="cdash_section_content">
                <?php
                if( $section == 'bus_directory' )
                {
                    cdash_bus_directory_settings();
                }else if($section == 'cd_bus_docs'){
                    cdash_settings_sidebar();
                }
              ?>
            </div>
        </div><!--end of #main-->
	</div><!--end of wrap-->
	<?php
}

function cdash_bus_directory_settings(){
    wp_enqueue_script( 'jquery-ui-accordion' );
    ?>
    <div id="bus_directory_settings" class="cdash_plugin_settings">
        <form method="post" action="options.php">
  				<?php settings_fields('cdash_plugin_options');
                ?>
                <div class="settings_sections">
                <?php
                do_settings_sections('cdash_plugin_options');
                ?>
                </div>
                <?php
                //do_accordion_sections('cdash_plugin_options');
                submit_button();
          ?>
  				<?php $options = get_option('cdash_directory_options'); ?>

  		</form>
        <script type="text/javascript">
        // Add a new repeating section
        var attrs = ['for', 'id', 'name'];
        function resetAttributeNames(section, idx) {
            //var tags = section.find('input, label, select'), idx = section.index();
      var tags = section.find('input, label, select');
      //alert("Section Index idx: " + idx);
            tags.each(function() {
              var $this = jQuery(this);
              jQuery.each(attrs, function(i, attr) {
                var attr_val = $this.attr(attr);
                if (attr_val) {
                    $this.attr(attr, attr_val.replace(/\[bus_custom\]\[\d+\]\[/, '\[bus_custom\]\['+(idx + 1)+'\]\['));
                }
              })
            })
        }

        jQuery('.repeat').click(function(e){
                e.preventDefault();
                var lastRepeatingGroup = jQuery('.repeating').last();
          var idx = jQuery('.repeating').length;

          //Saving the value of the radio buttons from the last repeating section
          var displayDirName = "cdash_directory_options[bus_custom]["+idx+"][display_dir]";
          var display_dir = jQuery("input[name='"+displayDirName+"']:checked").val();

          var displaySingleName = "cdash_directory_options[bus_custom]["+idx+"][display_single]";
          var display_single = jQuery("input[name='"+displaySingleName+"']:checked").val();

          //Clone the lastRepeatingGroup
          var cloned = lastRepeatingGroup.clone(true);

                cloned.insertAfter(lastRepeatingGroup);

          //Clearing out the values in the newly cloned section
                cloned.find("input[type=text]").val("");
                cloned.find("select").val("");
          cloned.find('input[type=radio]').removeAttr('checked');
                resetAttributeNames(cloned, idx);

          //Resetting the values of the radio buttons in the previous section
          jQuery("input[name='"+displayDirName+"']").filter("[value="+display_dir+"]").attr("checked", true);
          jQuery("input[name='"+displaySingleName+"']").filter("[value="+display_single+"]").attr("checked", true);
            });

        jQuery('.delete-this').click(function(e){
            e.preventDefault();
            jQuery(this).parent('div').remove();
        });

        </script>
    </div>
    <?php
}

?>
