<?php

/**
 * WiseForms controller for forms.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsAdminFormsController extends WiseFormsController {

	protected $controllerId = 'wise-forms-forms';

	/**
	 * @var WiseFormsFormDAO
	 */
	private $formsDao;

	/**
	 * WiseFormsAdminFormsController constructor.
	 */
	public function __construct() {
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
	}

	public function run() {
		if ($this->hasParam('id')) {
			$this->objectAction();
		} else if ($this->hasParam('new')) {
			$this->newObjectAction();
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

	public function getNewUrl() {
		$data = array(
			'new' => 'x'
		);

		return $this->constructUrl($data);
	}

	public function getObjectSaveUrl($id) {
		$data = array(
			'id' => $id,
			'action' => 'form-save',
			'nonce' => wp_create_nonce('form-save')
		);

		return $this->constructUrl($data);
	}

	public function getObjectAddUrl() {
		$data = array(
			'action' => 'form-save',
			'nonce' => wp_create_nonce('form-save')
		);

		return $this->constructUrl($data);
	}

	protected function formSaveAction() {
		$id = intval($this->getParam('id'));

		if (!$this->verfiyNonce('form-save')) {
			$this->addErrorMessage('Invalid form.');
			$this->redirect($this->getIndexPageUrl());
		}

		$form = new WiseFormsForm();
		if ($id > 0) {
			$form = $this->formsDao->getById($id);
		}

		if ($form !== null) {
			$form->setName($this->getPostParam('name'));
			$this->formsDao->save($form);

			$this->addMessage('Form has been saved.');
			$this->redirect($this->getEditUrl($form->getId()));
		} else {
			$this->addErrorMessage('Form does not exist.');
			$this->redirect($this->getIndexPageUrl());
		}
	}

	private function indexAction() {
		$currentPage = $this->getCurrentPageNum();
		$objects = $this->formsDao->getAll($currentPage);
		$total = $this->formsDao->getAllCount();
		$totalPages = ceil($total / $this->formsDao->getLimit());

		$this->showView('admin/Forms', array(
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

	private function newObjectAction() {
		$this->showView('admin/FormAddEdit', array(
			'form' => new WiseFormsForm()
		));
	}

	private function objectAction() {
		$id = intval($this->getParam('id'));
		$form = $this->formsDao->getById($id);

		if ($form === null) {
			$this->redirect($this->getIndexPageUrl());
			return;
		}

		$this->showView('admin/FormAddEdit', array(
			'form' => $form,
		));
	}

}