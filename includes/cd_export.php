<?php
function cdash_export_form() {

	$export_form =
		'<p>' . __( 'Click the button below to download a CSV file of all of your businesses.', 'cdash' ) . '</p>
		<form method="post" action="' . admin_url( 'admin.php?cd-settings&tab=import_export&section=export') . '">
		<input type="hidden" name="cdash_export" value="cdash_do_export">
		<input type="submit" class="button-primary" value="' . __( 'Download CSV', 'cdash' ) . '">
		</form>
		<p>' . __( 'This free export feature can only export limited information about businesses.', 'cdash' );

	$export_form = apply_filters( 'cdash_export_form', $export_form );

	$export_page =
		'<h2>' . __( 'Export', 'cdash' ) . '</h2>' .
			'<span class="desc"></span>
			<div class="content">' . $export_form . '</div>';

	echo $export_page;
}
?>
