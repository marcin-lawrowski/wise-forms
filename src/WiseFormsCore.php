<?php

/**
 * WiseForms core initializer.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsCore {

	public function init() {
		WiseFormsContainer::load('controllers/WiseFormsController');

		add_action('admin_menu', array($this, 'initAdminMenu'));
	}

	public function initAdminMenu() {
		add_menu_page('Wise Forms', 'Wise Forms', 'manage_options', 'wise-forms-dashboard', '', 'dashicons-feedback');
		add_submenu_page('wise-forms-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'wise-forms-dashboard', array($this, 'adminDashboardAction'));
		add_submenu_page('wise-forms-dashboard', 'Forms', 'Forms', 'manage_options', 'wise-forms-forms', array($this, 'adminFormsAction'));
	}

	public function adminDashboardAction() {
		WiseFormsContainer::get('controllers/admin/WiseFormsAdminDashboardController')->execute();
	}

	public function adminFormsAction() {
		WiseFormsContainer::get('controllers/admin/WiseFormsAdminFormsController')->execute();
	}

}