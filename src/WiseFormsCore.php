<?php

/**
 * WiseForms core initializer.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsCore {

	/**
	 * @var string[] Admin JS files.
	 */
	private $jsAssetsAdmin = array(
		'cbpFWTabs.js',
		'core.js',
	);

	/**
	 * @var string[] Admin CSS files.
	 */
	private $cssAssetsAdmin = array(
		'core.css',
		'tabs.css',
	);

	public function init() {
		WiseFormsContainer::load('controllers/WiseFormsController');

		add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'), 11);
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

	public function enqueueAdminAssets() {
		$prefix = 'wise-forms-';
		$pluginData = get_plugin_data( dirname(__DIR__).'/wise-forms-core.php' );
		$pluginVersion = $pluginData['Version'];

		$jsAssetsPath = plugin_dir_url( __DIR__ ).'assets/js/admin/';
		foreach ($this->jsAssetsAdmin as $jsFile) {
			wp_register_script($prefix.$jsFile, $jsAssetsPath.$jsFile, array('jquery'), $pluginVersion, true);
			wp_enqueue_script($prefix.$jsFile);
		}

		$cssAssetsPath = plugin_dir_url( __DIR__ ).'assets/css/admin/';
		foreach ($this->cssAssetsAdmin as $cssFile) {
			wp_register_style($prefix.$cssFile, $cssAssetsPath.$cssFile, array(), $pluginVersion);
			wp_enqueue_style($prefix.$cssFile);
		}
	}

}