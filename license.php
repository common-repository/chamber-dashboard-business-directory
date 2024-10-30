<?php
/* License Page for Chamber Dashboard Business Directory */

if ( ! defined( 'ABSPATH' ) ) exit;

//Creating the custom hook for displaying license form
function cdash_licence_page_hook(){
  do_action('cdash_licence_page_hook');
}

function cdash_get_active_plugin_list() {
    $active_plugins = wp_get_active_and_valid_plugins();
    $plugin_names = array();
    foreach( $active_plugins as $plugin ) {
        $plugin_names[] = substr($plugin, strrpos($plugin, '/') + 1);
    }

    return $plugin_names;
}

function chamber_dashboard_licenses_page_render(){
?>
    <div class="wrap">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2><?php _e('Chamber Dashboard Licenses'); ?></h2>
        <?php settings_errors(); ?>
        <table>
          <tr>
            <td>
              <?php
                cdash_licence_page_hook();
              ?>
            </td>
          </tr>
        </table>

        <!--<div id="main" style="min-width: 350px; float: left;">-->
            <?php
            //$plugins = cdash_get_active_plugin_list();
                /*if( in_array( 'cdash-recurring-payments.php', $plugins ) ) {
                  if ( version_compare(CDASHRP_VERSION, "1.5.3", "<" ) ) {
                    cdashrp_edd_license_page();
                  }

                }
                if( in_array( 'cdash-member-updater.php', $plugins ) ) {
                    if ( version_compare(CDASHMU_VERSION, "1.3.3", "<" ) ) {
                      cdash_mu_edd_license_page();
                    }
                }
                if( in_array( 'cdash-exporter.php', $plugins ) ) {
                  if ( version_compare(CDEXPORT_VERSION, "1.2", "<" ) ) {
                    cdexport_edd_license_page();
                  }
                }
                if( in_array( 'cdash-crm-importer.php', $plugins ) ) {
                  if ( version_compare(CDCRM_IMPORT_VERSION, "1.1", "<" ) ) {
                    cdcrm_import_edd_license_page();
                  }
                }*/

              //}

            ?>
        <!--</div>-->
    </div>
<?php
}
?>
