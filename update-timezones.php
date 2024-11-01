<?php 
/*
Plugin Name: Update Time Zones Across Network
Description: Update the time zone settings for all blogs. Written with the intent of updating a bunch of blogs that were created prior to the WP 2.8 fix that addressed GMT and daylight savings. 
Version: 1.0
Author: oiler
License: GPL2
*/

add_action('network_admin_menu', 'run_add_submenu_page');

function run_add_submenu_page() {
	add_submenu_page( 'settings.php', 'Time Zone', 'Time Zone Update', 'Super Administrator', 'timezone', 'update_all_timezones' );
}

function update_all_timezones() {
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2 id="edit-super-admins">Update All Blog Time Zones</h2>
</div>

<p style="width:400px"><b>Description:</b> This plugin will automatically change the time zone for all of the blogs on this Network. Just select from the list below the time zone you wish to update all blogs to, and it'll loop through each and set the time zone while also clearing out the GMT offset that WordPress used to use. </p>

<p>Select your time zone from the list below:</p>

<form method="get" action="<?php echo esc_url( admin_url( 'network/settings.php'));?>">
	<?php wp_nonce_field('nonce_action','nonce_field'); ?>
	<input type="hidden" name="page" value="timezone">
	<select name="update_timezones">
		<option value="<?php esc_attr_e(''); ?>"></option>
		<option value="<?php esc_attr_e('America/New_York'); ?>">Eastern US</option>
		<option value="<?php esc_attr_e('America/Chicago'); ?>">Central US</option>
		<option value="<?php esc_attr_e('America/Denver'); ?>">Mountain US</option>
		<option value="<?php esc_attr_e('America/Los_Angeles'); ?>">Pacific US</option>
	</select>
	<input type="submit" value="<?php esc_attr_e('submit'); ?>">
</form>

<?php

function init_update_all_timezones($new_timezone) {
	global $wpdb;
	$get_blogs = $wpdb->get_results($wpdb->prepare("SELECT blog_id, domain FROM $wpdb->blogs"));
	echo '<p><b>Results:</b></p><ul>';
	foreach ( $get_blogs as $get_blog ) 
	{
		echo '<li>';
		$this_id = $get_blog->blog_id;
		$this_blog = $get_blog->domain;
		echo '<b>'.$this_blog.' (ID - '.$this_id.')</b><br>';
		run_update_all_timezones($this_id, $new_timezone);
		confirm_update_all_timezones($this_id, $new_timezone);
		echo '</li>';
	}
	echo '</ul><p>That\'s It. All done.';
}

function run_update_all_timezones($blog_id, $new_timezone) {
	global $wpdb;
	$blog_table = 'wp_'.$blog_id.'_options';
	$insert_data = array('option_value' => $new_timezone);
	$where_data = array('option_name' => 'timezone_string');
	$wpdb->update($blog_table, $insert_data, $where_data);

	//THIS WILL CLEAR OUT THE VALUE FOR THE OLD GMT SETTING
	$clear_data = array('option_value' => '');
	$gmt_where_data = array('option_name' => 'gmt_offset');
	$wpdb->update($blog_table, $clear_data, $gmt_where_data);
}

function confirm_update_all_timezones($blog_id, $new_timezone) {
	global $wpdb;
	$wpdb->set_blog_id($blog_id);
	$wpdb->set_prefix($wpdb->base_prefix);
	$confirm_update = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->options WHERE option_name LIKE 'timezone_string'"));
	if ($confirm_update) {
		foreach ($confirm_update as $confirm_item) { 
			echo 'New time zone:'.$confirm_item->option_value.'<br>'; 
		} 
	} else {
		echo 'New time zone: Null (probably a deleted blog)<br>';
	}
}

if ( empty($_GET) || !wp_verify_nonce($_GET['nonce_field'],'nonce_action') ) {
   exit;
} else {
	if ($_GET['update_timezones']) {
		$new_timezone = $_GET['update_timezones'];
		init_update_all_timezones(esc_attr($new_timezone));
		$new_timezone = '';
	}
}

}
