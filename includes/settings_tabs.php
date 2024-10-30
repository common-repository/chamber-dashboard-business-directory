<?php
add_action( 'cdash_settings_tab', 'cdash_directory_tab', 5 );

function cdash_directory_tab(){
	global $cdash_active_tab; ?>
	<a class="nav-tab <?php echo $cdash_active_tab == 'directory' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=cd-settings&tab=directory' ); ?>"><?php _e( 'Directory', 'cdash' ); ?> </a>
	<?php
}

add_action( 'cdash_settings_tab', 'cdash_import_export_tab', 10 );
function cdash_import_export_tab(){
	global $cdash_active_tab; ?>
	<a class="nav-tab <?php echo $cdash_active_tab == 'import_export' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=cd-settings&tab=import_export' ); ?>"><?php _e( 'Import/Export', 'cdash' ); ?> </a>
	<?php
}

add_action( 'cdash_settings_tab', 'cdash_support_tab', 100 );
function cdash_support_tab(){
	global $cdash_active_tab; ?>
	<a class="nav-tab <?php echo $cdash_active_tab == 'support' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'admin.php?page=cd-settings&tab=support' ); ?>"><?php _e( 'Support', 'cdash' ); ?> </a>
	<?php
}

add_action( 'cdash_settings_content', 'cdash_settings_all' );
function cdash_settings_all(){
    global $cdash_active_tab;

    switch($cdash_active_tab){
        case 'directory':
        cdash_directory_settings();
        break;

        case 'import_export':
        //cdash_export_form();
		cd_import_export();
        break;

		case 'support':
		cdash_support_page_render();
		break;
    }
}

?>
