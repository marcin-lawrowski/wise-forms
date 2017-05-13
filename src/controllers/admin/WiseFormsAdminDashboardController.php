<?php

/**
 * WiseForms controller for dashboard.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsAdminDashboardController extends WiseFormsController {

	public function run() {
		$this->indexAction();
	}

	private function indexAction() {
		$this->showView('admin/Dashboard', array(

		));
	}

}