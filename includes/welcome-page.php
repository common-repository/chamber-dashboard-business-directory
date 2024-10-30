<?php
function cdash_admin_menus() {
	$welcome_page_title = esc_html__('Welcome to Chamber Dashboard Business Directory', 'cdash');
	// About
	$about = add_dashboard_page($welcome_page_title, $welcome_page_title, 'manage_options', 'cdash-about', 'cdash_about_screen');
}
add_action('admin_menu', 'cdash_admin_menus');

// remove dashboard page links.
function cdash_admin_head() {
	remove_submenu_page( 'index.php', 'cdash-about' );
}
add_action('admin_head', 'cdash_admin_head');


// Display the welcome page
function cdash_about_screen()
	{
		?>
		<div class="wrap">
		<?php
			cdash_welcome_page();
		?>
		</div>
		<!--</div>-->
		<?php
	}

	function cdash_welcome_page(){
	?>
		<!--<div class="wrap">-->
			<h1><?php esc_html_e('Welcome to Chamber Dashboard Business Directory', 'cdash'); ?></h1>
			<?php //cdash_email_subscribe();
			cdash_getting_started_blocks();
			?>
			<div class="cdash-about-text">
				<h2>
				<?php
					esc_html_e('Power your membership organization with WordPress plugins and themes', 'cdash');
				?>
				</h2>
			</div>
			<div id="main" class="cd_settings_tab_group" style="width: 100%; float: left;">
				<div class="cdash_section_content">
					<?php
					cdash_show_demo_buttons();
					cdash_about_page_render();
		          ?>
				</div>
            </div><!--end of #main-->
	<?php
	}


//Displaying the Support Page
function cdash_support_page_render(){
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
            $section = "support";
        }
        ?>
        <h1><?php esc_html_e('Chamber Dashboard Support', 'cdash'); ?></h1>
		<div id="main" class="cd_settings_tab_group" style="width: 100%; float: left;">
            <div class=" cdash section_group">
                <ul>
                    <li class="<?php echo $section == 'support' ? 'section_active' : ''; ?>">
                        <a href="?page=cd-settings&tab=support&section=support" class="<?php echo $section == 'support' ? 'section_active' : ''; ?>"><?php esc_html_e( 'Contact Support', 'cdash' ); ?></a><span>|</span>
                    </li>
                    <li class="<?php echo $section == 'tech_details' ? 'section_active' : ''; ?>">
                        <a href="?page=cd-settings&tab=support&section=tech_details" class="<?php echo $section == 'tech_details' ? 'section_active' : ''; ?>"><?php esc_html_e( 'Technical Details', 'cdash' ); ?></a>
                    </li>
                </ul>
            </div>
            <div class="cdash_section_content support">
                <?php
                if( $section == 'support' ){
                    cdash_support_page();
                }else if($section == 'tech_details'){
                    chamber_dashboard_technical_details_page_render();
                }
              ?>
            </div>
        </div>

    </div>
<?php
}

// Redirect to welcome page after activation
function cdash_welcome()
{

	// Bail if no activation redirect transient is set
    if (!get_transient('_cdash_activation_redirect'))
		return;

	// Delete the redirect transient
	delete_transient('_cdash_activation_redirect');

	// Bail if activating from network, or bulk, or within an iFrame
	if (is_network_admin() || isset($_GET['activate-multi']) || defined('IFRAME_REQUEST'))
		return;

	if ((isset($_GET['action']) && 'upgrade-plugin' == $_GET['action']) && (isset($_GET['plugin']) && strstr($_GET['plugin'], 'cdash-business-directory.php')))
		return;

	//wp_safe_redirect(admin_url(add_query_arg( array( 'page' => 'cdash-about', 'tab' => 'cdash-about'), 'admin.php')));

	wp_safe_redirect(admin_url(add_query_arg( array( 'page' => 'cd-welcome'), 'admin.php')));
	exit;
}
add_action('admin_init', 'cdash_welcome');

function cdash_support_page(){
	?>
	<div class="cd_support_page">
		<h4><?php esc_html_e('You can contact us through the WordPress plugin support - '); ?> <a href="https://wordpress.org/support/plugin/chamber-dashboard-business-directory/" target="_blank">https://wordpress.org/support/plugin/chamber-dashboard-business-directory/</a>  </h4>
	</div>
	<?php
}

//Displaying the Technical Details
function chamber_dashboard_technical_details_page_render(){
?>
    <div class="wrap">
		<div class="cdash_technical_details">
			<div class="cdash_sub_section">
				<?php $site_name = get_bloginfo('name'); ?>
				<h3><?php esc_html_e($site_name . ' Status', 'cdash'); ?></h3>
				<?php
					global $wp_version;
					$php_version = phpversion();
				?>
		  <h4>Current WP Version:</b> <?php echo $wp_version; ?></h4>
					<h4>Current PHP Version:</b> <?php echo $php_version;  ?></h4>
			</div>

			<div class="cdash_sub_section">
				<?php
				$theme = wp_get_theme();
					?>
					<br />
					<h3>Active Theme</h3>
					<?php
					echo $theme . " " . $theme->get( 'Version' );
					?>
			</div>

			<div class="cdash_sub_section">
				<h3>Chamber Dashboard Plugins</h3>
				<h4>Business Directory Version: <?php echo CDASH_BUS_VER; ?></h4>

				<?php
				$plugins = cdash_get_active_plugin_list();
				cdash_technical_details_hook();
				?>
			</div>

			<div class="cdash_sub_section">
				<h3>Other Details</h3>

				<?php
				global $woocommerce;
				if ( defined( 'WOOCOMMERCE_VERSION' )){
					echo 'Woocommerce Version: ' .  WOOCOMMERCE_VERSION;
				}
				?>
			</div>
		</div><!--end of cdash_technical_details-->
  </div>
<?php
}

function cdash_display_plugin_version($plugin_name){
	$plugins = cdash_get_active_plugin_list();
	if($plugin_name == 'cdash_member_manager'){
		if( in_array( 'cdash-member-manager.php', $plugins ) ) {
			echo "<h4>Member Manager Version: " . CDASHMM_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_member_manager_pro'){
		if( in_array( 'cdash-member-manager-pro.php', $plugins ) ) {
			echo "<h4>Member Manager Pro Version: " . CDASHMM_PRO_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_crm'){
		if( in_array( 'cdash-crm.php', $plugins ) ) {
			echo "<h4>CRM Version: " . CDASHMM_CRM_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_crm_importer'){
		if( in_array( 'cdash-crm-importer.php', $plugins ) ) {
			echo "<h4>CRM Importer Version: " . CDCRM_IMPORT_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_exporter'){
		if( in_array( 'cdash-exporter.php', $plugins ) ) {
			echo "<h4>Chamber Dashboard Exporter Version: " . CDEXPORT_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_member_updater'){
		if( in_array( 'cdash-member-updater.php', $plugins ) ) {
			echo "<h4>Member Updater Version: " . CDASHMU_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_recurring_payments'){
		if( in_array( 'cdash-recurring-payments.php', $plugins ) ) {
			echo "<h4>Recurring Payments Version: " . CDASHRP_VERSION . "</h4>";
		}
	}
	if($plugin_name == 'cdash_events_calendar'){
		if( in_array( 'cdash-event-calendar.php', $plugins ) ) {
			echo "<h4>Events Calendar Version: " . CDASH_EVENTS_UPDATE_VERSION_1 . "</h4>";
		}
	}
}

//Creating the custom hook for displaying license form
function cdash_technical_details_hook(){
  do_action('cdash_technical_details_hook');
}
?>
