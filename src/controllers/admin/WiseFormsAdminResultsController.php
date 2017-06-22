<?php

/**
 * WiseForms controller for results.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsAdminResultsController extends WiseFormsController {

	protected $controllerId = 'wise-forms-results';

	/**
	 * @var WiseFormsResultDAO
	 */
	private $resultsDao;

	/**
	 * @var WiseFormsFormDAO
	 */
	private $formsDao;

	/**
	 * WiseFormsAdminResultsController constructor.
	 */
	public function __construct() {
		WiseFormsContainer::load('fields/WiseFormsFieldsUtils');
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
		$this->resultsDao = WiseFormsContainer::get('dao/WiseFormsResultDAO');
	}

	public function run() {
		if ($this->hasParam('id')) {
			$this->objectAction();
		} else {
			$this->indexAction();
		}
	}

	public function getEditUrl($id) {
		$data = array(
			'id' => $id
		);
		return $this->constructUrl($data);
	}

	public function getObjectDeleteUrl($id) {
		$data = array(
			'id' => $id,
			'action' => 'result-delete',
			'nonce' => wp_create_nonce('result-delete')
		);

		return $this->constructUrl($data);
	}

	protected function resultDeleteAction() {
		$id = intval($this->getParam('id'));

		if (!$this->verfiyNonce('result-delete')) {
			$this->addErrorMessage('Invalid result.');
			$this->redirect($this->getIndexPageUrl());
		}

		$result = $this->resultsDao->deleteById($id);
		if ($result) {
			$this->addMessage('The result has been deleted.');
			$this->redirect($this->getIndexPageUrl());
		} else {
			$this->addErrorMessage('The result does not exist.');
			$this->redirect($this->getIndexPageUrl());
		}
	}

	private function indexAction() {
		$currentPage = $this->getCurrentPageNum();
		$objects = $this->resultsDao->getAll($currentPage);
		$total = $this->resultsDao->getAllCount();
		$totalPages = ceil($total / $this->resultsDao->getLimit());

		$this->showView('admin/Results', array(
			'objects' => $objects,
			'total' => $total,
			'totalPages' => $totalPages,
			'currentPage' => $currentPage,
			'url' => $this->getIndexPageUrl(),
			'urlPageFirst' => $this->getIndexPageUrl(1),
			'urlPagePrevious' => $this->getIndexPageUrl($currentPage > 1 ? $currentPage - 1 : 1),
			'urlPageNext' => $this->getIndexPageUrl($currentPage < $totalPages ? $currentPage + 1 : $currentPage),
			'urlPageLast' => $this->getIndexPageUrl($totalPages),
		));
	}

	private function objectAction() {
		$id = intval($this->getParam('id'));
		$result = $this->resultsDao->getById($id);

		if ($result === null) {
			$this->redirect($this->getIndexPageUrl());
			return;
		}

		$form = $this->formsDao->getById($result->getFormId());

		$this->showView('admin/ResultView', array(
			'result' => $result,
			'form' => $form,
			'flatFields' => WiseFormsFieldsUtils::getFlatFieldsArray($form),
		));
	}

	/**
	 * @param array $fieldResult
	 *
	 * @return WiseFormsFieldProcessor
	 */
	protected function getFieldProcessor($fieldResult) {
		$processorClassName = 'WiseForms'.ucfirst($fieldResult['type']).'Processor';

		return WiseFormsContainer::get('fields/processing/'.$processorClassName);
	}

	protected function getFieldResultName($fieldResult, $flatFields) {
		$unknownLabel = '[undefined field]';
		if (!is_array($fieldResult)) {
			return $unknownLabel;
		}

		// first get the label from the form:
		if (is_array($flatFields)) {
			$id = $fieldResult['id'];
			foreach ($flatFields as $field) {
				if ($id == $field['id']) {
					return $field['label'];
				}
			}
		}

		// return name from the result itself:
		return array_key_exists('name', $fieldResult) ? $fieldResult['name'] : $unknownLabel;
	}
}