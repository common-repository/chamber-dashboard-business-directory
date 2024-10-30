<?php
/* Addons Page for Chamber Dashboard Business Directory */

if ( ! defined( 'ABSPATH' ) ) exit;

function display_addons($title, $slug, $description, $link, $price, $type){
    $url = admin_url();
?>
    <li class="single_addon <?php echo $type; ?>">
        <img src="<?php echo plugins_url( 'images/' . $slug . '.png' , __FILE__ ); ?>" />
        <h3><?php echo $title; ?></h3>
        <h4><?php echo $price; ?></h4>
        <p><?php echo $description; ?></p>
        <?php
            if($price == 'Free' && $type == 'plugin'){
            ?>
                <a href="<?php echo $url.$link; ?>" class=" button-primary thickbox fs-overlay" aria-label="More information about <?php echo $title; ?>" data-title="<?php echo $title; ?>">Get this Free Addon</a>
            <?php
            }elseif($price != 'Free' && $type == 'plugin'){
            ?>
                <a href="<?php echo $link; ?>" class=" button-primary" target="_blank">Purchase this Addon</a>
            <?php
            }elseif($price != 'Free' && $type == 'theme'){
			?>
				<a href="<?php echo $link; ?>" class=" button-primary" target="_blank">Purchase this Theme</a>
			<?php
			}
        ?>
    </li>
<?php
}

function chamber_dashboard_addons_page_render(){
?>
    <div class="wrap" style="width:90%;">
        <div class="icon32" id="icon-options-general"><br></div>
        <h2><?php esc_attr_e('Chamber Dashboard Addons'); ?></h2>
        <?php settings_errors(); ?>

        <!--<div id="main">-->
            <div id="addons_list">
                <ul>
                    <?php
                        display_addons(
                          'Chamber Dashboard Member Manager',
                          'member_manager',
                          'Let Members join your organization right on your website!',
                          'plugin-install.php?tab=plugin-information&amp;parent_plugin_id=170&amp;plugin=chamber-dashboard-member-manager&amp;TB_iframe=true&amp;width=772&amp;height=700',
                          'Free',
  					              'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard Payment Options',
                          'member_manager_pro',
                          'Gives you some additional payment settings',
                          'https://chamberdashboard.com/downloads/payment-options/',
                          '$49.00',
  					      'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard WC Payments',
                          'member_manager_pro',
                          'Gives you the option to connect to alternative payment gateways',
                          'https://chamberdashboard.com/downloads/wc-payments/',
                          '$49.00',
                          'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard CRM',
                          'crm',
                          'Keep track of contacts connected to member businesses in your organization.',
                          'plugin-install.php?tab=plugin-information&amp;parent_plugin_id=170&amp;plugin=chamber-dashboard-crm&amp;TB_iframe=true&amp;width=772&amp;height=700',
                          'Free',
  					              'plugin'
                        );

            						display_addons(
                          'Chamber Dashboard Events Calendar',
                          'events_calendar',
                          'Display upcoming events calendar on your website.',
                          'plugin-install.php?tab=plugin-information&amp;parent_plugin_id=170&amp;plugin=chamber-dashboard-events-calendar&amp;TB_iframe=true&amp;width=772&amp;height=700',
                          'Free',
  					              'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard Recurring Payments',
                          'recurring_payments',
                          'Offer your members recurring payments and genereate invoices automatically.',
                          'https://chamberdashboard.com/downloads/recurring-payments/',
                          '$79.00',
  					              'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard Member Updater',
                          'member_updater',
                          'Let Members update their listings by logging in from the front end.',
                          'https://chamberdashboard.com/downloads/member-updater/',
                          '$79.00',
  					              'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard Mailchimp Addon',
                          'mailchimp',
                          'Add your members to your mailchimp list automatically',
                          'https://chamberdashboard.com/downloads/cd-mailchimp-addon/',
                          '$29.00',
  					              'plugin'
                        );

                        display_addons(
                          'Chamber Dashboard Exporter',
                          'exporter',
                          'Export member businesses, contacts, paid or unpaid invoices.',
                          'https://chamberdashboard.com/downloads/chamber-dashboard-exporter/',
                          '$39.00',
  					              'plugin'
                        );

                        display_addons(
                          'CRM Importer',
                          'crm_importer',
                          'Import hundreds of contacts. Save hours of data entry.',
                          'https://chamberdashboard.com/downloads/crm-importer/',
                          '$29.00',
  					              'plugin'
                        );

          						  display_addons(
                          'Chamber Beautiful Theme',
                          'chamber_beautiful',
                          '<b>Chamber Beautiful Theme</b> - Integrates well with the Chamber Dashboard plugins.',
                          'https://chamberdashboard.com/downloads/chamber-beautiful/',
                          '$59.00',
            							'theme'
                        );

                        display_addons(
                          'Chamber Inspired Theme',
                          'chamber_inspired',
                          '<b>Chamber Inspired Theme</b> - Integrates well with the Chamber Dashboard plugins.',
                          'https://chamberdashboard.com/downloads/chamber-inspired/',
                          '$59.00',
                         'theme'
                        );
                    ?>
                </ul>
            </div><!-- end of addons_list-->
        <!--</div>--><!-- end of main-->
    </div><!--end of wrap-->
<?php
}

?>
