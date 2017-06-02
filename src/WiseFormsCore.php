<?php

/**
 * WiseForms core initializer.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsCore {

	/**
	 * @var string[] JS files.
	 */
	private $jsAssets = array(
		'form.js',
		'core.js'
	);

	/**
	 * @var string[] CSS files.
	 */
	private $cssAssets = array(
		'form.css',
	);

	/**
	 * @var string[] Admin JS files.
	 */
	private $jsAssetsAdmin = array(
		'cbpFWTabs.js',
		'core-fields.js',
		'core-designer.js',
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
		WiseFormsContainer::load('shortcodes/WiseFormsShortcode');

		add_action('wp_enqueue_scripts', array($this, 'enqueueAssets'), 11);
		add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'), 11);
		add_action('admin_menu', array($this, 'initAdminMenu'));

		// register shortcodes:
		add_shortcode('wise-forms', array(WiseFormsContainer::get('shortcodes/WiseFormsFormShortcode'), 'render'));
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
		$prefix = 'wise-forms-admin-';
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

	public function enqueueAssets() {
		$prefix = 'wise-forms-';

		$jsAssetsPath = plugin_dir_url( __DIR__ ).'assets/js/front-end/';
		foreach ($this->jsAssets as $jsFile) {
			wp_register_script($prefix.$jsFile, $jsAssetsPath.$jsFile, array('jquery'));
			wp_enqueue_script($prefix.$jsFile);
		}

		$cssAssetsPath = plugin_dir_url( __DIR__ ).'assets/css/front-end/';
		foreach ($this->cssAssets as $cssFile) {
			wp_register_style($prefix.$cssFile, $cssAssetsPath.$cssFile, array());
			wp_enqueue_style($prefix.$cssFile);
		}
	}

}