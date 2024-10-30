<?php
function cd_import_export(){
    ?>
    <div class="wrap">
        <?php
        $page = sanitize_text_field($_GET['page']);
        if(isset($_GET['tab'])){
            $tab = sanitize_text_field($_GET['tab']);
        }

        ?>

        <!-- Display Plugin Icon, Header, and Description -->
		<h1><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . '/images/cdash-32.png'?>"><?php _e('Chamber Dashboard Import/Export', 'cdash'); ?></h1>

        <div id="main" class="cd_settings_tab_group" style="width: 100%; float: left;">
            <div class="cdash_section_content cd_settings">
                <div class="settings_sections">
                    <?php cdash_export_form(); ?>
                    <?php cdash_import_form(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
