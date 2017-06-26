<?php

/**
 * WiseForms installer.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsInstaller {

	public static function getFormsTable() {
		global $wpdb;

		return $wpdb->prefix.'wise_forms';
	}

	public static function getResultsTable() {
		global $wpdb;

		return $wpdb->prefix.'wise_forms_results';
	}

	/**
	 * Plugin's activation action. Creates database structure (if does not exist), upgrades database structure and
	 * initializes options.
	 *
	 * @param boolean $networkWide
	 */
	public static function activate($networkWide) {
		global $wpdb;

		self::doActivation();
	}

	private static function doActivation() {
		global $wpdb, $user_level, $sac_admin_user_level;
		
		if ($user_level < $sac_admin_user_level) {
			return;
		}

		$tableName = self::getFormsTable();
		$sql = "CREATE TABLE ".$tableName." (
				id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				name text NOT NULL,
				fields text,
				messages text,
				configuration text,
				created bigint(11) DEFAULT '0' NOT NULL
		) DEFAULT CHARSET=utf8;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		$tableName = self::getResultsTable();
		$sql = "CREATE TABLE ".$tableName." (
				id bigint(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				form_name text NOT NULL,
				form_id bigint(11) NOT NULL,
				result text,
				ip text,
				created bigint(11) DEFAULT '0' NOT NULL
		) DEFAULT CHARSET=utf8;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	/**
	 * Plugin's deactivation action.
	 */
	public static function deactivate() {
		global $wpdb, $user_level, $sac_admin_user_level;
		
		if ($user_level < $sac_admin_user_level) {
			return;
		}
	}

	/**
	 * Plugin's uninstall action. Deletes all database tables and plugin's options.
	 */
	public static function uninstall() {
		global $wpdb;

		self::doUninstall();
	}

	private static function doUninstall($refererCheck = null) {
		if (!current_user_can('activate_plugins')) {
			return;
		}
		if ($refererCheck !== null) {
			check_admin_referer($refererCheck);
		}

		global $wpdb;
		
		$tableName = self::getFormsTable();
		$sql = "DROP TABLE IF EXISTS {$tableName};";
		$wpdb->query($sql);

		$tableName = self::getResultsTable();
		$sql = "DROP TABLE IF EXISTS {$tableName};";
		$wpdb->query($sql);
		
		WiseFormsOptions::getInstance()->dropAllOptions();
	}
}