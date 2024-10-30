<?php
// sidebar for settings page

function cdash_settings_sidebar(){
?>

<div id="sidebar">
	<div class="cdash_top_blocks">
		<div class="cdash_block">
			<h3><?php echo __('Display Business Directory', 'cdash'); ?></h3>
			<p><span class="bold">[business_directory]</span> - <?php echo __('Displays the directory listings', 'cdash'); ?><br />
				<span class="bold"><?php echo __('Acepted Parameters:', 'cdash');?></span> Format, category, tags, level, text, display, single_link, perpage, orderby, order
			</p>
			<p><a target="_blank" href="https://chamberdashboard.com/docs/plugin-features/business-directory/display-directory-shortcode/"><?php echo __('Directory Shortcode Docs', 'cdash');?></a></p>
		</div>
		<div class="cdash_block">
			<h3><?php echo __('Display Business Categories', 'cdash');?></h3>
			<p><span class="bold">[business_categories]</span> - <?php echo __('Displays a list of business categories', 'cdash'); ?><br />
				<span class="bold"><?php echo __('Acepted Parameters:', 'cdash'); ?></span> Orderby, order, showcount, hierarchical, hide_empty, child_of, exclude, format
			</p>
			<p><a target="_blank" href="https://chamberdashboard.com/docs/plugin-features/business-directory/category-pages/"><?php echo __('Category Shortcode Docs', 'cdash'); ?></a></p>
		</div>
		<div class="cdash_block">
			<h3><?php echo __('Display Maps', 'cdash'); ?></h3>
			<p><span class="bold">[business_map]</span> - <?php echo __('Displays the directory listings in a map', 'cdash'); ?><br />
				<span class="bold"><?php echo __('Acepted Parameters:', 'cdash'); ?></span> Category, level, single_link, perpage, cluster, width, height
			</p>
			<p><a target="_blank" href="https://chamberdashboard.com/docs/plugin-features/business-directory/maps-display/"><?php echo __('Maps Shortcode Docs', 'cdash'); ?></a></p>
		</div>
		<div class="cdash_block">
			<h3><?php echo __('Setup Business Search Page', 'cdash'); ?></h3>
			<p><span class="bold">[business_search_form] & [business_search_results]</span> - <?php echo __('Displays a business directory search form and the search results page', 'cdash'); ?><br />
			</p>
			<p><a target="_blank" href="https://chamberdashboard.com/docs/plugin-features/business-directory/add-search-feature/"><?php echo __('Business Search Shortcode Docs', 'cdash'); ?></a></p>
		</div>
	</div>
</div>
<?php
}
?>
