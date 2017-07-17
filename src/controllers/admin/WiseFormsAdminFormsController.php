<?php

/**
 * WiseForms controller for forms.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsAdminFormsController extends WiseFormsController {

	protected $controllerId = 'wise-forms-forms';

	/**
	 * @var WiseFormsResultDAO
	 */
	private $resultsDao;

	/**
	 * @var WiseFormsFormDAO
	 */
	private $formsDao;

	/**
	 * @var array
	 */
	private $wizardFields = array(
		'contact' => '[{"label":"Name:","placeholder":"Enter name here","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_ecfbc33e2123be30473bc4659d9166abaec8df27"},{"label":"E-mail:","placeholder":"Enter e-mail here","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_fb4bf9e0e7878a4cecb4b8974d2bb1167c5c6c30"},{"label":"Telephone:","placeholder":"Enter telephone here","required":false,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_60f5ab546eac305bae1a79c3cc13da814dd62338"},{"label":"Message:","placeholder":"Enter message here","required":true,"labelLocation":"top","width":"100%","height":"100","labelWidth":"","labelAlign":"left","type":"textArea","id":"wfField_067068c07eedc9f3be0aea15be88a8e9ae0ade49"},{"label":"Submit","align":"right","type":"buttonSubmit","id":"wfField_a5f020e9492637873f251175124f3db67d73732f"}]',
		'application' => '[{"label":"Which position are you applying for?","placeholder":"","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","options":[{"key":"PHP Engineer","value":"PHP Engineer"},{"key":"Java Engineer","value":"Java Engineer"},{"key":"Manager","value":"Manager"}],"type":"dropDownList","id":"wfField_b051e5850210cfdcc76200e3eda1085d24464cc6"},{"label":"Are you willing to relocate?","required":true,"labelLocation":"top","labelWidth":"","labelAlign":"left","options":[{"key":"Yes","value":"Yes"},{"key":"No","value":"No"}],"type":"radioButtons","id":"wfField_2c7aaddd69f9bfa30aa78ed0b7f1e866eea007ae"},{"label":"Your name:","placeholder":"Enter your name","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_94a991d417cc85d26992a85ee672768176bfda3f"},{"label":"Home address:","placeholder":"Enter your home address","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_8da10b9567e8d2426b87d0cb57e51ba96d176ba8"},{"label":"Your e-mail:","placeholder":"Enter your e-mail","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_003b615e2d084a5791e2021783094f2b7f20acea"},{"label":"Phone:","placeholder":"Enter your phone number","required":true,"labelLocation":"top","width":"100%","labelWidth":"","labelAlign":"left","type":"textInput","id":"wfField_2b9283abee2d6d7ee6105339da7163863bd831a6"},{"label":"Resume:","placeholder":"Put your resume here","required":true,"labelLocation":"top","width":"100%","height":"200","labelWidth":"","labelAlign":"left","type":"textArea","id":"wfField_1ab44f3de00d9063e794c7b538b2903c00cece07"},{"label":"Send Application","align":"right","type":"buttonSubmit","id":"wfField_c4e58aa6762f169fc1d43e822b5cc28131db11db"}]'
	);

	/**
	 * WiseFormsAdminFormsController constructor.
	 */
	public function __construct() {
		$this->resultsDao = WiseFormsContainer::get('dao/WiseFormsResultDAO');
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
	}

	public function run() {
		if ($this->hasParam('wizard')) {
			$this->wizardAction();
		} else if ($this->hasParam('id')) {
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
	public function getWizardUrl() {
		$data = array(
			'wizard' => 'x'
		);

		return $this->constructUrl($data);
	}

	public function getWizardDoneUrl($id) {
		$data = array(
			'wizard' => 'x',
			'id' => $id
		);
		$url = $this->constructUrl($data);

		return $url;
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

	public function getObjectCloneUrl($id) {
		$data = array(
			'id' => $id,
			'action' => 'form-clone',
			'nonce' => wp_create_nonce('form-clone')
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

	public function getWizardAddUrl() {
		$data = array(
			'action' => 'form-wizard-save',
			'nonce' => wp_create_nonce('form-wizard-save')
		);

		return $this->constructUrl($data);
	}

	protected function formWizardSaveAction() {
		if (!$this->verfiyNonce('form-wizard-save')) {
			$this->addErrorMessage('Invalid form.');
			$this->redirect($this->getIndexPageUrl());
		}

		$form = new WiseFormsForm();
		$form->setName($this->getPostParam('name'));
		$form->setFields($this->wizardFields[$this->getPostParam('type')]);

		// messages:
		$messages = array();
		foreach (WiseFormsForm::$defaultMessages as $id => $message) {
			$messages[$id] = $message;
		}
		$form->setMessages(json_encode($messages));

		// configuration:
		$configuration = array();
		foreach (WiseFormsForm::$defaultConfiguration as $id => $configurationValue) {
			if ($id == 'notifications.email.recipient') {
				$configurationValue = $this->getPostParam('email');
			}
			$configuration[$id] = $configurationValue;
		}
		$form->setConfiguration(json_encode($configuration));

		$this->formsDao->save($form);

		$this->addMessage('A new form has been created.');
		$this->redirect($this->getWizardDoneUrl($form->getId()));
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

			// messages:
			$messages = array();
			foreach (WiseFormsForm::$defaultMessages as $id => $message) {
				$messages[$id] = $this->getPostParam('message.'.$id);
			}
			$form->setMessages(json_encode($messages));

			// configuration:
			$configuration = array();
			foreach (WiseFormsForm::$defaultConfiguration as $id => $configurationValue) {
				$configuration[$id] = $this->getPostParam($id);
			}
			$form->setConfiguration(json_encode($configuration));

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

	protected function formCloneAction() {
		$id = intval($this->getParam('id'));

		if (!$this->verfiyNonce('form-clone')) {
			$this->addErrorMessage('Invalid form.');
			$this->redirect($this->getIndexPageUrl());
		}

		$form = $this->formsDao->getById($id);
		if ($form !== null) {
			$this->formsDao->cloneObject($form);
			$this->addMessage('Form has been cloned.');
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

	private function wizardAction() {
		$id = intval($this->getParam('id'));
		$form = $this->formsDao->getById($id);

		$this->showView('admin/FormWizard', array(
			'form' => $form
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
			'resultsCount' => $this->resultsDao->getAllCount($form->getId())
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