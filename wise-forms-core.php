<?php
/*
	Plugin Name: Wise Forms
	Version: 1.2.0
	Plugin URI: http://kaine.pl/
	Description: Wise Forms is a plugin for displaying and submitting forms in WordPress. The plugin is extremely configurable and easy installable. It has a growing list of features and constant support.
	Author: Marcin Ławrowski
	Author URI: http://kaine.pl
*/

require_once(dirname(__FILE__).'/src/WiseFormsContainer.php');
WiseFormsContainer::load('WiseFormsInstaller');
WiseFormsContainer::load('WiseFormsOptions');

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