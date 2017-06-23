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
		$url = $this->constructUrl($data);
		if ($this->hasPostParam('tab')) {
			$url .= '#'.$this->getPostParam('tab');
		}

		return $url;
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

	public function getObjectDeleteUrl($id) {
		$data = array(
			'id' => $id,
			'action' => 'form-delete',
			'nonce' => wp_create_nonce('form-delete')
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
			$form->setFields($this->fillFieldsIDs($this->getPostParam('fields')));

			$messages = array();
			foreach (WiseFormsForm::$defaultMessages as $id => $message) {
				$messages[$id] = $this->getPostParam('message.'.$id);
			}
			$form->setMessages(json_encode($messages));

			$this->formsDao->save($form);

			$this->addMessage('Form has been saved.');
			$this->redirect($this->getEditUrl($form->getId()));
		} else {
			$this->addErrorMessage('Form does not exist.');
			$this->redirect($this->getIndexPageUrl());
		}
	}

	private function fillFieldsIDs($fieldsJSON) {
		$fields = json_decode($fieldsJSON, true);
		if (!is_array($fields)) {
			return $fieldsJSON;
		}

		$fields = $this->fillFieldsCollectionIDs($fields);


		return json_encode($fields);
	}

	private function fillFieldsCollectionIDs($fields) {
		foreach ($fields as $key => $field) {
			if (!is_array($field)) {
				continue;
			}

			// create and insert ID if it does not exist:
			if (!array_key_exists('id', $field)) {
				$id = 'wfField_'.sha1(microtime(true).rand(0, 100000).rand(100000, 500000));
				$fields[$key]['id'] = $id;
			}

			// iterate over container fields:
			if (array_key_exists('children', $field)) {
				$children = array();
				foreach ($field['children'] as $childrenFields) {
					$children[] = $this->fillFieldsCollectionIDs($childrenFields);
				}
				$fields[$key]['children'] = $children;
			}
		}

		return $fields;
	}

	protected function formDeleteAction() {
		$id = intval($this->getParam('id'));

		if (!$this->verfiyNonce('form-delete')) {
			$this->addErrorMessage('Invalid form.');
			$this->redirect($this->getIndexPageUrl());
		}

		$result = $this->formsDao->deleteById($id);
		if ($result) {
			$this->addMessage('Form has been deleted.');
			$this->redirect($this->getIndexPageUrl());
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

	/**
	 * @param WiseFormsForm $form
	 * @return array
	 */
	protected function getFormMessages($form) {
		$currentMessages = json_decode($form->getMessages(), true);
		if (!is_array($currentMessages)) {
			$currentMessages = array();
		}

		$messages = array();
		foreach (WiseFormsForm::$defaultMessages as $id => $message) {
			$messages[] = array(
				'id' => $id,
				'default' => $message,
				'value' => array_key_exists($id, $currentMessages) ? $currentMessages[$id] : $message
			);
		}

		return $messages;
	}

}