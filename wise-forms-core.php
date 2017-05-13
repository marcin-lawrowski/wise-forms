<?php
/*
	Plugin Name: Wise Forms
	Version: 1.0.0
	Plugin URI: http://kaine.pl/
	Description: forms
	Author: Kainex
	Author URI: http://kaine.pl
*/

require_once(dirname(__FILE__).'/src/WiseFormsContainer.php');
WiseFormsContainer::load('WiseFormsInstaller');
WiseFormsContainer::load('WiseFormsOptions');

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (is_admin()) {
	// installer:
	register_activation_hook(__FILE__, array('WiseFormsInstaller', 'activate'));
	register_deactivation_hook(__FILE__, array('WiseFormsInstaller', 'deactivate'));
	register_uninstall_hook(__FILE__, array('WiseFormsInstaller', 'uninstall'));

	add_action('admin_enqueue_scripts', function() {
		wp_enqueue_media();
	});
}

WiseFormsContainer::get('WiseFormsCore')->init();