<?php
/*All the pages that are required for the Business Directory */

// Require views
//require_once( plugin_dir_path( __FILE__ ) . 'views.php' );
// Require widgets
require_once( plugin_dir_path( __FILE__ ) . 'widgets.php' );
// Require Addons
require_once( plugin_dir_path( __FILE__ ) . 'addons.php' );
// Require licenses page
require_once( plugin_dir_path( __FILE__ ) . 'license.php' );
// Require Getting started page
require_once( plugin_dir_path( __FILE__ ) . 'getting_started.php' );

foreach ( glob( plugin_dir_path( __FILE__ ) . "includes/*.php" ) as $file ) {
    require_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . "shortcodes/*.php" ) as $file ) {
    require_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . "post_types/*.php" ) as $file ) {
    require_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . "views/*.php" ) as $file ) {
    require_once $file;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . "blocks/*.php" ) as $file ) {
    require_once $file;
}
?>
